<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::get('test', function () {

    // $recursive = true; // Get subdirectories also?
    // $contents = collect(Storage::cloud()->listContents('/', $recursive));

    // // return $contents->where('type', 'dir'); // directories
    // // return $contents->where('type', 'file'); // directories
    // // return $contents->where('type', 'file')->mapWithKeys(function($file) {
    // //     return [$file->path() => pathinfo($file->path(), PATHINFO_BASENAME)];
    // // });
    // /////

    // $filename = '001.docx';

    // $rawData = Storage::cloud()->get($filename); // raw content
    // $file = Storage::cloud()->getAdapter()->getMetadata($filename); // array with file info

    // return response($rawData, 200)
    //     ->header('ContentType', $file->mimeType())
    //     ->header('Content-Disposition', "attachment; filename=$filename");
    //     //

    // // $filename = '001.pdf';
    // // $filePath = public_path('cache/' . $filename);

    // // $fileData = File::get($filePath);

    // // Storage::cloud()->put('test/' . $filename, $fileData);
    // // return 'File was saved to Google Drive';

    // // Use a stream to upload and download larger files
    // // to avoid exceeding PHP's memory limit.

    // // Thanks to @Arman8852's comment:
    // // https://github.com/ivanvermeyen/laravel-google-drive-demo/issues/4#issuecomment-331625531
    // // And this excellent explanation from Freek Van der Herten:
    // // https://murze.be/2015/07/upload-large-files-to-s3-using-laravel-5/

    // // Assume this is a large file...
    // $filename = 'bg.jpg';
    // $filePath = public_path('assets/img/' . $filename);

    // // Upload using a stream...
    // Storage::cloud()->put('test/' . $filename, fopen($filePath, 'r+'));
    // $file = Storage::cloud()->getAdapter()->getMetadata('test/' . $filename); // array with file info

    // // Store the file locally...
    // //$readStream = Storage::cloud()->getDriver()->readStream($filename);
    // //$targetFile = storage_path("downloaded-{$filename}");
    // //file_put_contents($targetFile, stream_get_contents($readStream), FILE_APPEND);

    // // Stream the file to the browser...
    // $readStream = Storage::cloud()->getDriver()->readStream('test/' . $filename);

    // return response()->stream(function () use ($readStream) {
    //                             fpassthru($readStream);
    //                         }, 200, [
    //                             'Content-Type' => $file->mimeType(),
    //                             //'Content-disposition' => 'attachment; filename='.$filename, // force download?
    //                         ]);

});

Route::get('/', [HomeController::class, 'index'])->name('client.home');
 
Route::get('/bai-viet/{slug}', [BlogController::class, 'show'])->name('client.blogs');

Route::get('/su-kien/{slug}', [EventController::class, 'show'])->name('client.events');
Route::get('/su-kien', [EventController::class, 'index'])->name('client.events.list');

Route::prefix('auth')->group(function () {

    Route::middleware('login.false')->prefix('login')->group(function () {

        Route::get('/', [AuthController::class, 'index'])->name('auth.login');
    
        
        Route::get('/microsoft', [AuthController::class, 'microsoftLogin'])->name('auth.login.microsoft');
        Route::get('/microsoft/callback', [AuthController::class, 'callbackMicrosoftLogin']);

        Route::get('/google', [AuthController::class, 'googleLogin'])->name('auth.login.google');
        Route::get('/google/callback', [AuthController::class, 'callbackGoogleLogin']);

    });

    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
    
});

Route::middleware('login.true')->group(function () {

    Route::prefix('jobs')->group(function () {
        Route::get('sub', [JobController::class, 'userSub'])->name('jobs.sub');

        Route::post('proof', [FileController::class, 'uploadProofForJob'])->name('jobs.proof');
    });

    Route::prefix('thong-tin-ca-nhan')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('profile.view');

        Route::get('chinh-sua', [UserController::class, 'edit'])->name('profile.edit');
        Route::post('chinh-sua', [UserController::class, 'update']);

    });
    
});





