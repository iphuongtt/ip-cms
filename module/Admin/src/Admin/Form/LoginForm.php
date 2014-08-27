<?php
namespace Admin\Form;
use Zend\Form\Form;
class LoginForm extends Form{
	public function __construct($name = null){
		parent::__construct('Login');
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/form-data');
		$this->setAttribute('class','form-horizontal');
		$this->setAttribute('role','form');
		$this->add(array(
			'name' => 'user_name',
			'attributes'=> array(
				'type'=>'text',
				'required'=>'required',
				'class'=>'form-control focus',
				'placeholder'=>'Tên đăng nhập',
			),
			'options'=> array(
				'label' => 'Tên đăng nhập',
				'label_attributes' => array(
		            'class' => 'col-sm-5 control-label',
		        ),
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
				'class'=>'form-control',
				'placeholder'=>'Mật khẩu'
			),
			'options'=>array(
				'label'=>'Mật khẩu',
				'label_attributes' => array(
		            'class' => 'col-sm-5 control-label',
		        ),
			),
			'filters'=>array(
				'name'=>'StringTrim',
			),
		));
		$this->add(array(
			'name'=>'login_btn',
			'attributes'=> array(
				'type' => 'submit',
				'required'=>'required',
				'value'=>'Đăng nhập',
				'class'=>'btn btn-default',
			),
			'options'=>array(
				'label'=>'submit',
			),
			'filters'=>array(
				array('name'=>'StringTrim'),
			),
		));
	}
}