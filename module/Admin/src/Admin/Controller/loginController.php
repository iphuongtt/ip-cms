<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable As DbTableAuthAdapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\LoginForm;
class LoginController extends AbstractActionController
{
	protected $authservice;
	protected $storage;
	protected $form; 
	public function getAuthService1(){
		if(!$this->authservice){
			$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
			$dbTableAuthAdapter = new dbTableAuthAdapter($dbAdapter, 'ip_users', 'user_login', 'user_pass', 'MD5(?)');
			$authService = new AuthenticationService();
			$authService->setAdapter($dbTableAuthAdapter);
			$this->authservice = $authService;
		}
		return $this->authservice;
	}
	public function getAuthService(){
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }
    public function getSessionStorage(){
        if (!$this->storage) {
            $this->storage = $this->getServiceLocator()->get('Admin\Model\LoginStorage');
        }
        return $this->storage;
    }

	public function dologinAction(){
		$this->getAuthService()->getAdapter()->setIdentity($this->request->getPost('user_name'))
											 ->setCredential($this->request->getPost('password'));
		$result = $this->getAuthService()->authenticate();
		if($result->isValid()){
			$this->getAuthService()->getStorage()->write($this->request->getPost('user_name'));
			$sessionUser = new \Zend\Session\Container('user');
			$sessionUser->login = true;
			return $this->redirect()->toRoute(NULL, array(
				'controller' => 'index',
				'action'=> 'index',
				));


			//check authentication...
            $this->getAuthService()->getAdapter()
                                   ->setIdentity($request->getPost('user_name'))
                                   ->setCredential($request->getPost('password'));
                                    
            $result = $this->getAuthService()->authenticate();
            foreach($result->getMessages() as $message)
            {
                //save message temporary into flashmessenger
                $this->flashmessenger()->addMessage($message);
            }
             
            if ($result->isValid()) {
                $redirect = 'success';
                //check if it has rememberMe :
                if ($request->getPost('rememberme') == 1 ) {
                    $this->getSessionStorage()
                         ->setRememberMe(1);
                    //set storage again 
                    $this->getAuthService()->setStorage($this->getSessionStorage());
                }
                $this->getAuthService()->getStorage()->write($request->getPost('username'));
            }
		}else{			
			$form = new LoginForm();
			$model = new ViewModel(array(
				'error'=>true,
				'form'=>$form,
				));
			$this->layout('layout/login');
			$model->setTemplate('admin/login/index');
			return $model;
		}		
	}
	public function logoutAction(){
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
        $this->flashmessenger()->addMessage("You've been logged out");
        return $this->redirect()->toRoute('login');
    }
    public function indexAction()
    {
    	echo 'controller: login<br>action: index';exit;
        $form = new LoginForm();
        $viewModel = new ViewModel(array(
        	'form' => $form,
        ));
        $this->layout('layout/login');
        return $viewModel;
    }
    public function testAction()
    {
    	echo $this->params()->fromRoute('status'). '- '.$this->params()->fromRoute('page'). '-'.$this->params()->fromRoute('sortBy');
    	echo 'controller: login<br>action: test';exit;
        $form = new LoginForm();
        $viewModel = new ViewModel(array(
        	'form' => $form,
        ));
        $this->layout('layout/login');
        return $viewModel;
    }
}
