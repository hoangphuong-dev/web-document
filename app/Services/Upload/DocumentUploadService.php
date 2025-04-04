<?php

namespace App\Services\Upload;

use App\Models\Document;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DocumentUploadService
{

    public static function storeV2(string $fileName, array $data)
    {
        $data['file_name'] = $fileName;
        $data['path']      = now()->format('Y_m/d');;
        return Document::query()->create($data);
    }

    public static function store(UploadedFile $file, array $data)
    {
        $forder   = now()->format('Y_m/d');
        $fileName = generate_name($file->getClientOriginalName() . '.' . $file->getClientOriginalExtension());
        $path     = $forder . "/" . $fileName;
        if (Storage::disk('original')->put($path, $file->getContent())) {
            $data['file_name'] = $fileName;
            $data['path']      = $forder;
            return Document::query()->create($data);
        }
        throw new Exception("Can't save file to path: {$path}");
    }

    private static function updateOrCreateMetaData(Document $document, array $data)
    {
        if (Arr::hasAny($data, ['ai_title', 'h1', 'ai_description'])) {
            $document->metaData()->updateOrCreate(
                ['document_id' => $document->id],
                [
                    'ai_title'       => Arr::get($data, 'ai_title'),
                    'ai_heading'     => Arr::get($data, 'h1'),
                    'ai_description' => Arr::get($data, 'ai_description'),
                ]
            );
        }
    }

    public static function updateDocument(Document $document, array $data): Document
    {
        static::updateOrCreateMetaData($document, $data); 
        $dataUpdate = Arr::only($data, ['title', 'category_id', 'money_sale', 'active', 'status', 'slug']);
        foreach (array_keys($dataUpdate) as $field) {
            $document->{$field} = Arr::get($dataUpdate, $field);
        }
        $document->save();
        return $document;
    }
}
