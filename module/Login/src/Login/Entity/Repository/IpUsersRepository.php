<?php
namespace Login\Entity\Repository;
use Doctrine\ORM\EntityRepository;

class IpUsersRepository extends EntityRepository{
	public function test(){
		return array('message'=>'this is a test');
	}
}