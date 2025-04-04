<?php

use App\Http\Controllers\Api\TagTopicController;
use App\Http\Controllers\Api\Upload\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('related-topic/{id}', [DocumentController::class, 'relatedByTopic']);
Route::post('upload-document', [DocumentController::class, 'uploadDocument']);
Route::post('update-number-page', [DocumentController::class, 'updateNumberPage']);
Route::post('update-document', [DocumentController::class, 'updateDocument']);
Route::post('update-convert-status', [DocumentController::class, 'updateConvertStatus']);
Route::post('update-field/{field}', [DocumentController::class, 'updateOneField']);
Route::post('make-tag-topic', [TagTopicController::class, 'make']);
Route::post('update-seo-tag-topic', [TagTopicController::class, 'updateSeo']);
