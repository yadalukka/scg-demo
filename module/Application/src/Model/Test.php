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
        //var_dump($result);
        $result = json_decode($result, true);
        //var_dump($result);
        //if(isset($result['next_page_token']) && !empty($result['next_page_token'])) {
            /*$next = $result['next_page_token'];
            $next_url = 'https://maps.googleapis.com/maps/api/place/search/json?key='.$key.'&pagetoken='.$next;
            $request->setUri($next_url);
            $response = $client->send($request);
            $next_result = $response->getBody();*/
            //$result['results'].push();
        //}
        //var_dump($result['next_page_token']);
        return (isset($result['next_page_token']) && !empty($result['next_page_token'])) ? $this->getNextPage($result, null, $key) : $result;
    }

    public function getNextPage($result, $next_result = null, $key)
    {
        $client = new Client();
        $request = new Request();
        $next = $result['next_page_token'];
        //var_dump($next);
        $next_url = 'https://maps.googleapis.com/maps/api/place/search/json?key='.$key.'&pagetoken='.$next;
        //var_dump($next_url);
        $request->setUri($next_url);
        $response = $client->send($request);
        $next_result = $response->getBody();
        
        $next_result = json_decode($next_result, true);
        //var_dump($next_result['results']);

        $result['results'][count($result['results']) + 1] = $next_result['results'];
        echo '<pre>';
        print_r($result);
        //$result['results'] = array_merge($result['results'], $next_result['results']);
        $result['next_page_token'] = $next_result['next_page_token'];
        //var_dump($result['results']);
        //var_dump($this->getNextPage($result, $next_result, $key));
        return (isset($next_result['next_page_token']) && !empty($next_result['next_page_token'])) ? $this->getNextPage($result, $next_result, $key) : $result;
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
            $result = $this->getPlaceSearch($lat = null, $lng = null, $key);
            $cache->setItem($cacheKey, $result);
        }
        
        return $cache->getItem($cacheKey);
    }
}