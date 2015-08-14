<?php

return [
    'provider' => 'Mailchimp',
    'providers' => [
        'Mailchimp' => [
            'NewsletterRepo' => WilsonCreative\Newsletter\Repos\Newsletter\MailchimpNewsletter::class,
            'MailinglistRepo' => WilsonCreative\Newsletter\Repos\Mailinglist\MailchimpMailinglist::class,
            'SubscriberRepo' => WilsonCreative\Newsletter\Repos\Subscriber\MailchimpSubscriber::class
        ],
        'Apsis' => [
            'NewsletterRepo' => WilsonCreative\Newsletter\Repos\Newsletter\ApsisNewsletter::class,
            'MailinglistRepo' => WilsonCreative\Newsletter\Repos\Mailinglist\ApsisMailinglist::class,
            'SubscriberRepo' => WilsonCreative\Newsletter\Repos\Subscriber\ApsisSubscriber::class
        ]
    ],
];