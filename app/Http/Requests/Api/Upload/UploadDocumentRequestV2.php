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

class UploadDocumentRequestV2 extends FormRequest
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
        return [
            // $this->file_field => 'required|emimes:' . $mime_types,
            'title'     => 'required|string',
            'file_name' => 'required|string',
            'extension' => 'required|string',
            'file_size' => 'required|int',
            'root_id' => 'required|int'
        ];
    }

    /**
     * @throws Exception
     */
    protected function parseInfo(): void
    {
        $document_info = [];
        $this->request->add(['uploaded_ip' => get_user_ip_address()]);
        $ext = $this->get('extension');
        if (!$ext || !in_array($ext, DocumentExt::getKeys())) {
            throw new ValidateFailedException('File extension is not valid : ' . $ext);
        }

        $title = TitleService::bestTitle($this->get('title', ''), $this->get('file_name'));
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
            'content_words'      => Arr::get($document_info, 'words', 0),
            'original_size'      => $this->get('file_size')
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
     * @throws ValidateFailedException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        throw new ValidateFailedException($validator->errors()->first());
    }
}
