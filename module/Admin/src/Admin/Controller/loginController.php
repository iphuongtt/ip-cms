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

class LoginController extends AbstractActionController
{
	public function getAuthService(){
		if(!$this->authservice){
			$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		}
	}
    public function indexAction()
    {
        return new ViewModel();
    }
}
