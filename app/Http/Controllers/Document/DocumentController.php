<?php

namespace App\Http\Controllers\Document;

use App\Enums\Common\AlertType;
use App\Helpers\URLGenerate;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentMetaData;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentViewService;
use App\Services\Document\TitleService;
use App\Services\Payment\PaymentNotLoginService;
use App\Services\SEO\SeoService;
use \Illuminate\Contracts\View\View;
use \Illuminate\Contracts\View\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use TypeError;

class DocumentController extends Controller
{
    public function paymentNotLogin(Document $document)
    {
        PaymentNotLoginService::getUser($document->id);
        SeoService::seoTitle("Thanh toán tài liệu");
        SeoService::setRobots('noindex, nofollow');
        return view('documents.payment-not-login', [
            'document' => $document,
        ]);
    }

    private function seo(Document $document, ?DocumentMetaData $docMeta)
    {
        $titleSeo = $docMeta?->ai_title ?? TitleService::shortTitle($document);
        SeoService::seoTitle($titleSeo);
        SeoService::seoDescription($docMeta->ai_description ?? '');
        SeoService::seoImage($document->urlThumbnail());
        SeoService::setCanonical(URLGenerate::urlDocumentDetail($document));
        SeoService::addJsonLdDocument($document, $docMeta);
    }

    public function show(?string $slug, Document $document)
    {
        //! Load trước metaData => Không di chuyển vị trí dòng này
        $docMetaData = $document->load('metaData')->metaData;

        // check quyền view tài liệu
        $this->authorize('viewDetail', $document);

        // check redirect nếu không đúng uuid
        try {
            $uuid   = Arr::last(explode('/', request()->path()));
            $realId = Arr::first(DocumentService::getHashHandler()->decode($uuid));
        } catch (\Exception | TypeError $ex) {
            Log::error(format_log_message($ex));
            $realId = -1; // nếu uuid bị sửa lại trên url
        }

        if ($realId != $document->id) {
            return redirect()->to(URLGenerate::urlDocumentDetail($document));
        }

        $canView   = true;
        $variables = ['document', 'canView'];
        // Check trạng thái tài liệu
        $error = DocumentViewService::getErrorMessage($document);
        if (!empty($error)) {
            $canView      = config('app.env') == 'production' ? Arr::get($error, 'canView', false) : true;
            $errorMessage = Arr::get($error, 'alert', 'Error document!');
            $alertType    = Arr::get($error, 'alertType', AlertType::WARNING);
            SeoService::setRobots('noindex, nofollow');
            notify($errorMessage, $alertType);
        }

        if ($canView) {
            $this->seo($document, $docMetaData);
            SeoService::setRobots('all');

            // Lấy tài liệu liên quan
            $documentRelated = DocumentService::getDocumentRelated($document);

            // Lấy bản tóm tắt tài liệu
            $summary = DocumentService::getSummary($document);

            $variables = [
                'documentRelated',
                'docMetaData',
                'summary',
                ...$variables,
            ];
        }
        return view('documents.detail-page', compact($variables));
    }

    /**
     * Method viewPDF
     *
     * @return View
     */
    public function viewPDF(): View|Factory
    {
        return view('documents.view-pdf');
    }
}
