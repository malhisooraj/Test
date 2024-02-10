<?php

namespace App\Http\Controllers;

use App\Services\MailchimpNewsletter;
use App\Services\NewsletterInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    /**
     * This action will be called by default, this is called single action controller
     * @throws ValidationException
     */
    public function __invoke(NewsletterInterface $newsletter)
    {
        request()->validate(['email' => 'required|email']);
        try {
            $newsletter->subscribe(request('email'));
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'email' => 'This email could not be added to our newsletter list.'
            ]);
        }
        return redirect('/')->with('success', 'You are now signed up for our newsletter');
    }
}
