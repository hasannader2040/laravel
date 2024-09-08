<?php

use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionCont;
use App\Http\Controllers\ProfileController;
use App\Mail\NewPostNotification; // Assuming NewPostNotification is your Mailable class

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


Route::get('/', function () {
    // Mail::send(new NewPostNotification());
    return view('welcome');
});

Route::get('/dashboard', function () {
    //Mail::send(new NewPostNotification());
    return redirect('home');
})->middleware(['auth', 'verified'])->name('dashboard');

//return view('home');
Route::get('/home', [PostController::class, 'showHomePage'])->middleware(['auth', 'verified'])->name('home');

//Route::get('/', [PostController::class, 'thebest']);


// Blog post related routes

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/create-post', [PostController::class, 'createPost']);
    Route::get('/create-post', [PostController::class, 'formCreatePost']);
    Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);
    Route::put('/edit-post/{post}', [PostController::class, 'actuallyUpdatePost']);
    Route::delete('/delete-post/{post}', [PostController::class, 'deletePost'])->name('post.destroy');
    //Route::get('/', [PostController::class, 'showHomePage']);


    //Route::get('/send-notification', function () {
    // $post = Post::find(1); // Assuming you're getting a post with ID 1

    // Send the email notification with the post data

    //Mail::to('hassannader2040@gmail.com')->send(new App\Mail\NewPostNotification($post));
    //return 'Notification sent!';
    // });


});

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
});

// bor subscripcation

Route::post('/subscribe', [SubscriptionCont::class, 'store'])->name('subscribe');



//  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//require __DIR__ . '/auth.php';
