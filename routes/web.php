<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
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

Route::get('/', [HomeController::class, 'index'])->name('client.home');

Route::get('/bai-viet/{slug}', [BlogController::class, 'index'])->name('client.blogs');

Route::get('/su-kien/{slug}', [EventController::class, 'index'])->name('client.events');

Route::prefix('auth')->group(function () {

    Route::middleware('login.false')->prefix('login')->group(function () {

        Route::get('/', [AuthController::class, 'index'])->name('auth.login');
    
        
        Route::get('/microsoft', [AuthController::class, 'microsoftLogin'])->name('auth.login.microsoft');
        Route::get('/microsoft/callback', [AuthController::class, 'callbackMicrosoftLogin']);
    });

    
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

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

            Route::get('preview', [\App\Http\Controllers\Admin\JobController::class, 'show'])->name('admin.jobs.preview');

        });




        Route::get('auth/logout', [AdminAuthController::class, 'logout'])->name('admin.auth.logout');

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
