<?php

use Cake\Core\Configure;

return [
    'HybridAuth' => [
        'providers' => [
            'Facebook' => [
                'enabled' => (bool)get_option('social_login_facebook', false),
                'keys' => [
                    'id' => get_option('social_login_facebook_app_id'),
                    'secret' => get_option('social_login_facebook_app_secret')
                ],
                'scope' => 'email, public_profile'
            ],
            'Twitter' => [
                'enabled' => (bool)get_option('social_login_twitter', false),
                'keys' => [
                    'key' => get_option('social_login_twitter_api_key'),
                    'secret' => get_option('social_login_twitter_api_secret')
                ],
                'includeEmail' => true // Only if your app is whitelisted by Twitter Support
            ],
            'Google' => [
                'enabled' => (bool)get_option('social_login_google', false),
                'keys' => [
                    'id' => get_option('social_login_google_client_id'),
                    'secret' => get_option('social_login_google_client_secret')
                ],
                'scope' => 'https://www.googleapis.com/auth/plus.me ' .
                    'https://www.googleapis.com/auth/userinfo.email ' .
                    'https://www.googleapis.com/auth/plus.profile.emails.read ' .
                    'https://www.googleapis.com/auth/userinfo.profile'
            ]
        ],
        'debug_mode' => Configure::read('debug'),
        'debug_file' => LOGS . 'hybridauth.log',
    ]
];
