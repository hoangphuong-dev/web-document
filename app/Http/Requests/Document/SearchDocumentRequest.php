<?php

namespace App\Http\Requests\Document;

use App\Enums\Document\DocIsSell;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

/**
 * [Description SearchDocumentRequest]
 */
class SearchDocumentRequest extends FormRequest
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
        return [];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function prepareForValidation()
    {
        $order = match ((int)$this->request->get('sort')) {
            1       => 'doc_date_create',
            2       => 'doc_downloads',
            3       => 'doc_views',
            default => null,
        };

        // $price = match ((int)$this->request->get('is_sell')) {
        //     1       => (string) DocIsSell::FREE()->value,
        //     2       => (string) DocIsSell::SELL()->value,
        //     default => null,
        // };

        $pageRange = match ((int) $this->request->get('length')) {
            1       => ['start' => 1, 'end' => 4],
            2       => ['start' => 5, 'end' => 20],
            3       => ['start' => 21, 'end' => 100],
            4       => ['start' => 100, 'end' => 1000],
            default => null,
        };

        $ext     = $this->request->get('ext');
        $advance = $this->request->get('advanced');

        $this->request->add([
            'page'       => $this->request->get('page'),
            'cat_id'     => $this->request->get('cat_id'),
            'cat_level'  => $this->request->get('cat_level'),
            'user_id'    => $this->request->get('user_id'),
            'ext'        => $ext > 0 ? $ext : null,
            'advanced'   => $advance > 0 ? $advance : null,
            'per_page'   => 20,
            'desc_by'    => $order,
            // 'price'      => $price,
            'page_range' => $pageRange,
        ]);
    }

    /**
     * Get the validated data from the request.
     *
     * @param  array|int|string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function validated($key = null, $default = null)
    {
        return Arr::only(
            $this->validationData(),
            [
                'page',
                'cat_id',
                'cat_level',
                'user_id',
                'ext',
                'advanced',
                'per_page',
                'desc_by',
                'price',
                'page_range',
            ]
        );
    }
}
