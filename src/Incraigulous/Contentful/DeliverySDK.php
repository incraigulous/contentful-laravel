<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/26/15
 * Time: 9:51 PM
 */

namespace Incraigulous\Contentful;

class DeliverySDK {
    protected $client;
    protected $requestDecorator;

    function __construct($spaceId, $accessToken)
    {
        $this->client = new DeliveryClient($spaceId, $accessToken);
        $this->requestDecorator = new RequestDecorator();
    }

    //RESOURCES

    function assets()
    {
        $this->requestDecorator->setResource('assets');
        return $this;
    }

    function contentTypes()
    {
        $this->requestDecorator->setResource('content_types');
        return $this;
    }

    function entries()
    {
        $this->requestDecorator->setResource('entries');
        return $this;
    }

    function spaces()
    {
        $this->requestDecorator->setResource('spaces');
        return $this;
    }

    //ACTIONS

    function limitByType($contentType)
    {
        $this->contentType($contentType);
        return $this;
    }

    function contentType($contentType)
    {
        $this->requestDecorator->addParameter('content_type', '=', $contentType);
        return $this;
    }

    function find($id)
    {
        $this->requestDecorator->setId($id);
        return $this;
    }

    function where($field, $operator, $value) {
        switch ($operator) {
            //EQUALITY
            case '=':
                $this->requestDecorator->addParameter($field, '=', $value);
        break;
            //INEQUALITY
            case '!=':
            case '[ne]':
            case 'ne':
                $this->requestDecorator->addParameter($field, '[ne]', $value);
        break;
            //INCLUSION
            case '[in]':
            case 'in':
                $this->requestDecorator->addParameter($field, '[in]', $value);
        break;
            //EXCLUSION
            case '[nin]':
            case 'nin':
                $this->requestDecorator->addParameter($field, '[nin]', $value);
        break;
            //LESS THAN
            case '<':
            case '[lt]':
            case 'lt':
                $this->requestDecorator->addParameter($field, '[lt]', $value);
        break;
            //GREATER THAN
            case '>':
            case '[gt]':
            case 'gt':
                $this->requestDecorator->addParameter($field, '[gt]', $value);
        break;
            //LESS THAN OR EQUAL TO
            case '<=':
            case '[lte]':
            case 'lte':
                $this->requestDecorator->addParameter($field, '[lte]', $value);
        break;
            //GREATER THAN OR EQUAL TO
            case '>=':
            case '[gte]':
            case 'gte':
                $this->requestDecorator->addParameter($field, '[gte]', $value);
        break;
            //MATCH
            case 'match':
            case '[match]':
                $this->requestDecorator->addParameter($field, '[match]', $value);
        break;
            //LOCATION - NEAR
            case 'near':
            case '[near]':
                $this->requestDecorator->addParameter($field, '[near]', $value);
        break;
            //LOCATION - WITHIN
            case 'within':
            case '[within]':
                $this->requestDecorator->addParameter($field, '[within]', $value);
        break;
            default:
                $this->requestDecorator->addParameter($field, $operator, $value);
        }
        return $this;
    }

    function full($search) {
        $this->query($search);
        return $this;
    }

    function query($search) {
        $this->requestDecorator->addParameter('query', '=', $search);
        return $this;
    }

    function order($orderBy, $reverse = false) {
        $this->requestDecorator->addParameter('order', ($reverse) ? "=" : "=-", $reverse);
        return $this;
    }

    function limit($number) {
        $this->requestDecorator->addParameter('limit', '=', $number);
        return $this;
    }

    function skip($number) {
        $this->requestDecorator->addParameter('skip', '=', $number);
        return $this;
    }

    function includeLinks($levels) {
        $this->requestDecorator->addParameter('include', '=', 1);
        return $this;
    }

    function get() {
        return $this->client->get($this->requestDecorator->makeResource(), $this->requestDecorator->makeQuery());
    }

}