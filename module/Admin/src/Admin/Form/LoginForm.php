<?php
namespace Admin\Form;
use zend\Zend\Form\Form;
class LoginForm extends Form{
	public function __construct($name = null){
		parent::__construct('Login');
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/form-data');
		$this->add(array(
			'name' => 'user_name',
			'attributes'=> array(
				'type'=>'text',
				'required'=>'required',
			),
			'options'=> array(
				'label' => 'Tên đăng nhập',
			),
			'filters'=> array(
				'name'=>'StringTrim',
			),
			'validators'=>array(

			),
		));
		$this->add(array(
			'name'=> 'password',
			'attributes'=>array(
				'type'=>'password',
				'required'=>'required',
			),
			'options'=>array(
				'label'=>'Mật khẩu',
			),
			'filters'=>array(
				'name'=>'StringTrim',
			),
		));
		$this->add(array(
			'name'=>'login_btn',
			'attributes'=>array(
				'type'=>'submit',
			),
			'options'=>array(
				'value'=>Đăng nhập
			),
		));
	}
}