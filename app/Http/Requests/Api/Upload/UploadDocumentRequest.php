<?php

namespace App\Http\Requests\Api\Upload;

use App\Enums\Document\DocumentExt;
use App\Exceptions\Api\InvalidDocumentException;
use App\Exceptions\Api\ValidateFailedException;
use App\Models\Document;
use App\Services\Document\TitleService;
use Helpers\Formatter;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected string $file_field = 'file';

    protected DocumentFileValidator $document_validator;

    /**
     * @throws Exception
     */
    protected function prepareForValidation(): void
    {
        $this->parseInfo();

        $this->document_validator = new DocumentFileValidator(
            config('document.validator.default.max_size'),
            config('document.validator.default.min_size'),
            config('document.validator.default.min_page'),
            config('document.validator.default.min_words'),
            config('document.validator.default.min_chars'),
            config('document.validator.default.lang'),
            Arr::only(DocumentExt::asArray(), config('document.validator.default.extensions')),
        );

        $this->customValidator();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $mime_types = DocumentExt::getKeys();
        $mime_types = implode(',', $mime_types);

        return [
            $this->file_field => 'required|emimes:' . $mime_types,
            'title'           => 'required|string'
        ];
    }

    /**
     * @throws Exception
     */
    protected function parseInfo(): void
    {
        // upload chunked file
        $this->upload();

        /** @var UploadedFile $file */
        $file = $this->file($this->file_field);
        if (!$file) {
            throw new ValidateFailedException('File upload error ' . $this->file_field);
        }

        $this->request->add(['uploaded_ip' => get_user_ip_address()]);
        $document_info = [
            'size'      => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'title'     => $this->get('title', ''),
        ];

        $ext = Arr::get($document_info, 'extension');
        if (!$ext || !in_array($ext, DocumentExt::getKeys())) {
            throw new ValidateFailedException('File extension is not valid : ' . $ext);
        }

        $title = TitleService::bestTitle(Arr::get($document_info, 'title', ''), $file->getClientOriginalName());
        $slug = Formatter::slug($title);
        if ($this->duplicatedTitle($title, $slug)) {
            throw new ValidateFailedException("Duplicated title: {$title}");
        }
        $this->request->add([
            'title'              => $title,
            'slug'               => $slug,
            'pages'              => Arr::get($document_info, 'pages', 0),
            'original_ext'       => DocumentExt::fromKey($ext)->key,
            'content_characters' => Arr::get($document_info, 'characters', 0),
            'content_words'      => Arr::get($document_info, 'words', 0),
            'original_size'      => $file->getSize(),
        ]);

        // check duplicated document
        $this->checkHashFile();
    }

    public function duplicatedTitle(string $title, $slug)
    {
        $slug = Formatter::slug($title);
        return Document::where('title', $title)->orWhere('slug', $slug)->exists();
    }

    // todo: check hashfile by search engine
    protected function checkHashFile() {}

    protected function customValidator(): void
    {
        Validator::extend('emimes', function ($attribute, $value, $parameters) {
            /** @var UploadedFile $value */
            // if (!$this->validator->isValidFileInstance($value)) {
            //     return false;
            // }

            try {
                $this->document_validator->check($this->all());

                return true;
            } catch (InvalidDocumentException $e) {
                $this->validator->errors()->add('document', $e->getMessage());

                return false;
            } catch (Exception $e) {
                Log::alert('Uploading document [' . get_class($e) . ']::' . $e->getMessage());
                $this->validator->errors()->add('document', 'Document or server error');

                return false;
            }
        }, trans('validation.mimes'));
        Validator::replacer('emimes', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':values', implode(', ', $parameters), $message);
        });
    }

    /**
     * Handles the file upload
     *
     * @throws ValidateFailedException
     */
    private function upload(): void
    {
        // create the file receiver
        try {
            $receiver = new FileReceiver($this->file_field, $this, HandlerFactory::classFromRequest($this));
        } catch (Exception $exception) {
            throw new ValidateFailedException($exception->getMessage());
        }

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new ValidateFailedException('The request is missing a file');
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            $this->request->add([
                $this->file_field => $save->getFile(),
            ]);
        }
    }

    /**
     * @throws ValidateFailedException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        throw new ValidateFailedException($validator->errors()->first());
    }
}
