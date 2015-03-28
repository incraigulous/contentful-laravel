<?php
return array(

    /*
    |--------------------------------------------------------------------------
    | Contentful API Space
    |--------------------------------------------------------------------------
    |
    | Get this from the Contentful api panel.
    |
    */

    'space' => '',

    /*
    |--------------------------------------------------------------------------
    | Contentful API Token
    |--------------------------------------------------------------------------
    |
    | Get this from the Contentful api panel.
    |
    */
    'token' => '',

    /*
    |--------------------------------------------------------------------------
    | Contentful oAuth Token (needed for management API only)
    |--------------------------------------------------------------------------
    |
    | Instructions for generating an oAuth token can be found in the Contentful's
    | Management API documentation. If you are generating it dynamically, you
    | should create your own Facade for the management API.
    |
    */
    'oauthToken' => '',

    /*
    |--------------------------------------------------------------------------
    | Cache Tag
    |--------------------------------------------------------------------------
    |
    | Cache tag to make sure we can target and clear only Contentful cached items.
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