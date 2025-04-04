<?php

namespace App\Http\Requests\Api\Upload;

use App\Exceptions\Api\InvalidDocumentException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Number;

class DocumentFileValidator extends FormRequest
{
    /**
     * DocumentFileValidator constructor.
     */
    public function __construct(
        protected int $max_file_size,
        protected int $min_file_size,
        protected int $min_pages,
        protected int $min_words,
        protected int $min_characters,
        protected array $language,
        protected array $extensions,
    ) {
    }

    /**
     * Check pages, content_characters, content_words, language, and original_ext
     *
     *
     * @throws InvalidDocumentException
     */
    public function check(array $data = []): array
    {
        // file size
        $max_size   = $this->max_file_size * 1024 * 1024;
        $min_size   = $this->min_file_size * 1024 * 1024;
        if (Arr::get($data, 'original_size', 0) > $max_size) {
            throw new InvalidDocumentException('Kích thước file quá lớn, kích thước tối đa cho phép ' . Number::fileSize($max_size));
        }

        if (Arr::get($data, 'original_size', 0) < $min_size) {
            throw new InvalidDocumentException('Kích thước file quá nhỏ, kích thước tối thiểu cho phép ' . Number::fileSize($min_size));
        }

        // pages
        if (Arr::get($data, 'pages', 0) < $this->min_pages) {
            throw new InvalidDocumentException('Document too short, it have '
                . $data['pages']
                . ' pages but system required '
                . $this->min_pages . ' pages');
        }

        // content_characters
        if (Arr::get($data, 'content_characters', 0) < $this->min_characters) {
            throw new InvalidDocumentException('Document too short, it have '
                . Arr::get($data, 'content_characters', 0)
                . ' characters but system required '
                . $this->min_characters . ' characters');
        }

        // content_words
        if (Arr::get($data, 'content_words', 0) < $this->min_words) {
            throw new InvalidDocumentException('Document too short, it have '
                . Arr::get($data, 'content_words')
                . ' words but system required '
                . $this->min_words . ' words');
        }

        // language
        if (
            !in_array($lang = Arr::get($data, 'language'), $this->language)
            && !in_array('*', $this->language)
        ) {
            throw new InvalidDocumentException("This document language ({$lang}) is not valid, supported language are " . implode(',', $this->language));
        }

        //original_extension
        if (!is_numeric($ext = Arr::get($data, 'original_ext'))) {
            if (!Arr::exists($this->extensions, $ext)) {
                throw new InvalidDocumentException("This document extension ({$ext}) is not valid, supported language are " . implode(',', array_flip($this->extensions)));
            }
            $data['original_ext'] = Arr::get($this->extensions, $ext);
        } elseif (!Arr::exists($this->extensions, $ext)) {
            throw new InvalidDocumentException("This document extension ({$ext}) is not valid, supported language are " . implode(',', array_flip($this->extensions)));
        }

        return $data;
    }
}
