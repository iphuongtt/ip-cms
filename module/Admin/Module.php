<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Admin\Form\categoryForm;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
class Module implements FormElementProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        /*$this->initSession(array(
            'remember_me_seconds' => 180,
            'use_cookies' => true,
            'cookie_httponly' => true,
            'validators' => array(
                'Zend\Session\Validator\RemoteAddr',
                'Zend\Session\Validator\HttpUserAgent',
            ),
        ));*/
        $this->checklogin($e);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function initSession($config){
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new sessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
    }
    public function checklogin($e){
        $sm = $e->getApplication()->getServiceManager();
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) use($sm) {
            $controller      = $e->getTarget();
            $classController = get_class($controller);
            $auth = $sm->get('Zend\Authentication\AuthenticationService');
            if (!$auth->hasIdentity() && $classController != 'Login\Controller\IndexController') {
                $router = $e->getRouter();
                $url = $router->assemble(array(), array('name' => 'login'));
                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                return $response;
            }
        }, PHP_INT_MAX);
    }
    public function getViewHelperConfig(){
        return array(
            'factories' => array(
                'form_horizontal'=>function($sm){
                    $helper = new View\Helper\formHorizontal;
                    return $helper;
                }
                ,'FormSelectUnEscape'=>function($sm){
                    $helper = new View\Helper\FormSelectUnEscape;
                    return $helper;
                }
                ,'rowAction'=>function($sm){
                    $helper = new View\Helper\rowAction;
                    return $helper;
                }
            )
        );
    }

    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'CategoryForm' => function($sm) {
                        $serviceLocator = $sm->getServiceLocator();
                        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
                        $form = new categoryForm($entityManager);
                        return $form;
                    }
            )
        );
    }
}
