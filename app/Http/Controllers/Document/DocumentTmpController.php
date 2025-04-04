<?php

namespace App\Http\Controllers\Document;

use App\Helpers\URLGenerate;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentStatisticService;
use App\Services\Storage\DiskPathService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class DocumentTmpController extends Controller
{
    public function tmpDownload(Request $request)
    {
        if ($id = $request->get('id')) {
            $id = filter_var($id, FILTER_VALIDATE_URL) ? Arr::last(explode('/', strtok($id, '?'))) : $id;
            if ((int)$id <= 0) {
                dd($id);
            }
            $realId   = DocumentService::getHashHandler()->decode($id);
            $document = Document::where('id', $realId)->first();
            if (empty($document)) {
                dd('Tài liệu không tồn tại');
            }

            if (!(Auth::check() && Auth::id() == 1)) {
                dd('User not Auth');
            }

            $path = "{$document->path}/{$document->file_name}";
            if (DiskPathService::document()->exists($path)) {
                $fileName = "[" . config('app.name') . "]{$document->slug}-{$document->file_name}";
                DocumentStatisticService::increment($document, 'number_download');
                return DiskPathService::document()->download($path, $fileName);
            } else {
                dd('File không tồn tại : ' . DiskPathService::document()->path($path));
            }
        }
        return view('auth.download');
    }

    public function realId($id)
    {
        if ((int)$id > 0) {
            $document = ($id < 1000000)
                ? DocumentService::first($id)
                : DocumentService::first(Arr::first(DocumentService::getHashHandler()->decode($id)));
        } else {
            $slug = $id;
            $document = Document::whereSlug($slug)->first();
        }

        if ($document) {
            return redirect()->to(URLGenerate::urlDocumentDetail($document));
        }
        abort(404);
    }
}
