<?php
namespace Admin\Entity\Repository;
use Doctrine\ORM\EntityRepository;
class IpTermsRepository extends EntityRepository{
	public function getEdit($id){
		$dql = "SELECT a, b FROM Admin\Entity\IpTermTaxonomy a JOIN a.termId b Where a.taxonomy = 'category' And a.termId = ?1";
        $result = $this->getEntityManager()->createQuery($dql)
                             ->setParameter(1, $id)
//                             ->setMaxResults($number)
                             ->getResult();
							 // ->getScalarResult();
							 // ->getArrayResult();
		return $result[0];
	}
}