Route::prefix('admin')->group(function () {

    Route::prefix('auth')->group(function () {

        Route::get('login', [AdminAuthController::class, 'index'])->name('admin.auth.login');
        Route::post('login', [AdminAuthController::class, 'checkLogin']);

    });

    Route::middleware('admin.auth.login')->group(function () {

        Route::get('/', function () { return redirect()->route('admin.dashboard'); });

        Route::get('dashboard', [DashBoardController::class, 'index'])->name('admin.dashboard');

        Route::prefix('blogs')->group(function () {

            Route::get('/', [\App\Http\Controllers\Admin\BlogController::class, 'index'])->name('admin.blogs');

            Route::get('create', [\App\Http\Controllers\Admin\BlogController::class, 'create'])->name('admin.blogs.create');
            Route::post('create', [\App\Http\Controllers\Admin\BlogController::class, 'store']);

            Route::get('active', [\App\Http\Controllers\Admin\BlogController::class, 'active'])->name('admin.blogs.active');

            Route::get('preview', [\App\Http\Controllers\Admin\BlogController::class, 'show'])->name('admin.blogs.preview');

            Route::get('edit', [\App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('admin.blogs.edit');
            Route::post('edit', [\App\Http\Controllers\Admin\BlogController::class, 'update']);
            
            Route::get('delete', [\App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('admin.blogs.delete');

        });

        Route::prefix('categories')->group(function () {

            Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories');
            Route::post('create', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.create');

            Route::get('delete', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.delete');
            
        });
        
        Route::prefix('events')->group(function () {

            Route::get('/', [\App\Http\Controllers\Admin\EventController::class, 'index'])->name('admin.events');

            Route::get('create', [\App\Http\Controllers\Admin\EventController::class, 'create'])->name('admin.events.create');
            Route::post('create', [\App\Http\Controllers\Admin\EventController::class, 'store']);

            Route::get('active', [\App\Http\Controllers\Admin\EventController::class, 'active'])->name('admin.events.active');

            Route::get('preview', [\App\Http\Controllers\Admin\EventController::class, 'show'])->name('admin.events.preview');

            Route::get('edit', [\App\Http\Controllers\Admin\EventController::class, 'edit'])->name('admin.events.edit');
            Route::post('edit', [\App\Http\Controllers\Admin\EventController::class, 'update']);

            Route::get('delete', [\App\Http\Controllers\Admin\EventController::class, 'destroy'])->name('admin.events.delete');
        });
        

        Route::prefix('jobs')->group(function () {

            Route::post('create/{event}', [\App\Http\Controllers\Admin\JobController::class, 'storeForEvent'])->name('admin.jobs.store.event');

            Route::get('delete/{id}', [\App\Http\Controllers\Admin\JobController::class, 'destroy'])->name('admin.jobs.delete');
            Route::get('delete', [\App\Http\Controllers\Admin\JobController::class, 'destroyUser'])->name('admin.jobs.delete.user');

            Route::get('edit/{id}', [\App\Http\Controllers\Admin\JobController::class, 'edit'])->name('admin.jobs.edit');
            Route::post('edit/{id}', [\App\Http\Controllers\Admin\JobController::class, 'update']);

            Route::get('preview', [\App\Http\Controllers\Admin\JobController::class, 'show'])->name('admin.jobs.preview');

        });

        Route::prefix('users')->group(function () {
            
            Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
            
        });




        Route::get('auth/logout', [AdminAuthController::class, 'logout'])->name('admin.auth.logout');

        Route::prefix('files')->group(function () {

            Route::get('/', [\App\Http\Controllers\Admin\FileController::class, 'index'])->name('admin.files');

            Route::get('/create', [\App\Http\Controllers\Admin\FileController::class, 'create'])->name('admin.files.create');
            Route::post('/create', [\App\Http\Controllers\Admin\FileController::class, 'store']);

            Route::get('/delete', [\App\Http\Controllers\Admin\FileController::class, 'destroy'])->name('admin.files.delete');

            Route::get('/download', [\App\Http\Controllers\Admin\FileController::class, 'download'])->name('admin.files.download');

        });

    });


});

Route::prefix('files')->group(function () {

    Route::post('savepdf', function (Request $request) {
        
        $fileContent = $request->input('content');
        $fileName = $request->input('name') . '.pdf';
    
        $a2p_client = new \App\Helpers\SavePDF('4c1932dd-2b1e-4cc2-a98d-b02c8ac3c8a0');
        $api_response = $a2p_client->headless_chrome_from_html($fileContent, false, $fileName);
                
        $response = array();
    
        $response["pdfUrl"] = $api_response->pdf;
        
        return response()->json($response);
    
    });
    
    Route::get('download/jobuser', [FileController::class, 'downloadListJobUser'])->name('files.downoad.jobuser');
});
