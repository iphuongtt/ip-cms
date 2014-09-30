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

use Admin\Form\categoryForm;
use Admin\Form\categoryFilter;
use Admin\Entity\IpTermTaxonomy;
use Admin\Entity\IpTerms;
use Ip\categoryFunction;
class CategoryController extends AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $searchCategory = $request->getPost()['search_category'];
        if($request->isPost()){
            $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $dql = "SELECT a, b FROM Admin\Entity\IpTermTaxonomy a JOIN a.termId b Where a.taxonomy = 'category' And b.name like ?1 Order By a.parent";
            $categories = $entityManager->createQuery($dql)
                                   ->setParameter(1, '%'. $searchCategory .'%')
                                   ->getResult();
            $view = $categories;
        }else{
            $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $dql = "SELECT a, b FROM Admin\Entity\IpTermTaxonomy a JOIN a.termId b Where a.taxonomy = 'category' Order By a.parent";
            $query = $entityManager->createQuery($dql);
            $categories = $query->getResult();
            $categoryFunction = new categoryFunction($categories);
            $view = $categoryFunction->getListCategory();
        }
        $script = $this->getServiceLocator()->get('viewhelpermanager')
                ->get('inlineScript');
        // No need to add beginning or ending <script> tags, as they
        // will be automatically inserted by the appendScript method.
        $script->appendFile($this->getRequest()->getBasePath() . '/js/Admin/category/index.js');
        return new ViewModel(array('categories' => $view, 'search_category' =>$searchCategory));
    }
    public function addAction(){
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $sl = $this->getServiceLocator();
        $form = $sl->get('FormElementManager')->get('CategoryForm');
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setInputFilter(new categoryFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if($form->isValid()){
                $ipTerms = new IpTerms;
                $data = $form->getData();
                $ipTerms->setName($data['cat_name']);
                $ipTerms->setSlug($data['cat_slug']);
                $ipTermTaxonomy = new IpTermTaxonomy;
                $ipTermTaxonomy->setTermId($ipTerms);
                if($data['cat_parent_id']){
                    $iptermsRepo = $entityManager->getRepository('Admin\Entity\IpTerms');
                    $cat_parent = $iptermsRepo->find($data['cat_parent_id']);
                    $ipTermTaxonomy->setParent($cat_parent);
                }
                $ipTermTaxonomy->setTaxonomy('category');
                $ipTermTaxonomy->setDescription($data['cat_desc']);
                $entityManager->persist($ipTerms);
                $entityManager->persist($ipTermTaxonomy);
                $entityManager->flush();
                return $this->redirect()->toRoute('admin/default', array(
                        'controller' => 'category',
                        'action'=> 'index',
                    ));
            }
        }
        return new ViewModel(array('form' => $form));
    }
    public function editAction(){
        $id = $this->params()->fromRoute('id');
        if (!$id) return $this->redirect()->toRoute('admin/default', array('controller' => 'category', 'action' => 'index'));
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        try {
            $repository = $entityManager->getRepository('Admin\Entity\IpTermTaxonomy');
            $category = $repository->find($id);
        }
        catch (\Exception $ex) {
            echo $ex->getMessage(); // this never will be seen fi you don't comment the redirect
            return $this->redirect()->toRoute('admin/default', array('controller' => 'category', 'action' => 'index'));
        }
        $sl = $this->getServiceLocator();
        $form = $sl->get('FormElementManager')->get('CategoryForm');
        $data = array(
            'cat_name' => $category->getTermId()->getName()
            ,'cat_slug' => $category->getTermId()->getSlug()
            ,'cat_parent_id' => !is_null($category->getParent())?$category->getParent()->getTermId():''
            ,'cat_desc' => $category->getDescription()
        );
        $form->setData($data);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new categoryFilter($this->getServiceLocator()));
            $post = $request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();
                $category->getTermId()->setName($data['cat_name']);
                $category->getTermId()->setSlug($data['cat_slug']);
                if($data['cat_parent_id']){
                    $iptermsRepo = $entityManager->getRepository('Admin\Entity\IpTerms');
                    $cat_parent = $iptermsRepo->find($data['cat_parent_id']);
                    $category->setParent($cat_parent);
                }
                $category->setDescription($data['cat_desc']);
                $entityManager->persist($category);
                $entityManager->flush();
                return $this->redirect()->toRoute('admin/default', array('controller' => 'category', 'action' => 'index'));
             }
        }
        return new ViewModel(array('form' => $form, 'id' => $id));
    }
    public function deleteAction(){
        $id = $this->params()->fromRoute('id');
        if (!$id) return $this->redirect()->toRoute('admin/default', array('controller' => 'category', 'action' => 'index'));
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        try {
            $repository = $entityManager->getRepository('Admin\Entity\IpTermTaxonomy');
            $category = $repository->find($id);
            if($repository->hasChildrent($category->getTermId()->getTermId())){
                return $this->redirect()->toRoute('admin/default', array('controller' => 'category', 'action' => 'index'));
            }else{
                $entityManager->remove($category);
                $entityManager->flush();
            }
        }
        catch (\Exception $ex) {
            echo $ex->getMessage(); // this never will be seen fi you don't comment the redirect
            return $this->redirect()->toRoute('admin/default', array('controller' => 'category', 'action' => 'index'));
        }
        return $this->redirect()->toRoute('admin/default', array('controller' => 'category', 'action' => 'index'));
    }
    public function editinlineAction(){
        $request = $this->getRequest();
        $post = $request->getPost();
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $qi = function($name) use ($adapter) { return $adapter->platform->quoteIdentifier($name); };
        $fp = function($name) use ($adapter) { return $adapter->driver->formatParameterName($name); };
        $sql = 'UPDATE ' . $qi('ip_terms')
            . ' SET ' . $qi('name') . ' = ' . $fp('name')
            . ' ,' . $qi('slug') . ' = ' . $fp('slug')
            . ' WHERE ' . $qi('term_id') . ' = ' . $fp('id');
        $statement = $adapter->query($sql);
        $parameters = array(
            'name' => $post['name']
            ,'slug' => $post['slug']
            ,'id' => $post['id']
        );
        $statement->execute($parameters);
        $result = array('error' => '');
        echo json_encode($result);
        exit;
        /*

        $statement = $adapter->query('SELECT * FROM '. $qi('ip_terms'));
            #. ' WHERE user_login = ' . $fp('id'));


        $results = $statement->execute(array('id' => 'admin'));

        $returnArray = array();
        // iterate through the rows
        foreach ($results as $result) {
            $returnArray[] = $result;
        }
        var_dump($returnArray);*/
        return $this->getResponse();
    }
}
