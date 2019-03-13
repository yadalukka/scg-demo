<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element\Button;

class TestForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('test');

        $this->add([
            'name' => 'number',
            'type' => 'number',
            'options' => [
                'label' => 'Input number to finding value.',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Number',
            ],
        ]);

        $this->add([
            'type' => 'Button',
            'name' => 'submit',
            'options' => [
                'label' => '<span class="icon text-white-50">
                <i class="fas fa-check"></i>
                </span>
                <span class="text">Submit</span>',
                'label_options' => [
                    'disable_html_escape' => true,
                ]
            ],
            'attributes' => [
                'type'  => 'submit',
                'class' => 'btn btn-success btn-icon-split'
            ]
        ]);
    }
}