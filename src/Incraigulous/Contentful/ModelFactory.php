<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 4/13/15
 * Time: 1:00 PM
 */

namespace Incraigulous\Contentful;

class ModelFactory {
    protected static function getModelClassFromId($id)
    {
        $map = config('contentful.models');
        return (isset($map[$id])) ? $map[$id] : null;
    }
    public static function make(array $resource, array $includes = [], $contentTypeId = null)
    {
        if ($contentTypeId) {
            $modelClass = self::getModelClassFromId($contentTypeId);
            if ($modelClass) {
                return new $modelClass($resource, $includes);
            }
        }
        return new Model($resource, $includes);
    }
}