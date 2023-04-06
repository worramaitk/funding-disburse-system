<?php
/** OAuth2 Client Configuration */

/** GET client_id and client_secret from https://dev-devportal.eng.psu.ac.th */

/** code based on https://stackoverflow.com/questions/17159046/including-php-files-with-laravel-framework */

return [
    'name'                  => 'Raphael',
    'gorgeous'              => true,
    'client_id'             => 'f577ed41e0de903b1f75407fdc7b3361b4940d5c',
    'client_secret'         => 'VA0GjXWiHQK1yQdOGhzLl0cWBsIQhdN2CMxLyiT6XtUk9WYE3m',
    'redirect_uri'          => 'http://localhost:8000/auth/psu/callback',
    'oauth_authorize_url'   => 'https://oauth2.eng.psu.ac.th/authorize',
    'oauth_token_url'       => 'https://oauth2.eng.psu.ac.th/authorize/token',
    'userinfo_endpoint_url' => 'https://oauth2.eng.psu.ac.th/resource/userinfo'

];
