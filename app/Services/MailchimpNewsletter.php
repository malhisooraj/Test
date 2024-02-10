<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;

class MailchimpNewsletter implements NewsletterInterface
{

    public function __construct(protected ApiClient $client)
    {

    }
    public function subscribe($email, string $list = null)
    {
        $list ??= config('services.mailchimp.lists.subscribers');
        //request()->validate(['email' => 'required|email']);

        // default list = ded0dd34fc
        $response = $this->client->lists->addListMember($list, [
            'email_address' => $email,
            'status' => 'subscribed'
        ]);

    }

    /*protected function client()
    {
        /*$mailchimp = new ApiClient();
        $mailchimp->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => 'us12'
        ]);

        return (new ApiClient())->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => 'us12'
        ]);
    }*/
}
