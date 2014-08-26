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
	public function getAuthService(){
		if(!$this->authservice){
			$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
			$dbTableAuthAdapter = new dbTableAuthAdapter($dbAdapter, 'ip_users', 'user_login', 'user_pass', 'MD5(?)');
			$authService = new AuthenticationService();
			$authService->setAdapter($dbTableAuthAdapter);
			$this->authservice = $authService;
		}
		return $this->authservice;
	}
	public function processAction(){
		$this->getAuthService()->getAdapter()->setIdentity($this->request->getPost('user_name'))
											 ->setCredentical($this->request->getPost('password'));
		$result = $this->getAuthService()->authenticate();
		exit;
		if($result->isValid()){
			$this->getAuthService()->getStorage()->write($this->request->getPost('user_name'));
			return $this->redirect()->toRouter(NULL, array(
				'controller' => 'index',
				'action'=> 'index',
				));
		}
	}
    public function indexAction()
    {
        $form = new LoginForm();
        $viewModel = new ViewModel(array(
        	'form' => $form,
        ));
        $this->layout('layout/login');
        return $viewModel;
    }
}
