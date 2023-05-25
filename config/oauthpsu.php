<?php
/** OAuth2 Client Configuration */

/** GET client_id and client_secret from https://dev-devportal.eng.psu.ac.th */

/** code based on https://stackoverflow.com/questions/17159046/including-php-files-with-laravel-framework */

return [
    'client_id'             => env('PSU_PASSPORT_CLIENT_ID'),              //=> 'f577ed41e0de903b1f75407fdc7b3361b4940d5c',
    'client_secret'         => env('PSU_PASSPORT_CLIENT_SECRET'),          //=> 'VA0GjXWiHQK1yQdOGhzLl0cWBsIQhdN2CMxLyiT6XtUk9WYE3m',
    'redirect_uri'          => env('PSU_PASSPORT_REDIRECT_URL'),           //=> 'http://localhost:8000/auth/psu/callback',
    'oauth_authorize_url'   => env('PSU_PASSPORT_OAUTH_AUTHORIZE_URL'),    //=> 'https://oauth2.eng.psu.ac.th/authorize',
    'oauth_token_url'       => env('PSU_PASSPORT_OAUTH_TOKEN_URL'),        //=> 'https://oauth2.eng.psu.ac.th/authorize/token',
    'userinfo_endpoint_url' => env('PSU_PASSPORT_USERINFO_ENDPOINT_URL'),  //=> 'https://oauth2.eng.psu.ac.th/resource/userinfo'
];
