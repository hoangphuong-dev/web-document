<?php

namespace App\Http\Controllers\Api\Upload;

use App\Enums\ActiveStatus;
use App\Enums\Document\ConvertStatus;
use App\Enums\Document\DocumentExt;
use App\Enums\Document\DocumentStatus;
use App\Exceptions\Api\ApiFailedException;
use App\Http\Controllers\Api\BaseAPIController;
use App\Http\Requests\Api\Upload\UpdateDocumentRequest;
use App\Http\Requests\Api\Upload\UploadDocumentRequest;
use App\Http\Requests\Api\Upload\UploadDocumentRequestV2;
use App\Models\Document;
use App\Models\DocumentMetaData;
use App\Services\Document\DocumentService;
use App\Services\Tag\TagService;
use App\Services\Topic\TopicService;
use App\Services\Upload\DocumentUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class DocumentController extends BaseAPIController
{
    public function relatedByTopic(int $documentId): JsonResponse
    {
        try {
            $document      = Document::whereId($documentId)->with('topics')->first();
            $documentTopic = TopicService::related($document);
            $documentTag   = $documentTopic->count() > 5 ? TagService::related($documentTopic->pluck('document_id')) : $documentTopic;
            $documents     = DocumentService::getDocumentByIds($documentTag->pluck('document_id')->toArray());
            return static::success(['documents' => $documents]);
        } catch (\Exception $e) {
            Log::error(format_log_message($e));
            throw new ApiFailedException($e->getMessage());
        }
    }

    public function uploadDocument(UploadDocumentRequestV2 $request)
    {
        try {
            $data = [
                'owner_id'    => 1,
                'uploaded_ip' => $request->get('uploaded_ip'),
                'title'       => $request->get('title'),
                'slug'        => $request->get('slug'),
                'number_page' => rand(20, 100),
                'file_size'   => $request->get('original_size'),
                'ext'         => DocumentExt::fromKey($request->get('original_ext')),
                'status'      => DocumentStatus::WAIT_APPROVE,
                'active'      => ActiveStatus::INACTIVE,
            ];

            $fileName = generate_name($request->get('file_name'));
            $document = DocumentUploadService::storeV2($fileName, $data);
            $document->tmpUpload()->create(['root_id' => $request->get('root_id')]);  //* save tmp upload
            return static::success($document);
        } catch (\Exception $e) {
            Log::error(format_log_message($e));
            throw new ApiFailedException($e->getMessage());
        }
    }

    public static function updateDocument(UpdateDocumentRequest $request)
    {
        try {
            $document = DocumentService::first($request->get('id'));
            throw_if(empty($document), new ApiFailedException('Không tồn tại tài liệu này !'));
            $data = [
                'title'          => $request->get('title'),
                'slug'           => $request->get('slug'),
                'ai_title'       => $request->get('ai_title'),
                'h1'             => $request->get('h1'),
                'category_id'    => $request->get('category_id'),
                'money_sale'     => $request->get('money_sale'),
                'ai_description' => $request->get('description'),
                'status'         => DocumentStatus::APPROVED,
                'active'         => ActiveStatus::ACTIVE,
            ];

            $document = DocumentUploadService::updateDocument($document, $data);
            return static::success($document);
        } catch (\Exception $e) {
            Log::error(format_log_message($e));
            throw new ApiFailedException($e->getMessage());
        }
    }

    /**
     * Chỉ cập nhật dữ liệu trong bảng meta_data
     *
     * @param string $field
     * @param Request $request
     * 
     */
    public function updateOneField(string $field, Request $request): JsonResponse
    {
        $isUpdate = in_array($field, ['ai_title', 'ai_description', 'ai_heading', 'ai_summary', 'ai_cover', 'ai_topical']);
        throw_unless($isUpdate, new ApiFailedException('Field chưa có quyền update!'));
        try {
            $validated = $request->validate([
                'document_id' => 'required',
                "{$field}"    => 'required',
            ]);
            $metaData = DocumentMetaData::updateOrCreate(
                ['document_id' => $validated['document_id']],
                [$field => Arr::get($validated, $field)],
            );
            return static::success(['document_id' => $metaData->document_id, "{$field}" => $metaData->{$field}]);
        } catch (\Exception $e) {
            Log::error(format_log_message($e));
            throw new ApiFailedException($e->getMessage());
        }
    }

    public static function updateConvertStatus(Request $request)
    {
        try {
            $document = DocumentService::first($request->get('document_id'));
            throw_if(empty($document), new ApiFailedException('Không tồn tại tài liệu này !'));

            $status = (int)$request->get('convert_status');
            throw_unless(in_array($status, ConvertStatus::getValues()));

            $document->convert_status = $status;
            $document->save();
            return static::success(['id' => $document->id, 'convert_status' => $status]);
        } catch (\Exception $e) {
            Log::error(format_log_message($e));
            throw new ApiFailedException($e->getMessage());
        }
    }

    public static function updateNumberPage(Request $request)
    {
        try {
            $document = DocumentService::first($request->get('document_id'));
            throw_if(empty($document), new ApiFailedException('Không tồn tại tài liệu này !'));

            $number_page = (int)$request->get('number_page');
            $document->number_page = $number_page;
            $document->save();
            return static::success(['id' => $document->id, 'number_page' => $number_page]);
        } catch (\Exception $e) {
            Log::error(format_log_message($e));
            throw new ApiFailedException($e->getMessage());
        }
    }
}
