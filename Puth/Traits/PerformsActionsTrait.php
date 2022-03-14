<?php

namespace Puth\Traits;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use Puth\GenericObject;
use SebastianBergmann\Comparator\ComparisonFailure;

trait PerformsActionsTrait
{
    private function callMethod($function, $parameters = [])
    {
        // Serialize parameters if needed
        $parameters = array_map(function ($item) {
            if ($item instanceof GenericObject) {
                return $item->serialize();
            }
            return $item;
        }, $parameters);
        
        $response = $this->getClient()->patch('context/call', ['json' => [
            'context' => $this->getContext()->getRepresentation(),
            'type' => $this->getType(),
            'id' => $this->getId(),
            'function' => $function,
            'parameters' => $parameters,
        ]]);
        
        $this->log('call method > ' . $this->translateActionReverse($function));
        
        return $this->handleResponse($response, [$function, $parameters], function ($body, $arguments) {
            throw new \Exception($body->message);
        });
    }
    
    private function getProperty($property)
    {
        $response = $this->getClient()->patch('context/get', ['json' => [
            'context' => $this->getContext()->getRepresentation(),
            'type' => $this->getType(),
            'id' => $this->getId(),
            'property' => $property,
        ]]);
        
        $this->log('get property > ' . $property);
        
        return $this->handleResponse($response, [$property], function ($body, $arguments) {
            $trace = debug_backtrace();
            trigger_error(
                'Undefined property: ' . get_class($this) . '::$' . $arguments[0] .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'],
                E_USER_NOTICE);
            
            return null;
        });
    }
    
    private function handleResponse($response, $arguments, $onError)
    {
        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Something unecpexed happened!');
        }
        
        $body = $this->toJson($response->getBody());
        
        if ($this->getContext()->isDebug()) {
            var_dump($body);
        }
    
        // var_dump($body);
        
        if (empty($body)) {
            return $this;
        }
        
        if (!property_exists($body, 'type')) {
            throw new \Exception('$body->type not defined!');
        }
        
        if ($body->type === 'error') {
            return $onError($body, $arguments);
        } else if ($body->type === 'GenericObject') {
            return new GenericObject($body->id, $body->type, $body->represents, $this);
        } else if ($body->type === 'GenericObjects') {
            return array_map(function ($item) {
                return new GenericObject($item->id, $item->type, $item->represents, $this);
            }, $body->value);
        } else if ($body->type === 'GenericValue') {
            return $body->value;
        } else if ($body->type === 'GenericValues') {
            return $body->value;
        } else if ($body->type === 'PuthAssertion') {
            return $body;
        } else {
            $this->log('unhandled body type: ' . $body->type);
        }
        
        return $this;
    }
    
    private function toJson($response)
    {
        return json_decode($response);
    }
}
