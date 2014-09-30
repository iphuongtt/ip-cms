<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpTerms
 *
 * @ORM\Table(name="ip_terms", uniqueConstraints={@ORM\UniqueConstraint(name="slug", columns={"slug"})}, indexes={@ORM\Index(name="name", columns={"name"})})
 * @ORM\Entity(repositoryClass="Admin\Entity\Repository\IpTermsRepository")
 */
class IpTerms
{
    /**
     * @var integer
     *
     * @ORM\Column(name="term_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $termId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=200, nullable=false)
     */
    private $slug = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="term_group", type="bigint", nullable=false)
     */
    private $termGroup = '0';

    public function getTermId(){
        return $this->termId;
    }
    public function setTermId($termId){
        $this->termId = $termId;
        return $this;
    }

    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function getSlug(){
        return $this->slug;
    }
    public function setSlug($slug){
        $this->slug = $slug;
        return $this;
    }
}
