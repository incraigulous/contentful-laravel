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
    | Contentful oAuth Token (needed for management SDK only)
    |--------------------------------------------------------------------------
    |
    | Instructions for generating an oAuth token can be found in Contentful's
    | Management API documentation. If you are generating it dynamically, you
    | should create your own Facade for the management SDK.
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
    'cacheTime' => '60',

    /*
   |--------------------------------------------------------------------------
   | Webhook URL
   |--------------------------------------------------------------------------
   |
   | Url to use for webhook callbacks.
   | You can also specify one of the following options to generate the URL:
   | 'aws', 'laravel', 'custom://url.string'
   |
   | aws: Bases the callback url off the public host name and prepends '/contentful/flush'
   | laravel: Bases the callback url off the Laravel config app:url and prepends '/contentful/flush'
   | Anything else: The string you specify will be used as the url base.
   */
    'WebhookUrlBase' => 'laravel',  //'aws', 'laravel' or 'custom://url.string'
    'WebhookUrlSuffix' => '/contentful/flush',

    /*
   |--------------------------------------------------------------------------
   | Models
   |--------------------------------------------------------------------------
   |
   | Maps content type keys to model namespaces. It is not neccessary to provide custom models.
   | Models are generated on the fly, but the model class can be extended if you need to add
   | custom functionality like presenters or relationships to non-contentful models.
   */
    'models' => [
        //'CONTENT_TYPE_KEY' => 'App\Contentful\Models\ContentTypeModel',
    ]
);
