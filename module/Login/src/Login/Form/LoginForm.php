<?php
namespace Login\Form;
use Zend\Form\Form;
class LoginForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role','form');
        $this->setAttribute('class','form-horizontal');
        $this->add(array(
            'name' => 'user_name',
            'attributes' => array(
                'type'=>'text',
                'required'=>'required',
                'class'=>'form-control focus',
                'placeholder'=>'Tên đăng nhập',
            ),
            'options' => array(
                'label' => 'Tên đăng nhập',
                'label_attributes' => array(
                    'class' => 'col-sm-5 control-label',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'=>'password',
                'required'=>'required',
                'class'=>'form-control',
                'placeholder'=>'Mật khẩu'
            ),
            'options' => array(
                'label' => 'Mật khẩu',
                'label_attributes' => array(
                    'class' => 'col-sm-5 control-label',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'rememberme',
			'type' => 'checkbox',
            'attributes'=>array(
                'class'=>'form-control',
                'id'=>'rememberme',
            ),
            'options' => array(
                'label' => 'Ghi nhớ đăng nhập?',
                'label_attributes'=> array(
                    'class' => 'col-sm-5 control-label',
                    'for'=>'rememberme',
                )
            ),
        ));	
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'required'=>'required',
                'value'=>'Đăng nhập',
                'class'=>'btn btn-default',
            ),
        )); 
    }
}