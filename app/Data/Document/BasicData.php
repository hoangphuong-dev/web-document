<?php

namespace App\Data\Document;

use Spatie\LaravelData\Data;

class BasicData extends Data
{
  public function __construct(
    public ?int $id,
    public ?string $name,
  ) {}
}
