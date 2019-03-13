<?php
namespace Application\Model;

use Zend\Cache\StorageFactory;
use Zend\Http\Client;
use Zend\Http\Request;

class Test
{
    protected $_serviceLocator;

    public function setServiceLocator($serviceLocator) {
        $this->_serviceLocator = $serviceLocator;
    }

    public function getServiceLocator() {
        return $this->_serviceLocator;
    }

    public function getNumberSequence($number)
    {
        $result = 3 + ($number * ($number - 1));
        return $result;
    }

    public function getPlaceSearch($lat = null, $lng = null, $key)
    {
        $radius = 50000;
        $name = 'restaurants in Bangsue area';    
        $url = 'https://maps.googleapis.com/maps/api/place/search/json?name='.urlencode($name).'&location='.$lat.','.$lng.'&radius='.$radius.'&key='.$key;
        
        $client = new Client();
        $request = new Request();
        $request->setUri($url);
        $response = $client->send($request);
        $result = $response->getBody();
        
        return $result;
    }

    public function getCachePlaceSearch($lat = null, $lng = null, $key)
    {
        $cache = StorageFactory::factory([
            'adapter' => [
                'name'    => 'filesystem',
                'options' => [
                    'cache_dir' => './data/cache',
                    'ttl' => 86400
                ],
            ],
            'plugins' => [
                'exception_handler' => ['throw_exceptions' => false],
            ],
        ]);
        
        $cacheKey = 'restaurants-events';   
        $events = $cache->getItem($cacheKey, $success);

        if(!$success) {
            $result = $this->getPlaceSearch($lat, $lng, $key);
            $cache->setItem($cacheKey, $result);
        }
        
        return $cache->getItem($cacheKey);
    }
}