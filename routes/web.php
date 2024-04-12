<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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



Route::get('/', [Controller::class, 'welcome'])->name('welcome');



Route::get('/login', [Controller::class, 'login'])->name('login');
Route::get('/register', [Controller::class, 'register'])->name('register');



Route::post('/login', [Controller::class, 'loginPost'])->name('login.post');
Route::post('/registration', [Controller::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [Controller::class, 'logout'])->name('logout');




Route::get('/dashboard', [Controller::class, 'dashboard'])->name('admin.dashboard');
Route::get('/users', [Controller::class, 'users'])->name('admin.users');


Route::get('/addSlide', [Controller::class, 'addSlide'])->name('admin.addSlide');
Route::post('/addSlide', [Controller::class, 'addSlidePost'])->name('addSlide.post');
Route::post('/addVideoslide', [Controller::class, 'addVideoslide'])->name('addVideoslide.post');
Route::post('/addDocumnetslide', [Controller::class, 'addDocumentslide'])->name('addDocumentslide.post');


Route::get('/slide/{slide}/edit', [Controller::class, 'editSlide'])->name('slide.edit');


Route::put('/slide/{slide}/update', [Controller::class, 'updateSlide'])->name('slide.update');

Route::put('/slide/{slide}/updateVideo', [Controller::class, 'updateVideo'])->name('slide.updateVideo');


Route::delete('/deleteSlide/{slide}/destroy', [Controller::class, 'destroy'])->name('deleteSlide.destroy');
