<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Models\Category;
use App\Models\User;
use App\Services\MailchimpNewsletter;
use Illuminate\Support\Facades\Route;

use App\Models\Post;


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

/*Route::get('/', function () {
    return view('posts/index');
});*/

//Route::get('/', [PostController::class, 'index']);

// Return the homepage with all posts
Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('posts', [PostController::class, 'index'])->name('posts.index');


// Return the homepage with all posts
//Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// return a page to show full post
Route::get('posts/{post:slug}', [PostController::class, 'show'])->name('posts.view');

Route::get('poststest/{post}', function ($id){
    $post = Post::findOrFail($id);
    if (! $post) {
        abort(404);
    }
    return view('posts.show', ['post' => $post]);
});

// get posts by category
Route::get('categories/{category:slug}', function (Category $category) {
    return view('posts.index', [
        'posts' => $category->posts,
        'categories' => Category::all(),
        'currentCategory' => $category
    ]);
});

// get all posts by author
Route::get('author/{author:username}', function (User $author) {
    return view('posts.index', [
       // 'posts' => $author->posts->load(['category','author'])
        'posts' => $author->posts,
        'categories' => Category::all()
    ]);
});

// Registration
// middleware('guest'), only guest user can access this endpoint
Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');
Route::get('login', [SessionsController::class, 'create'])->middleware('guest');
Route::post('login', [SessionsController::class, 'store'])->middleware('guest');

// add post comment
Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);

//test mailchimp
Route::get('ping', function () {
    $mailchimp = new \MailchimpMarketing\ApiClient();

    $mailchimp->setConfig([
        'apiKey' => config('services.mailchimp.key'),
        'server' => 'us12'
    ]);
    //$response = $mailchimp->lists->getAllLists(); // get mailchimp list
    // add new member to the list
    $response = $mailchimp->lists->addListMember('ded0dd34fc', [
        'email_address' => 'test@google123.com',
        'status' => 'subscribed'
    ]);

    dd($response);
});

// mailchimp email subscription

/*Route::post('newsletter', function () {
    request()->validate(['email' => 'required|email']);
    $mailchimp = new \MailchimpMarketing\ApiClient();

    $mailchimp->setConfig([
        'apiKey' => config('services.mailchimp.key'),
        'server' => 'us12'
    ]);
    //$response = $mailchimp->lists->getAllLists(); // get mailchimp list
    // add new member to the list
    try {
        $response = $mailchimp->lists->addListMember('ded0dd34fc', [
            'email_address' => request('email'),
            'status' => 'subscribed'
        ]);
    } catch (\Exception $e) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'This email could not be added to our newsletter list.'
        ]);
    }
    return redirect('/')->with('success', 'You are now signed up for our newsletter');
});

Route::post('newsletter', function () {
    request()->validate(['email' => 'required|email']);
    try {
        $newsletter = new MailchimpNewsletter(request('email'));
        $newsletter->subscribe(request('email'));
    } catch (\Exception $e) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'This email could not be added to our newsletter list.'
        ]);
    }
    return redirect('/')->with('success', 'You are now signed up for our newsletter');
});*/

Route::post('newsletter', NewsletterController::class);

//Admin
/*Route::get('admin/posts/create', [AdminPostController::class, 'create'])->middleware('admin'); // post create
Route::post('admin/posts', [AdminPostController::class, 'store'])->middleware('admin'); // post save
Route::get('admin/posts', [AdminPostController::class, 'index'])->middleware('admin'); // post dashboard
Route::get('admin/posts/{post}/edit', [AdminPostController::class, 'edit'])->middleware('admin');// post edit
Route::patch('admin/posts/{post}', [AdminPostController::class, 'update'])->middleware('admin'); // post update
Route::delete('admin/posts/{post}', [AdminPostController::class, 'destroy'])->middleware('can:admin'); //post delete
*/
// combining all above with this resource node
Route::middleware('can:admin')->group(function () {
    Route::resource('admin/posts', AdminPostController::class)->except('show');
});
