<?php

Route::get('contentful/flush', function()
{
    $cacher = new \Incraigulous\Contentful\Cacher();
    $cacher->flush();
});