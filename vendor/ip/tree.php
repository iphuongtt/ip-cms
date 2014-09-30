<?php
/*
* @copyright: iphuong
*/
namespace ip;
class tree{
	private $stack = array();
	private $walk = array();
	public function pushNode($node){
		$this->stack[$node->getId()] = $node;
		return $this;
	}
	public function createNode($value, $id = null){
		$node = new node($value, $id);
		return $node;
	}
	public function getNode($nodeId){
		return $this->stack[$nodeId];
	}
	public function popNode(){
		return array_pop($this->stack);
	}
	public function emptyStack(){
		$this->stack = array();
		return $this;
	}
	public function getStack(){
		return $this->stack;
	}
	public function setNodeLeft($nodeId, $nodeLeft){
		$this->stack[$nodeId]->setLeft($nodeLeft);
		return $this;
	}
	public function setNodeRight($nodeId, $nodeRight){
		$this->stack[$nodeId]->setRight($nodeRight);
		return $this;
	}
	public function walk(){
		if(empty($this->walk))
			$this->visit(current($this->stack));
		return $this->walk;
	}
	public function visit($node){
		if(is_null($node))
			return;
		$node->getValue()->depth = $node->getDepth();
		array_push($this->walk, $node->getValue());
		$this->visit($node->getLeft());
		$this->visit($node->getRight());
	}
}
class node{
	private $left;
	private $right;
	private $value;
	private $id;
	private $depth;
	public function __construct($value, $id = null){
		$this->value = $value;
		$this->id = $id;
		$this->depth = 0;
	}
	public function hasLeft(){
		return !is_null($this->left);
	}
	public function hasRight(){
		return !is_null($this->right);
	}
	public function setLeft($nodeLeft){
		$depth = $this->depth + 1;
		$nodeLeft->setDepth($depth);
		$this->left = $nodeLeft;
		return $this;
	}
	public function setRight($nodeRight){
		$nodeRight->setDepth($this->depth);
		$this->right = $nodeRight;
		return $this;
	}
	public function getLeft(){
		return $this->left;
	}
	public function getRight(){
		return $this->right;
	}
	public function setValue($value){
		$this->value = $value;
		return $this;
	}
	public function getValue(){
		return $this->value;
	}
	public function setId($id){
		$this->id = $id;
		return $this;
	}
	public function getId(){
		return $this->id;
	}
	public function getDepth(){
		return $this->depth;
	}
	public function setDepth($depth){
		$this->depth = $depth;
		return $this;
	}
}