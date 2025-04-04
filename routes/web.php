<?php

use App\Http\Controllers\Document\DocumentController;
use App\Http\Controllers\Document\DocumentTmpController;
use App\Http\Controllers\User\LoginSocialController;
use App\Http\Middleware\LogCurrentUrlMiddleware;
use App\Services\Payment\PaymentNotLoginService;
use Illuminate\Support\Facades\Route;

// Route::get('test-cache-admin', function() {
//     $memcached = Illuminate\Support\Facades\Cache::store('memcached')->getStore()->getMemcached();
//     $keys = $memcached->getAllKeys();
//     $values = $memcached->getMulti($keys);
//     dd($values);
// });

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require base_path('routes/v1/seo_list.php');

Route::get('sang-kien/{id}', [DocumentTmpController::class, 'realId']);
Route::get('sang-kien/{slug?}/{document}', [DocumentController::class, 'show'])
    ->middleware([
        'xss:utm_source,product,source_campaign,network,tracking,utm_medium,utm_campaign,utm_term,utm_content',
        'cacheResponse:604800', // cache 7 ngày
    ])
    ->name('document.show');

Route::get('viewer', [DocumentController::class, 'viewPDF'])
    ->withoutMiddleware('obfuscate-class')
    ->middleware('xss:file')
    ->name('document.view');

Route::get('tmp-payment/{document}', function ($document) {
    PaymentNotLoginService::getUser($document->id);
    return redirect()->route('document.payment', $document->uuid);
})->name('tmp.payment');

Route::get('thanh-toan/{document}', [DocumentController::class, 'paymentNotLogin'])
    ->name('document.payment');

Route::get('email/admin-vn-only', [DocumentTmpController::class, 'tmpDownload'])->name('tmp.download');

/*
|--------------------------------------------------------------------------
| Social Login
|--------------------------------------------------------------------------
*/
Route::prefix('auth/social')
    ->name('auth.social.')
    ->withoutMiddleware(LogCurrentUrlMiddleware::class)
    ->group(function () {
        Route::get('{provider}/redirect', [LoginSocialController::class, 'redirect'])
            ->name('redirect');
        Route::match(['GET', 'POST'], '{provider}/callback', [LoginSocialController::class, 'callback'])
            ->name('callback');
    });
