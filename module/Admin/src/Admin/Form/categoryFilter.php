<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class categoryFilter extends InputFilter
{
    public function __construct($sm)
    {
        $this->add(array(
            'name'     => 'cat_name',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 100,
                    ),
                )
            ),
        ));

        $this->add(array(
            'name'     => 'cat_parent_id',
            'required' => false,
        ));

        $this->add(array(
            'name'     => 'cat_desc',
            'required' => false,
        ));
    }
}