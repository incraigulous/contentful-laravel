<?php
namespace Incraigulous\Contentful;

use Illuminate\Support\Collection;
use Contentful;

abstract class BaseRepository {
    protected $id;
    protected $cacheTime = 30;
    protected $cacheTag = 'contentful';

    /**
     * Get all entries for content type from contentful.
     * @return Collection
     */
    public function all()
    {
        return $this->getCollection(
            Contentful::entries()
                ->limitByType($this->id)
                ->get()
        );
    }

    /**
     * Get an entry from Contentful by ID.
     * @param $id
     * @return Collection
     */
    public function find($id)
    {
        return $this->getModel(
            Contentful::entries()
                ->limitByType($this->id)
                ->find($id)
                ->get()
        );
    }

    /**
     * Parse a Contentful result and return a collection object for only the fields.
     * @param $result
     * @return Collection
     */
    protected function getCollection($result) {
        $items = array();
        foreach($result['items'] as $item) {
            $items[] = $this->getModel($item['fields']);
        }
        return new Collection($items);
    }

    /**
     * Return a Contentful fields array as an object.
     * @param $fields
     * @return StdClass
     */
    protected function getModel($fields) {
        return json_decode(json_encode($fields), FALSE);
    }
}