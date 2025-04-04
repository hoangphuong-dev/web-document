<?php

namespace App\Data\Document;

use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;

class CoverData extends Data
{
    public function __construct(
        public array|string|null $authors,
        public array|string|null $organization,
        public ?string $field,
        public ?string $problem,
        public ?string $solution,
        public ?string $type,
        public ?string $implementationYear,
        public ?string $results,
        public ?string $recognitionLevel,
        public ?string $location,

    ) {
        if (!empty($this->authors) && is_array($this->authors)) {
            $this->authors = Arr::first($this->authors);
        }

        if (!empty($this->organization) && is_array($this->organization)) {
            $this->organization = Arr::first($this->organization);
        }
    }
}
