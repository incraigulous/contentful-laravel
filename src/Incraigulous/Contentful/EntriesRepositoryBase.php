<?php
namespace Incraigulous\Contentful;

use Illuminate\Support\Collection;
use Contentful;
use ContentfulManagement;
use Incraigulous\ContentfulSDK\PayloadBuilders\Entry;
use Incraigulous\ContentfulSDK\PayloadBuilders\Field;
use Incraigulous\Contentful\Model;


abstract class EntriesRepositoryBase {
    protected $id;

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
     * @return Model
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
     * Get an entry model from with includes from Contentful by ID.
     * @param $id
     * @return Model
     */
    public function findWithRelationships($id, $includeDepth = 3)
    {
        return $this->getModel(
            Contentful::entries()
                ->limitByType($this->id)
                ->where('sys.id', '=', $id)
                ->includeLinks($includeDepth)
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
     * @return Array
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
     * @return Model
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
     * @param null $previous
     * @return mixed
     */
    public function unpublish($id, $previous = null)
    {
        if (!$previous) $previous = $this->get($id);
        return ContentfulManagement::entries()
            ->contentType($this->id)
            ->unpublish($id, $previous);
    }

    /**
     * Publish a Contentful entry.
     * @param $id
     * @param $previous
     * @return mixed
     */
    public function publish($id, $previous)
    {
        if (!$previous) $previous = $this->get($id);
        return ContentfulManagement::entries()
            ->contentType($this->id)
            ->publish($id, $previous);
    }

    /**
     * Archive a Contentful entry.
     * @param $id
     * @return mixed
     */
    public function archive($id)
    {
        return ContentfulManagement::entries()
            ->contentType($this->id)
            ->archive($id);
    }

    /**
     * Unarchive a Contentful entry.
     * @param $id
     * @return mixed
     */
    public function unarchive($id)
    {
        return ContentfulManagement::entries()
            ->contentType($this->id)
            ->unarchive($id);
    }

    /**
     * Parse a Contentful result search list and return a collection object for only the fields.
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
     * Return a record as a model. If the result is a search list, return only the first item.
     * @param $result
     * @return Model
     */
    protected function getModel($result) {
        if (isset($result['items'])) return $this->getModelFromList($result);
        return ModelFactory::make($result, [], $this->id);
    }

    /**
     * Return the first item from a search list as a model.
     * @param $result
     * @return Model
     */
    protected function getModelFromList($result) {
    		$includes = isset( $result['includes'] ) ? $includes : array();
        return ModelFactory::make($result['items'][0], $result['includes'], $this->id);
    }
}
