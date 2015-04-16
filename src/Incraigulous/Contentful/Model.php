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
        $this->_setDynamicFields();
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
                $this->_includes[$sys['linkType']][$sys['id']] = ModelFactory::make($include, $this->_includeLibrary, (isset($include['sys']['contentType']['sys']['id'])) ? $include['sys']['contentType']['sys']['id'] : null);
                return;
            }
        }
    }

    /**
     * Get all includes for a field name.
     * @param $name
     * @return Model|Collection|null
     */
    protected function _getIncludesByName($name, $forceList = false)
    {
        $map = $this->_includesMap[$name];
        if (empty($map)) return null;
        if ((count($map) == 1) && (!$forceList)) return $this->_includes[$map[0]['linkType']][$map[0]['id']];

        $results = [];
        foreach($map as $mapItem) {
            $results[] = $this->_includes[$mapItem['linkType']][$mapItem['id']];
        }
        return new Collection($results);
    }

    /**
     * Overload parameter calls to resource fields.
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        return $this->getField($name);
    }

    /**
     * Get a field by name.
     * @param $name
     * @return null
     */
    public function getField($name) {
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
        $array = [];
        foreach($this->_resource['fields'] as $key => $value) {
            $array[$key] = $this->_convertFieldLinks($key, $value);
        }
        return $array;
    }

    /**
     * Recursively convert resource field links to a multi array.
     * @param $field
     * @return array
     */
    protected function _convertFieldLinks($name, $field)
    {
        if (!is_array($field)) return ($this->getField($name)) ? $this->getField($name) : $field;
        $array = [];
        foreach($field as $key => $value) {
            if ((isset($value['type'])) && ($value['type'] == 'Link')) {
                $model = $this->getIncludeFromLibrary($value['linkType'], $value['id']);
                //No include found in library. This is probably a circular include.
                if (!is_object($model)) return null;
                return $model->toArray();
            } else {
                $array[$key] = $this->_convertFieldLinks($key, $value);
            }
        }

        return $array;
    }

    /**
     * Array to generate dynamic fields.
     * ['key' => method()]
     * @return array
     */
    protected function dynamicFields()
    {
        return [];
    }

    /**
     * Set dynamic fields.
     * @return array
     */
    protected function _setDynamicFields()
    {
        $fields = $this->dynamicFields();
        foreach($fields as $key => $content) {
            $this->_resource['fields'][$key] = $content;
        }


    }

    /**
     * Get an include model from the library.
     * @param $type
     * @param $id
     * @return Model|null
     */
    public function getIncludeFromLibrary($type, $id)
    {
        foreach($this->_includeLibrary[$type] as $item) {
            if ($id == $item['sys']['id']) return ModelFactory::make($item, $this->_includeLibrary, (isset($item['sys']['contentType']['sys']['id'])) ? $item['sys']['contentType']['sys']['id'] : null);
        }
        return null;
    }

    /**
     * Does an include exist in the includes library?
     * @param $type
     * @param $id
     * @return bool
     */
    protected function includeExistsInLibrary($type, $id)
    {
        foreach($this->_includeLibrary[$type] as $item) {
            if ($id == $item['sys']['id']) return true;
        }
        return false;
    }

    /**
     * Return the fields as an array.
     * @return mixed
     */
    public function getFields()
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
