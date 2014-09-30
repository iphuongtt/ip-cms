<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Media\Model\ipfiles;

class IndexController extends AbstractActionController
{
    public function __construct(){
        ;
    }
    public function indexAction()
    {
        $script = $this->getServiceLocator()->get('viewhelpermanager')
                ->get('inlineScript');
        // No need to add beginning or ending <script> tags, as they
        // will be automatically inserted by the appendScript method.
        $script->appendFile($this->getRequest()->getBasePath() . '/js/Media/index/index.js');
        return new ViewModel();
    }
    public function getTreeAction(){
        $request = $this->getRequest();
        $config = $this->getServiceLocator()->get('Config');
        $dir = realpath($config['module_params']['media_path']);
        $folderName = $_REQUEST['path'];
        $dir = $dir.DIRECTORY_SEPARATOR.$folderName;
        if(is_dir($dir)){
            $files = scandir($dir);
            $arrDir = array();
            $arrFiles = array();
            array_shift($files);
            array_shift($files);
            foreach ($files as $key => $value) {
                $filePath = realpath($dir.DIRECTORY_SEPARATOR.$value);
                if(is_file($filePath)){
                    $arrFiles[] = new ipfiles($filePath,$value);
                }
                if(is_dir($filePath)){
                    $arrDir[] = $value;
                }
            }

            $arrTree = array();
            foreach($arrDir as $key => $value){
                array_push($arrTree,array(
                    'name' => $value
                    ,'path' => $folderName.DIRECTORY_SEPARATOR.$value
                    ,'title' => $value
                    ,'hasItems'=>$this->hasSubDir($dir.DIRECTORY_SEPARATOR.$value)
                ));
            }
            echo json_encode($arrTree);exit;
        }
    }
    public function getFileAction(){
        $request = $this->getRequest();
        $config = $this->getServiceLocator()->get('Config');
        $dir = realpath($config['module_params']['media_path']);
        $folderName = $_REQUEST['path'];
        $dir = $dir.DIRECTORY_SEPARATOR.$folderName;
        if(is_dir($dir)){
            $files = scandir($dir);
            $arrFiles = array();
            array_shift($files);
            array_shift($files);
            foreach ($files as $key => $value) {
                $filePath = realpath($dir.DIRECTORY_SEPARATOR.$value);
                if(is_file($filePath)){
                    $arrFiles[] = new ipfiles($filePath,$value);
                }
                if(is_dir($filePath)){
                    $arrDir[] = $value;
                }
            }
        }
        $viewModel = new ViewModel(array('files'=>$arrFiles));
        $viewModel->setTemplate('media/index/get-file-thumnail');
        #$viewModel->setTemplate('media/index/get-file-list');
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    function hasSubDir($dir){
        $files = scandir($dir);
        array_shift($files);
        array_shift($files);
        foreach ($files as $key => $value) {
            $filePath = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(is_dir($filePath)){
                return '1';
            }
        }
        return false;
    }
}