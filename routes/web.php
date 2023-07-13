<?php

use App\Http\Controllers\Api\Category\CatalogTypeApiController;
use App\Http\Controllers\Api\Category\CategoryApiController;
use App\Http\Controllers\Api\Course\CourseApiController;
use App\Http\Controllers\Api\Duration\StudyDurationApiController;
use App\Http\Controllers\Api\Review\ReviewApiController;
use App\Http\Controllers\Api\Schools\SchoolsApiController;
use App\Http\Controllers\Api\Tag\TagApiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CatalogTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StudyDurationController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SchoolController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth.guest'], function () {
    Route::get('/admin/login', [LoginController::class, 'loginView'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'login']);
});
Route::group(['middleware' => 'auth.manager'], function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [DashBoardController::class, 'index'])->name('dashboard.index');
    Route::get('categories/create/{id}', [CategoryController::class, 'create']);
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/banner', [SettingsController::class, 'banner'])->name('settings.banner');
        Route::get('/advantages', [SettingsController::class, 'advantagesIndex'])->name('setting.advantages');
        Route::get('/quiz-module', [SettingsController::class, 'quizModule'])->name('setting.quiz');
        Route::get('/promo', [SettingsController::class, 'quizPromo'])->name('setting.promo');
        Route::get('/collaboration', [SettingsController::class, 'collaborationModule'])->name('setting.collaborate');
    });
    Route::resource('/sales', SaleController::class);

    Route::resources([
        'news' => NewsController::class,
        'schools' => SchoolController::class,
        'categories' => CategoryController::class,
        'types' => CatalogTypeController::class,
        'tags' => TagController::class,
        'courses' => CourseController::class,
        'durations' => StudyDurationController::class,
        'reviews' => ReviewController::class,
    ]);

    Route::group(['prefix' => 'api'], function () {
        Route::group(['prefix' => 'schools'], function () {
            Route::get('/', [SchoolsApiController::class, 'index']);
            Route::put('/change-status', [SchoolsApiController::class, 'changeStatuses']);
            Route::post('/delete', [SchoolsApiController::class, 'delete']);
            Route::post('/save', [SchoolsApiController::class, 'save']);
            Route::get('/get', [SchoolsApiController::class, 'getById']);
            Route::delete('/remove-logo/{schoolId}', [SchoolsApiController::class, 'deleteLogo']);
            Route::get('/search', [SchoolsApiController::class, 'findBy']);
            Route::get('/all-list', [SchoolsApiController::class, 'getAll']);
        });

        Route::group(['prefix' => 'categories'], function () {
            Route::post('/', [CategoryApiController::class, 'save']);
            Route::get('/', [CategoryApiController::class, 'getAll']);
            Route::get('/get-one/{id}', [CategoryApiController::class, 'getById']);
            Route::get('/get', [CategoryApiController::class, 'getAllForSelect']);
            Route::patch('/url', [CategoryApiController::class, 'makeUrl']);
            Route::delete('/{id}', [CategoryApiController::class, 'delete']);
            Route::get('/children/{id}', [CategoryApiController::class, 'getChildren']);
            Route::delete('/remove-related/{categoryId}/{relatedId}', [CategoryApiController::class, 'removeRelated']);
        });

        Route::group(['prefix' => 'types'], function () {
            Route::post('/', [CatalogTypeApiController::class, 'save']);
            Route::get('/', [CatalogTypeApiController::class, 'getAll']);
            Route::get('/{id}', [CatalogTypeApiController::class, 'getById']);
            Route::delete('/{id}', [CatalogTypeApiController::class, 'remove']);
            Route::post('/remove', [CatalogTypeApiController::class, 'removeMultiple']);
        });

        Route::group(['prefix' => 'tags'], function () {
            Route::post('/', [TagApiController::class, 'save']);
            Route::get('/', [TagApiController::class, 'getAll']);
            Route::post('/delete', [TagApiController::class, 'destroy']);
            Route::get('/{id}', [TagApiController::class, 'getById']);
        });

        Route::group(['prefix' => 'durations'], function () {
            Route::post('/', [StudyDurationApiController::class, 'save']);
            Route::get('/', [StudyDurationApiController::class, 'getAll']);
            Route::post('/delete', [StudyDurationApiController::class, 'destroy']);
            Route::get('/{id}', [StudyDurationApiController::class, 'getById']);
        });

        Route::group(['prefix' => 'courses'], function () {
            Route::get('/', [CourseApiController::class, 'index']);
            Route::get('/get/{id}', [CourseApiController::class, 'findById']);
            Route::get('/schools', [CourseApiController::class, 'getSchools']);
            Route::get('/statuses', [CourseApiController::class, 'getStatuses']);
            Route::get('/categories', [CourseApiController::class, 'getCategories']);
            Route::get('/{categoryId}/get-subcategories', [CourseApiController::class, 'getSubCategoriesByCategoryId']);
            Route::put('/status-change', [CourseApiController::class, 'statusesChange']);
            Route::post('/remove', [CourseApiController::class, 'remove']);
            Route::get('/tags', [CourseApiController::class, 'getTags']);
            Route::get('/durations', [CourseApiController::class, 'getDurations']);
            Route::post('/save', [CourseApiController::class, 'save']);
            Route::delete('/image/{courseId}', [CourseApiController::class, 'deleteImage']);
            Route::get('/all-list', [CourseApiController::class, 'getAllCoursesList']);
        });
        Route::group(['prefix' => 'settings'], function () {
            // Banner
            Route::post('/banner/save', [SettingsController::class, 'saveBanner']);
            Route::get('/banner/get', [SettingsController::class, 'getBanner']);
            Route::delete('/banner/remove-image', [SettingsController::class, 'removeImage']);

            // Advantages
            Route::post('/advantages/save', [SettingsController::class, 'saveAdvantages']);
            Route::get('/advantages/get', [SettingsController::class, 'getAdvantages']);
            Route::put('/advantages/{id}/edit', [SettingsController::class, 'editAdvantage']);
            Route::delete('/advantages/{id}/delete', [SettingsController::class, 'deleteAdvantage']);

            // QUIZ
            Route::get('/quiz/get', [SettingsController::class, 'getQuizModule']);
            Route::post('/quiz/save', [SettingsController::class, 'saveQuizModule']);

            // Promo
            Route::get('/promo/get', [SettingsController::class, 'getPromoModule']);
            Route::post('/promo/save', [SettingsController::class, 'savePromoModule']);

            // Collaboration Module
            Route::get('/collaboration/get', [SettingsController::class, 'getCollaborationModule']);
            Route::post('/collaboration/save', [SettingsController::class, 'saveCollaborationModule']);
        });

        Route::group(['prefix' => 'review'] , function () {
            Route::get('/statuses-list', [ReviewApiController::class, 'getReviewStatusesList']);
            Route::get('/sources-list', [ReviewApiController::class, 'getReviewSourcesList']);
            Route::get('/users-list', [ReviewApiController::class, 'getReviewUsersList']);
            Route::put('/status-change', [ReviewApiController::class, 'statusChange']);
            Route::post('/remove-multiple', [ReviewApiController::class, 'destroyMultiple']);
        });

        Route::apiResources([
            'review' => ReviewApiController::class,
        ]);
    });
});
