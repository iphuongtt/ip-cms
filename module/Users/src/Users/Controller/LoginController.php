<?php
namespace Users\Controller;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable As DbTableAuthAdapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;
use Users\Form\LoginFilter;
use Users\Form\LoginForm;

class LoginController extends AbstractActionController{
	public function indexAction(){
		$form = new LoginForm();
		$viewModel = new ViewModel(array('form'=>$form));
		return $viewModel;
	}
	public function getAuthService(){
		if(!$this->authservice){
			$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
			$dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'user', 'email', 'password', 'MD5(?)');
			$authService = new AuthenticationService();
			$authService->setAdapter($dbTableAuthAdapter);
			$this->authservice = $authService;	
		}
		return $this->authservice;
	}
	public function processAction(){
		$this->getAuthService()->getAdapter()->setIdentity($this->request->getPost('email'))
											 ->setCredential($this->request->getPost('password'));
		$result = $this->getAuthService()->authenticate();
		if($result->isValid()){
			$this->getAuthService()->getStorage()->write($this->request->getPost('email'));
			return $this->redirect()->toRoute(NULL, array('controller'=>'login','action'=>'confirm'));
		}
	}	
	public function confirmAction(){
		$userEmail = $this->getAuthService()->getStorage()->read();
		$viewModel = new ViewModel(array(
			'user_email'=>$userEmail
		));
		return $viewModel;
	}
}