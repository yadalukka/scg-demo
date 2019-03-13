<?php
namespace Application\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Form\TestForm;
use Application\Model\Test;
 
class TestController extends AbstractActionController 
{
    const KEY = 'AIzaSyAImBQiqvaXOQtqeK8VC-9I96kMmB6Mz7I';
    const LATITUDE = 13.7513788;
    const LONGITUDE = 100.5114687;

    public function indexAction()
    {
        $form = new TestForm();
        return new ViewModel([
            'form' => $form
        ]);
    }

    public function findAction()
    {
        $form = new TestForm();

        $request = $this->getRequest();
        $data = $request->getPost();

        $number = isset($data['number']) ? $data['number'] : 0;

        $test = new Test();
        $result = $test->getNumberSequence($number);

        return new ViewModel([
            'result'    => $result,
            'number'    => $number,
            'form'      => $form
        ]);
    }

    public function restaurantsAction()
    {
        $test = new Test();
        $result = $test->getPlaceSearch(self::LATITUDE, self::LONGITUDE, self::KEY);
        
        return new ViewModel([
            'key'           => $key,
            'restaurants'   => isset($restaurants->results) ? $restaurants->results : [],
        ]);
    }

    public function apiAction()
    {
        $test = new Test();
        $result = $test->getCachePlaceSearch(self::LATITUDE, self::LONGITUDE, self::KEY);
        
        return new JsonModel(json_decode($result, true));
    }
}