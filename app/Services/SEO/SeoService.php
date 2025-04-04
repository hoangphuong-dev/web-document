<?php

namespace App\Services\SEO;

use App\Helpers\URLGenerate;
use App\Models\Document;
use App\Models\DocumentMetaData;
use App\Services\Document\TitleService;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Helpers\Formatter;

class SeoService
{
    // check SEO : https://pagespeed.web.dev/
    // check INP SEO : https://www.debugbear.com/

    public static function seoListItem(string $title, string $description, array $documents)
    {
        JsonLd::setType('ItemList');
        JsonLd::addValues([
            '@context'        => "https://schema.org",
            'name'            => $title,
            'description'     => $description,
            'itemListElement' => static::formatListItem($documents),
        ]);
    }

    private static function formatListItem(array $documents): array
    {
        $itemList = [];
        foreach ($documents as $index => $document) {
            $itemList[] = [
                '@type'    => 'ListItem',
                'position' => $index + 1,
                'item'     => [
                    '@type'         => 'DigitalDocument',
                    'headline'      => $document->title,
                    'datePublished' => $document->created_at->toIso8601String(),
                    'url'           => URLGenerate::urlDocumentDetail($document)
                ],
            ];
        }
        return $itemList;
    }

    /**
     * Method seoTitle
     *
     * @param string $title
     *
     * @return void
     */
    public static function seoTitle(string $title)
    {
        // SEO title
        $seoTitle = $title;
        SEOMeta::setTitle($seoTitle, false);
        TwitterCard::setTitle($seoTitle);
        OpenGraph::setTitle($seoTitle);
    }

    /**
     * Method seoImage
     *
     * @param string $urlImage
     *
     * @return void
     */
    public static function seoImage(string $urlImage)
    {
        // SEO image
        TwitterCard::setImages([$urlImage]);
        OpenGraph::addImage($urlImage);
    }

    /**
     * Method seoUrl
     *
     * @param string $urlPage
     *
     * @return void
     */
    public static function seoUrl(string $urlPage)
    {
        // SEO url
        TwitterCard::setUrl($urlPage);
        OpenGraph::setUrl($urlPage);
    }

    /**
     * Có các loại type SEO như sau: 
     *  Article      : Được sử dụng cho các bài viết trên web,bao gồm các bài blog và bài báo.
     *  Breadcrumb   : Được sử dụng để hiển thị đường dẫn điều hướng.
     *  Event        : Được sử dụng để đánh dấu thông tin về các sự kiện như ngày, giờ,địa điểm.
     *  FAQPage      : Được sử dụng cho các trang FAQ để liệt kê các câu hỏi thường gặp và câu trả lời.
     *  HowTo        : Được sử dụng để đánh dấu các bài hướng dẫn từng bước.
     *  LocalBusiness: Được sử dụng cho các doanh nghiệp địa phương, bao gồm tên, địa chỉ, số điện thoại, và giờ mở cửa.
     *  Organization : Được sử dụng để cung cấp thông tin về một tổ chức hoặc công ty.
     *  Person       : Được sử dụng để cung cấp thông tin về một cá nhân.
     *  Product      : Được sử dụng để đánh dấu thông tin sản phẩm, bao gồm tên, mô tả, giá, và đánh giá.
     *  Recipe       : Được sử dụng cho các công thức nấu ăn, bao gồm nguyên liệu, hướng dẫn, thời gian nấu, và giá trị dinh dưỡng.
     *  Review       : Được sử dụng để đánh dấu các bài đánh giá và xếp hạng.
     *  VideoObject  : Được sử dụng để đánh dấu các video.
     *
     * @param string $type
     *
     * @return void
     */
    public static function seoType(string $type = 'Article')
    {
        // SEO type
        OpenGraph::setType($type);
    }

    /**
     * Method seoDescription
     *
     * @param string $description
     *
     * @return void
     */
    public static function seoDescription(string $description)
    {
        // SEO description
        $description = Formatter::removeSomeChar($description);
        SEOMeta::setDescription($description);
        TwitterCard::setDescription($description);
        OpenGraph::setDescription($description);
    }


    /**
     * Method setCanonical
     *
     * @param string $urlCanonical
     *
     * @return void
     */
    public static function setCanonical(string $urlCanonical)
    {
        // setCanonical
        SEOMeta::setCanonical($urlCanonical);
    }

    /**
     * Method setRobots
     *
     * @param string $content
     *
     * @return void
     */
    public static function setRobots(string $content)
    {
        // setRobots
        SEOMeta::setRobots($content);
    }

    /**
     * Cắt chuỗi sao cho vẫn giữ nguyên nghĩa của câu
     *
     * @param string $string
     * @param int $limit
     *
     * @return string
     */
    private static function truncateString(string $string, int $limit = 70): string
    {
        if (strlen($string) <= $limit) {
            return $string;
        }

        // Tìm vị trí của khoảng trắng cuối cùng trong giới hạn 70 ký tự
        $lastSpace = strrpos(substr($string, 0, $limit), ' ');

        if ($lastSpace !== false) {
            return substr($string, 0, $lastSpace);
        } else {
            // Nếu không có khoảng trắng, cắt trực tiếp tại giới hạn
            return substr($string, 0, $limit);
        }
    }

    public static function addJsonLdDocument(Document $document, ?DocumentMetaData $docMeta)
    {
        $ext           = $document->ext->description;
        $urlCat        = URLGenerate::urlCat($document->categories);
        $url           = URLGenerate::urlDocumentDetail($document);
        $seoTitle      = $docMeta?->ai_title ?? TitleService::shortTitle($document);
        $aiDescription = $docMeta->ai_description ?? '';
        JsonLd::setType('DigitalDocument');
        JsonLd::addValues([
            '@id'            => $url . '#richSnippet',
            'headline'       => $seoTitle,
            'name'           => $seoTitle,
            'description'    => $aiDescription,
            'datePublished'  => $document->created_at->toIso8601String(),
            'dateModified'   => $document->updated_at->toIso8601String(),
            'encodingFormat' => "application/{$ext}",
            'fileFormat'     => "{$ext}",
            'contentUrl'     => $url,
            'publisher'      => [
                '@id'   => config('app.url') . '#organization',
                '@type' => 'Organization',
                'name'  => config('app.name'),
                'url'   => config('app.url'),
            ],
            'isPartOf'      => [
                '@type' => 'WebPage',
                "@id"   => $urlCat,
                "url"   => $urlCat,
                "name"  => $document->categories->name
            ],
            'about'      => [
                "@type"       => "Thing",
                "name"        => $seoTitle,
                "description" => $aiDescription
            ],
            'inLanguage'     => 'vi-VN',
        ]);
    }
}
