<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpTermTaxonomy
 *
 * @ORM\Table(name="ip_term_taxonomy", uniqueConstraints={@ORM\UniqueConstraint(name="term_id_taxonomy", columns={"term_id", "taxonomy"})}, indexes={@ORM\Index(name="taxonomy", columns={"taxonomy"})})
 * @ORM\Entity(repositoryClass="Admin\Entity\Repository\IpTermTaxonomyRepository")
 */
class IpTermTaxonomy
{
    /**
     * @var integer
     *
     * @ORM\Column(name="term_taxonomy_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $termTaxonomyId;

    /**
     * @var Admin\Entity\IpTerms
     *
     * @ORM\OneToOne(targetEntity="Admin\Entity\IpTerms", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="term_id", referencedColumnName="term_id")
     */
    private $termId = '0';

    /**
     * @var string
     * @ORM\Column(name="taxonomy", type="string", length=32, nullable=false)
     */
    private $taxonomy = '';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var Admin\Entity\IpTerms
     * @ORM\ManyToOne(targetEntity="Admin\Entity\IpTerms")
     * @ORM\JoinColumn(name="parent", referencedColumnName="term_id")
     */
    private $parent = null;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="bigint", nullable=false)
     */
    private $count = '0';

    public function __construct(){

    }
    public function getTermTaxonomyId(){
        return $this->termTaxonomyId;
    }
    public function setTermTaxonomyId($termTaxonomyId){
        $this->termTaxonomyId = $termTaxonomyId;
        return $this;
    }

    public function getTermId(){
        return $this->termId;
    }
    public function setTermId($termId){
        $this->termId = $termId;
        return $this;
    }

    public function getTaxonomy(){
        return $this->taxonomy;
    }
    public function setTaxonomy($taxonomy){
        $this->taxonomy = $taxonomy;
        return $this;
    }

    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    public function getParent(){
        return $this->parent;
    }
    public function setParent($parent){
        $this->parent = $parent;
        return $this;
    }
}
