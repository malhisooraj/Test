<?php

namespace App\Services;

interface NewsletterInterface
{
    public function subscribe($email, string $list = null);
}
