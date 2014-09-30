<?php
/** *
 * @copyright iphuong
 * @des quản lý thông tin người sử dụng
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;

use Login\Entity\IpUsers;

class ProfileController extends AbstractActionController
{
    public function indexAction()
    {
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        #$user = new IpUsers;
        $user = $authService->getIdentity();
        $form = $this->getForm($user, $entityManager, 'Cập nhật');
        $form->bind($user);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $this->prepareData($user);
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirect()->toRoute('admin/default', array('controller' => 'index', 'action' => 'index'));
            }
        }
        return new ViewModel(array('form' => $form));
    }
    public function getForm($user, $entityManager, $action){
        $builder = new DoctrineAnnotationBuilder($entityManager);
        $form = $builder->createForm( $user );
        $form->remove('id');
        $form->getInputFilter()->remove('id');

        $form->remove('userLogin');
        $form->getInputFilter()->remove('userLogin');

        $form->remove('userPass');
        $form->getInputFilter()->remove('userPass');

        $form->remove('userActivationKey');
        $form->getInputFilter()->remove('userActivationKey');

        $form->remove('displayName');
        $form->getInputFilter()->remove('displayName');

        $form->remove('userStatus');
        $form->getInputFilter()->remove('userStatus');

        $form->remove('userRegistered');
        $form->getInputFilter()->remove('userRegistered');

        $form->setHydrator(new DoctrineHydrator($entityManager,'Login\Entity\IpUsers'));
        $send = new Element('send');
        $send->setValue($action);
        $send->setAttributes(array(
            'type'  => 'submit'
        ));
        $form->add($send);

        return $form;
    }

    public function prepareData($user)
    {
        $user->setUserRegistered(new \DateTime());
    }
}
