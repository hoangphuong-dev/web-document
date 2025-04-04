<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\ApiFailedException;
use App\Jobs\System\SyncAiTagJob;
use App\Jobs\System\SyncAiTopicJob;
use App\Models\Tag;
use App\Models\Topic;
use App\Services\Document\DocumentService;
use App\Services\Tag\TagService;
use App\Services\Topic\TopicService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class TagTopicController extends BaseAPIController
{

    /**
     * Cập nhật ai_title, ai_description cho tags or topics
     *
     * @return [type]
     * 
     */
    public function updateSeo(Request $request)
    {
        try {
            $request->validate([
                'id'             => 'required',
                'type'           => 'required|in:tags,topics',
                'ai_title'       => 'required|string',
                'ai_description' => 'required|string',
            ]);

            $modelClass = $request->type === 'tags' ? Tag::class : Topic::class;
            $model = $modelClass::whereId($request->id)->firstOrFail();

            $model->ai_title = $request->ai_title;
            $model->ai_description = $request->ai_description;
            $model->save();

            return static::success([
                'type'  => $request->type,
                'model' => $model,
            ]);
        } catch (\Exception $e) {
            Log::error(format_log_message($e));
            throw new ApiFailedException($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     * 
     */
    public function make(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'document_id' => 'required',
                'tag_name'    => 'required|array',
                'topic_name'  => 'required|array',
            ]);

            $document = DocumentService::first($request->document_id);
            throw_unless($document, new Exception('Tài liệu không tồn tại!'));

            $tags   = TagService::makeTagDocument($document, $request->tag_name);
            $topics = TopicService::makeTopicDocument($document, $request->topic_name);

            $docMetaData = $document->metaData;
            SyncAiTagJob::dispatch($docMetaData);
            SyncAiTopicJob::dispatch($docMetaData);

            return static::success([
                'document_id' => $request->document_id,
                'tags'        => $tags,
                'topics'      => $topics,
            ]);
        } catch (\Exception $e) {
            Log::error(format_log_message($e));
            throw new ApiFailedException($e->getMessage());
        }
    }
}
