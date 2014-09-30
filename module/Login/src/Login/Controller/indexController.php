<?php
namespace Login\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Login\Entity\IpUsers;
use Login\Form\LoginForm;
use Login\Form\LoginFilter;
class IndexController extends AbstractActionController{
	public function indexAction(){
		$form = new LoginForm();
		$form->get('submit')->setValue('Đăng nhập');
		$messages = null;
		$request = $this->getRequest();
        $error = '';
        if ($request->isPost()) {
			$form->setInputFilter(new LoginFilter($this->getServiceLocator()));			
            $form->setData($request->getPost());
            if ($form->isValid()) {
				$data = $form->getData();
				$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
				$adapter = $authService->getAdapter();
				$adapter->setIdentityValue($data['user_name']);
				$adapter->setCredentialValue($data['password']);
				$authResult = $authService->authenticate();
				if ($authResult->isValid()) {
					$identity = $authResult->getIdentity();
                    //$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
                    //$usersRepository = $em->getRepository('Login\Entity\IpUsers');
                    //var_dump($usersRepository->test());exit;
					$authService->getStorage()->write($identity);
					$time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
					if ($data['rememberme']) {
						$sessionManager = new \Zend\Session\SessionManager();
						$sessionManager->rememberMe($time);
					}
                    return $this->redirect()->toRoute('admin/default', array(
                        'controller' => 'index',
                        'action'=> 'index',
                    ));
				}else{
                    $error = 1;
                }
				foreach ($authResult->getMessages() as $message) {
					$messages .= "$message\n"; 
				}
			}{
                $error = 1;
            }
		}
        $this->layout('layout/login');
		return new ViewModel(array(
			'error' => $error,
			'form'	=> $form,
			'messages' => $messages,
		));
	}
    public function logoutAction(){
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
        }
        $auth->clearIdentity();
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->forgetMe();
        return $this->redirect()->toRoute('login/default', array('controller' => 'index', 'action' => 'index'));
    }
}