<?php
/**
 * Created by PhpStorm.
 * User: phuongtt
 * Date: 12/09/2014
 * Time: 14:43
 */
namespace Admin\Form;
use Zend\Form\Form;
use Ip\tree;
class categoryForm  extends Form{
    public $entityManager;
    public function __construct($entityManager){
        $this->entityManager = $entityManager;
        parent::__construct('category');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role','form');
        $this->setAttribute('class','form-horizontal');
        $this->add(array(
            'name' => 'cat_name',
            'attributes' => array(
                'type'=>'text',
                'required'=>'required',
                'class'=>'form-control focus',
                'placeholder'=>'Tên chuyên mục',
            ),
            'options' => array(
                'label' => 'Tên chuyên mục',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                ),
            ),
        ));
        $this->add(array(
            'name'    => 'cat_parent_id',
            'type'    => 'Zend\Form\Element\Select',
            'options' => array(
                'label'         => 'Chuyên mục cha',
                'value_options' => $this->getOptionsForSelect(),
                'empty_option'  => '--- chọn chuyên mục cha ---',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                ),
            )
        ));

        $this->add(array(
            'name' => 'cat_desc',
            'type' => 'textarea',
            'attributes'=>array(
                'class'=>'form-control',
                'id'=>'cat_desc',
                'placeholder'=>'Mô tả',
            ),
            'options' => array(
                'label' => 'Mô tả',
                'label_attributes'=> array(
                    'class' => 'col-sm-2 control-label',
                    'for'=>'cat_desc',
                )
            ),
        ));

        $this->add(array(
            'name' => 'cat_slug',
            'type' => 'text',
            'attributes'=>array(
                'class'=>'form-control',
                'id'=>'cat_slug',
                'placeholder'=>'Slug',
            ),
            'options' => array(
                'label' => 'Slug',
                'label_attributes'=> array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'required'=>'required',
                'value'=>'Cập nhật',
                'class'=>'btn btn-default',
            ),
        ));
    }
    public function getOptionsForSelect(){
        $dql = "SELECT a, b FROM Admin\Entity\IpTermTaxonomy a JOIN a.termId b Where a.taxonomy = 'category' Order By a.parent";
        $query = $this->entityManager->createQuery($dql);
        #$query->setMaxResults(30);
        $cats = $query->getResult();
        #var_dump($cats);
        if(empty($cats))
            return $cats;
        else{
            $tree = new tree;
            $tree->pushNode($tree->createNode($cats[0], $cats[0]->getTermId()->getTermId()));
            $nCats = sizeof($cats);
            for($i = 1; $i < $nCats; $i++){
                $stack = $tree->getStack();
                foreach ($stack as $key => $value) {
                    if($cats[$i]->getParent() == $value->getValue()->getParent() && !$value->hasRight()){
                        $tree->pushNode($tree->createNode($cats[$i], $cats[$i]->getTermId()->getTermId()));
                        $tree->setNodeRight($key, $tree->getNode($cats[$i]->getTermId()->getTermId()));
                        break;
                    }
                    if(!is_null($cats[$i]->getParent()) &&  $key == $cats[$i]->getParent()->getTermId() && !$value->hasLeft()){
                        $tree->pushNode($tree->createNode($cats[$i], $cats[$i]->getTermId()->getTermId()));
                        $tree->setNodeLeft($key, $tree->getNode($cats[$i]->getTermId()->getTermId()));
                        break;
                    }
                }
            }
            $numberSpace = 5;
            $walk =$tree->walk();
            $result = array();
            foreach ($walk as $key => $value) {
                $id = $value->getTermId()->getTermId();
                $depth = $value->depth;
                $name = str_repeat('&nbsp;', $depth * $numberSpace) . $value->getTermId()->getName();
                $result[$id] = $name;
            }
            return $result;
        }
    }
}