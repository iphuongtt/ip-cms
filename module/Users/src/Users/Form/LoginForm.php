<?php
namespace Users\Form;
use Zend\Form\Form;
class LoginForm extends Form{
	public function __construct($name = null){
		parent::__construct('Login');
		$this->setAttribute('method', 'post')
			->setAttribute('enctype', 'multipart/form-data');
		$this->add(array(
			'name'=>'email',
			'attributes'=> array(
				'type'=>'email',
				'required'=>'required',
			),
			'options'=>array(
				'label'=>'Email'
			),
			'filters'=>array(
				array('name'=>'StringTrim',)
			),
			'validators'=>array(
				array('name'=>'EmailAddress',
					'options'=>array(
						'messages'=> array(\Zend\Validator\EmailAddress::INVALID_FORMAT=> 'Định dạng email không đúng'),
					),
				)
			),
		));
		$this->add(array(
			'name'=>'Login',
			'attributes'=>array(
				'type'=>'submit',
			),
			'options'=>array('value'=>'Login'),	
		));
	}
}