<?php
namespace Incraigulous\Contentful;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class Model implements Arrayable
{

    /**
     * The includes matching fields in this model.
     * @var array
     */
    protected $_includes = [];

    /**
     * A library of includes from the query that generated the model.
     * @var array
     */
    protected $_includeLibrary = [];

    /**
     * A map array connecting model field names to the include.
     * @var array
     */
    protected $_includesMap = [];

    /**
     * The current resource.
     * @var array
     */
    protected $_resource = [];

    function __construct(array $resource, array $includes = array())
    {
        $this->_includeLibrary = $includes;
        $this->_resource = $resource;
        foreach ($resource['fields'] as $key => $field) {
            $this->_extractLinks($key, $field);
        }
    }

    /**
     * Recursively extract links from a field.
     * @param $key
     * @param $subject
     */
    protected function _extractLinks($key, $subject)
    {
        if (!is_array($subject)) return;
        if ((isset($subject['type'])) && ($subject['type'] == 'Link')) {
            $this->_setInclude($key, $subject);
        } else {
            foreach($subject as $part) {
                $this->_extractLinks($key, $part);
            }
        }
    }

    /**
     * Check the include library for include, and if it exists, create a model and add it to the includes array.
     * @param $key
     * @param array $sys
     */
    protected function _setInclude($key, array $sys)
    {
        if (!count($this->_includeLibrary)) return;
        foreach($this->_includeLibrary[$sys['linkType']] as $include) {
            if ($include['sys']['id'] == $sys['id']) {
                $this->_includesMap[$key][] = ['linkType' => $sys['linkType'], 'id' => $sys['id']];
                $this->_includes[$sys['linkType']][$sys['id']] = new Model($include, $this->_includeLibrary);
                return;
            }
        }
    }

    /**
     * Get all includes for a field name.
     * @param $name
     * @return Model|Collection|null
     */
    protected function _getIncludesByName($name)
    {
        $map = $this->_includesMap[$name];
        if (empty($map)) return null;
        if (count($map) == 1) return $this->_includes[$this->_includesMap[0]['linkType']][$this->_includesMap[0]['id']];

        $results = [];
        foreach($map as $mapItem) {
            $results[] = $this->_includes[$mapItem['linkType']][$mapItem['id']];
        }
        return new Collection($results);
    }

    /**
     * Overload paramater calls to resource fields.
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->_resource['fields'])) {
            return $this->_resource['fields'][$name];
        }
        return null;
    }

    /**
     * Overload method calls to includes.
     * @param $name
     * @param $arguments
     * @return Collection|Model|null
     */
    public function __call($name, $arguments)
    {
        return $this->_getIncludesByName($name);
    }

    /**
     * Return the fields as an array.
     * @return mixed
     */
    public function toArray()
    {
        return $this->_resource['fields'];
    }

    /**
     * Return the resource as an array.
     * @return array
     */
    public function make()
    {
        return $this->_resource;
    }
}