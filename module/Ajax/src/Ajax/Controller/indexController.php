<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Ajax\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        // Only add the script in the "production" environment.
        $script = $this->getServiceLocator()->get('viewhelpermanager')
                ->get('inlineScript');
        // No need to add beginning or ending <script> tags, as they
        // will be automatically inserted by the appendScript method.
        $script->appendFile($this->getRequest()->getBasePath() . '/js/jqueryUi/ui/jquery-ui.custom.js');
        $script->appendFile($this->getRequest()->getBasePath() . '/js/Ajax/index.js');
        return new ViewModel();
    }
}
