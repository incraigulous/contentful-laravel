<?php
return array(

    /*
    |--------------------------------------------------------------------------
    | Contentful API Space
    |--------------------------------------------------------------------------
    |
    | Get this from the contentful api panel.
    |
    */

    'space' => '',

    /*
    |--------------------------------------------------------------------------
    | Contentful API Token
    |--------------------------------------------------------------------------
    |
    | Get this from the contentful api panel.
    |
    */
    'token' => '',

    /*
    |--------------------------------------------------------------------------
    | Contentful oAuth Token (needed for management API only)
    |--------------------------------------------------------------------------
    |
    | Insturctions for generating an oAuth token can be found in the Contentful's
    | Management API documentation. If you are generating it programatically, you
    | should create your own Facade for the management API.
    |
    */
    'oauthToken' => '',

    /*
    |--------------------------------------------------------------------------
    | Cache Tag
    |--------------------------------------------------------------------------
    |
    | Cache tag to make sure we can target and clear only contentful cached items.
    |
    */
    'cacheTag' => 'contentful',

    /*
   |--------------------------------------------------------------------------
   | Cache Time
   |--------------------------------------------------------------------------
   |
   | In minutes.
   |
   */
    'cacheTime' => '60'
);