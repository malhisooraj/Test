<?php

namespace App\Providers;

use App\Models\User;
use App\Services\MailchimpNewsletter;
use App\Services\NewsletterInterface;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use MailchimpMarketing\ApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register, binding resolution
        $this->app->bind(NewsletterInterface::class, function () {
            $client = (new ApiClient)->setConfig([
                'apiKey' => config('services.mailchimp.key'),
                'server' => 'us12'
            ]);

            return new MailchimpNewsletter($client);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Gate::define('admin', function (User $user) {
            return $user->username === 'Soorajmalhi';
        });

        Blade::if('admin', function () {
            return request()->user()?->can('admin');
        });
    }
}
