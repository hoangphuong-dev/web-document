<?php

namespace App\Services\Sphinx;

use App\Enums\Document\DocumentFilterAdvanced;
use Helpers\Formatter;
use App\Libs\SphinxClient;
use App\Models\Document;
use App\Services\Document\DocumentService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class search by sphinxSearch
 *
 */
class SphinxSearchService
{
    /*
    Lấy ID tài liệu tìm được từ Sphinx -> Query lấy document
     */
    public static function getDocumentFromSphinx(array $request): ?Collection
    {
        $arrDocument = self::searchDocument($request);
        $arrId       = Arr::pluck($arrDocument, 'id');
        return DocumentService::getDocumentByIds($arrId, ['metaData']);
    }

    /*
    Search tài liệu trên search engine qua 3 lần search => sắp xếp theo điểm số (score) customer
     */
    public static function searchDocument(array $request): array
    {
        $keyword      = Arr::get($request, 'keyword');
        $arrDocument  = [];

        $sphinxSearch = new SphinxClient(
            host: config('sphinx_search.host'),
            port: config('sphinx_search.api_port'),
        );

        // static::searchStatic()

        // Add limit
        $limitDoc = 20;
        $page     = Arr::get($request, 'page', 1);
        $start    = $page > 1 ? ($page - 1) * $limitDoc : 0;
        $sphinxSearch->SetLimits($start, $limitDoc);

        $words = explode(' ', trim($keyword));
        if (Arr::get($request, 'advanced') == DocumentFilterAdvanced::START_PHRASE) { // search bắt đầu bằng cụm từ
            $keySearch = '"' . $keyword . '" "^' . $keyword . '"';
            $sphinxSearch->SetMatchMode(SphinxClient::SPH_MATCH_EXTENDED);
            $sphinxSearch->AddQuery($keySearch . '*', 'documents_index');
            $ret1    = $sphinxSearch->runQueries();
            $result1 = Arr::get($ret1, '0.matches', []);
            foreach ($result1 as $index => $doc) {
                $arrDocument[] = [
                    'id'    => $index,
                    'name'  => Arr::get($doc, 'attrs.title', ''),
                    'score' => count($words),
                ];
            }
        } else { // search chính xác bằng cụm từ
            $keySearch = '"' . $keyword . '" | "' . Formatter::removeAccent($keyword) . '"';
            $sphinxSearch->SetMatchMode(SphinxClient::SPH_MATCH_EXTENDED);
            $sphinxSearch->AddQuery($keySearch . '*', 'documents_index');
            $ret1    = $sphinxSearch->runQueries();
            $result1 = Arr::get($ret1, '0.matches', []);
            foreach ($result1 as $index => $doc) {
                $arrDocument[] = [
                    'id'    => $index,
                    'name'  => Arr::get($doc, 'attrs.title', ''),
                    'score' => count($words),
                ];
            }
        }

        // nếu search chính xác cụm từ thì không search lần 2,3
        if (Arr::get($request, 'advanced') == 1 || !Arr::get($request, 'advanced')) {
            // search lần 1 nghiêm ngặt , không có đủ số lượng document => Search lần 2
            if (count($arrDocument) < $limitDoc) {
                $keySearch2 = '"' . implode('" << "', $words) . '"';
                $sphinxSearch->SetMatchMode(SphinxClient::SPH_MATCH_EXTENDED);
                $sphinxSearch->AddQuery($keySearch2 . '*', 'documents_index');
                $ret2    = $sphinxSearch->runQueries();
                $result2 = Arr::get($ret2, '0.matches', []);
                foreach ($result2 as $index => $doc) {
                    $find = array_search($index, array_column($arrDocument, 'id'));
                    // nếu tài liệu chưa có trong lần search 1
                    if ($find === false) {
                        $arrDocument[] = [
                            'id'    => $index,
                            'name'  => Arr::get($doc, 'attrs.title', ''),
                            'score' => 0.6 * count($words),
                        ];
                    } else {
                        // Cộng thêm điểm nếu doc trùng với lần search 1
                        $arrDocument[$find]['score'] += count($words);
                    }
                }
            }
            // Kiểm tra số lượng kết quả - Cắt bỏ nếu thừa | Search thêm nếu thiếu
            if (count($arrDocument) >= $limitDoc) {
                $arrDocument = array_slice($arrDocument, 0, $limitDoc);
            } else {
                $sphinxSearch->SetMatchMode(SphinxClient::SPH_MATCH_ANY);
                // Lấy id đã search 2 lần trước để không search lại lần 3
                $avoid = collect($arrDocument)->pluck("id")->toArray();
                if (count($avoid) > 0) {
                    $queryFilter = '*, IF(NOT IN (id, ' . implode(', ', $avoid) . '), 1, 0) AS fill_doc ';
                    $sphinxSearch->SetSelect($queryFilter);
                    $sphinxSearch->SetFilter('fill_doc', array(1));
                }
                $sphinxSearch->SetLimits($start, $limitDoc - count($arrDocument));
                $sphinxSearch->AddQuery($keyword . '*', 'documents_index');
                $ret3    = $sphinxSearch->runQueries();
                $result3 = Arr::get($ret3, '0.matches', []);
                foreach ($result3 as $index => $doc) {
                    $arrDocument[] = [
                        'id'    => $index,
                        'name'  => Arr::get($doc, 'attrs.title', ''),
                        'score' => 0.5 * count($words),
                    ];
                }
            }
        }
        // Sắp xếp theo điểm số
        usort($arrDocument, function ($v1, $v2) {
            return $v1['score'] < $v2['score'];
        });
        return $arrDocument;
    }

