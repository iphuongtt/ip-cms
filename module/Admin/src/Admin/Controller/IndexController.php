<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function __construct(){
        echo 'aaa';
    }
    public function indexAction()
    {    	
        echo 'controller: index <br> action: index';exit;
        $sessionUser = new \Zend\Session\Container('user');
        return new ViewModel();
    }
	public function testAction()
    {
        return new ViewModel();
    }
}
