<?php

Route::match(['get', 'post'], 'contentful/flush', function()
{
    $cacher = new \Incraigulous\Contentful\Cacher();
    $cacher->flush();
});