    public static function searchStatic()
    {
        // Sort filter
        // if (in_array((int) Arr::get($request, 'sort'), [1, 2, 3])) {
        //     $field = match ((int) Arr::get($request, 'sort')) {
        //         1 => 'doc_date_create',
        //         2 => 'doc_downloads',
        //         3 => 'doc_views',
        //     };
        //     $sphinxSearch->setSortMode(SphinxClient::SPH_SORT_ATTR_DESC, $field);
        // }

        // Filter theo độ dài trang
        // if (in_array((int) Arr::get($request, 'length'), [1, 2, 3, 4])) {
        //     $range = match ((int) Arr::get($request, 'length')) {
        //         1 => [1, 4],
        //         2 => [4, 20],
        //         3 => [21, 100],
        //         4 => [100, 2147000000],
        //     };
        //     $sphinxSearch->SetFilterRange('doc_num_page', $range[0], $range[1]);
        // }

        // Filter theo đuôi file
        // $ext = (int) Arr::get($request, 'ext');
        // if ($ext > 0 && $ext <= 6) {
        //     $sphinxSearch->setFilter('doc_ext_id', [$ext]);
        // }

        // if (Arr::get($request, 'price') == 1) {
        //     $sphinxSearch->setFilter('doc_is_sale', [0, 2]);
        // }
        // if (Arr::get($request, 'price') == 2) {
        //     $sphinxSearch->setFilter('doc_is_sale', [1, 3]);
        // }

        // Filter theo category
        // if (Arr::get($request, 'cat_id') > 0 && in_array((int) Arr::get($request, 'cat_level'), [1, 2, 3])) {
        //     $catId = (int) Arr::get($request, 'cat_id');
        //     if (Arr::get($request, 'cat_level') == 3) {
        //         $sphinxSearch->setFilter('doc_category_id', [$catId]);
        //     } else {
        //         $queryFilter = ' *, IF(doc_category_id = ' . $catId . ' OR cat_parent_id_' . (int) Arr::get($request, 'cat_level') . ' = ' . $catId . ', 1, 0) AS fill ';
        //         $sphinxSearch->SetSelect($queryFilter);
        //         $sphinxSearch->SetFilter('fill', array(1));
        //     }
        // }
    }
}
