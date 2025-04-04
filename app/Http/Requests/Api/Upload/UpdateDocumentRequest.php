<?php

namespace App\Http\Requests\Api\Upload;

use App\Exceptions\Api\ValidateFailedException;
use App\Services\Document\DocumentService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $maxMoney = config('document.validator.default.sale_document.max_price');
        return [
            'id'          => ['required', 'integer'],
            'title'       => 'required|string|min_words:2',
            'category_id' => 'required|integer',
            'slug'        => 'required|string',
            'ai_title'    => 'nullable|string',
            'h1'          => 'nullable|string',
            'description' => 'nullable|string',
            'money_sale'  => "nullable|numeric|max:{$maxMoney}|min:0",
        ];
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), [
            // 'title.required'   => 'Bạn chưa nhập tiêu đề!',
            // 'category_id.required' => 'Bạn chưa chọn thể loại',
        ]);
    }

    /**
     * @throws UploadFailed
     */
    protected function passedValidation()
    {
        $title  = $this->get('title', '');
        if ($this->get('money_sale', 0) > 0) {
            $this->saleDocument();
        }

        $this->request->add([
            // todo: get user ID update
            'user_id'     => 1,
            'title'       => $title,
            'category_id' => $this->get('category_id'),
        ]);
    }

    /**
     * @throws UploadFailed
     */
    protected function saleDocument()
    {
        $moneySale = $this->get('money_sale', 0);
        //Check số tiền bán.
        if (
            $moneySale < config('document.validator.default.sale_document.min_price')
            || $moneySale > config('document.validator.default.sale_document.max_price')
        ) {
            throw new ValidateFailedException(
                'Số tiền bán phải lớn hơn hoặc bằng '
                    . number_format(config('document.validator.default.sale_document.min_price'), 0, ',', '.')
                    . ', nhỏ hơn hoặc bằng '
                    . number_format(config('document.validator.default.sale_document.max_price'), 0, ',', '.'),
            );
        }
        $moneySale = ceil($moneySale / 1000) * 1000;
        $this->request->add([
            'money_sale' => $moneySale,
        ]);
    }

    /**
     * @throws ValidateFailedException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        throw new ValidateFailedException($validator->errors()->first());
    }
}
