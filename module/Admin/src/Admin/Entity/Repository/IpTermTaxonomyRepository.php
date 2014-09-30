<?php
namespace Admin\Entity\Repository;
use Doctrine\ORM\EntityRepository;
class IpTermTaxonomyRepository extends EntityRepository{
	public function hasChildrent($id){
		$dql = "SELECT a FROM Admin\Entity\IpTermTaxonomy a JOIN a.parent b Where a.taxonomy = 'category' And b.termId = ?1";
        $result = $this->getEntityManager()->createQuery($dql)
                             ->setParameter(1, $id)
                             ->setMaxResults(10)
                             ->getResult();
        if(empty($result))
        	return false;
       	else
       		return true;
	}
}