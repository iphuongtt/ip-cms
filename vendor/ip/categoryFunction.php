<?php
/**
*@copyright: iphuong
*/
namespace ip;
use Ip\tree;
class categoryFunction{
	private $categories;
	private $tree;
	private $walk;
	private $resultSelectBox;
	public function __construct($categories){
		$this->categories = $categories;
	}
	public function genTree(){
		if(!empty($this->categories)){
			$tree = new tree;
            $tree->pushNode($tree->createNode($this->categories[0], $this->categories[0]->getTermId()->getTermId()));
            $nCats = sizeof($this->categories);
            for($i = 1; $i < $nCats; $i++){
                $stack = $tree->getStack();
                foreach ($stack as $key => $value) {
                    if($this->categories[$i]->getParent() == $value->getValue()->getParent() && !$value->hasRight()){
                        $tree->pushNode($tree->createNode($this->categories[$i], $this->categories[$i]->getTermId()->getTermId()));
                        $tree->setNodeRight($key, $tree->getNode($this->categories[$i]->getTermId()->getTermId()));
                        break;
                    }
                    if(!is_null($this->categories[$i]->getParent()) &&  $key == $this->categories[$i]->getParent()->getTermId() && !$value->hasLeft()){
                        $tree->pushNode($tree->createNode($this->categories[$i], $this->categories[$i]->getTermId()->getTermId()));
                        $tree->setNodeLeft($key, $tree->getNode($this->categories[$i]->getTermId()->getTermId()));
                        break;
                    }
                }
            }
            $this->tree = $tree;
            $this->walk = $tree->walk();
            return $this;
            $walk =$tree->walk();
            $result = array();
            foreach ($walk as $key => $value) {
                $id = $value->getTermId()->getTermId();
                $depth = $value->depth;
                $name = str_repeat($sap, $depth * $numSap) . $value->getTermId()->getName();
                $result[$id] = $name;
            }
            return $result;
        }

	}
	public function setSelectBox($numSap = 5, $sap = '&nbsp;'){
		$resultSelectBox = array();
		if(is_null($this->walk))
			$this->genTree();
		if(!is_null($this->walk)){
	        foreach ($this->walk as $key => $value) {
	            $id = $value->getTermId()->getTermId();
	            $depth = $value->depth;
	            $name = str_repeat($sap, $depth * $numSap) . $value->getTermId()->getName();
	            $resultSelectBox[$id] = $name;
	        }
		}
		$this->resultSelectBox = $resultSelectBox();
		return $this;
	}
	public function getSelectBox(){
		if(is_null($this->resultSelectBox))
			$this->setSelectBox();
		return $this->resultSelectBox;
	}
	public function getListCategory($numSap = 1, $sap = '-'){
		$result = array();
		if(is_null($this->walk)){
			$this->genTree();
		}
		if(!is_null($this->walk)){
	        foreach ($this->walk as $key => $value) {
	            $name = str_repeat($sap, $value->depth * $numSap) . $value->getTermId()->getName();
	            $value->getTermId()->setName($name);
	            array_push($result, $value);
	        }
		}
		return $result;
	}
}
?>