<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpPostmeta
 *
 * @ORM\Table(name="ip_postmeta", indexes={@ORM\Index(name="post_id", columns={"post_id"}), @ORM\Index(name="meta_key", columns={"meta_key"})})
 * @ORM\Entity
 */
class IpPostmeta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="meta_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $metaId;

    /**
     * @var integer
     *
     * @ORM\Column(name="post_id", type="bigint", nullable=false)
     */
    private $postId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="meta_key", type="string", length=255, nullable=true)
     */
    private $metaKey;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_value", type="text", nullable=true)
     */
    private $metaValue;


}
