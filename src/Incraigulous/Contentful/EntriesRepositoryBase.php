<?php
namespace Incraigulous\Contentful;

use Illuminate\Support\Collection;
use Contentful;
use ContentfulManagement;
use Incraigulous\ContentfulSDK\PayloadBuilders\Entry;
use Incraigulous\ContentfulSDK\PayloadBuilders\Field;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class EntriesRepositoryBase {
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
     * Get an entry model from Contentful by ID.
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
     * Get an entry from Contentful by ID. Should only be used to get an item to update.
     *
     * IMPORTANT DIFFERENCES BETWEEN GET AND FIND:
     * 1) The get result is returned as an array direct from Contentful, not an object.
     * 2) The get query is made using the management API, so the metadata will be slightly different.
     * 3) The get query is not cached to avoid data version conflicts.
     *
     * @param $id
     * @return Collection
     */
    public function get($id)
    {
        return ContentfulManagement::entries()
                ->limitByType($this->id)
                ->find($id)
                ->get();
    }

    /**
     * Create an entry in Contentful.
     * @param $fields
     * @return StdClass
     */
    public function create($fields)
    {
        foreach($fields as $key => $field) {
            $fields[$key] = new Field($key, $field);
        }
        return $this->getModel(
            ContentfulManagement::entries()
                ->contentType($this->id)
                ->post(new Entry($fields))
        );
    }

    /**
     * Delete an entry from Contentful.
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return ContentfulManagement::entries()
            ->contentType($this->id)
            ->delete($id);
    }

    /**
     * Update an entry in Contentful.
     * @param $id
     * @param array $payload
     * @return mixed
     */
    public function update($id, array $payload)
    {
        foreach($payload['fields'] as $key => $field) {
            $payload['fields'][$key] = new Field($key, $field);
        }

        return ContentfulManagement::entries()
            ->contentType($this->id)
            ->put($id, $payload);
    }

    /**
     * Unpublish a Contentful entry.
     * @param $id
     * @param $previousVersionOrPayload
     * @return mixed
     */
    public function unpublish($id, $previousVersionOrPayload)
    {
        if (is_array($previousVersionOrPayload)) {
            $previousVersion = $previousVersionOrPayload['sys']['version'];
        } else {
            $previousVersion = $previousVersionOrPayload;
        }

        return ContentfulManagement::entries()
            ->contentType($this->id)
            ->unpublish($id, $previousVersion);
    }

    /**
     * Publish a Contentful entry.
     * @param $id
     * @param $previousVersionOrPayload
     * @return mixed
     */
    public function publish($id, $previousVersionOrPayload)
    {
        if (is_array($previousVersionOrPayload)) {
            $previousVersion = $previousVersionOrPayload['sys']['version'];
        } else {
            $previousVersion = $previousVersionOrPayload;
        }

        return ContentfulManagement::entries()
            ->contentType($this->id)
            ->publish($id, $previousVersion);
    }

    /**
     * Archive a Contentful entry.
     * @param $id
     * @return mixed
     */
    public function archive($id) {
        return ContentfulManagement::entries()
            ->contentType($this->id)
            ->archive($id);
    }

    /**
     * Unarchive a Contentful entry.
     * @param $id
     * @return mixed
     */
    public function unarchive($id) {
        return ContentfulManagement::entries()
            ->contentType($this->id)
            ->unarchive($id);
    }

    /**
     * Parse a Contentful result and return a collection object for only the fields.
     * @param $result
     * @return Collection
     */
    protected function getCollection($result)
    {
        $items = array();
        foreach ($result['items'] as $item) {
            $items[] = $this->getModel($item['fields']);
        }
        return new Collection($items);
    }

    /**
     * Return a Contentful fields array as a parameter bag.
     * @param $fields
     * @return ParameterBag
     */
    protected function getModel($fields) {
        return new ParameterBag($fields);
    }
}