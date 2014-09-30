<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\Form\Annotation;

/**
 * IpUsers
 *
 * @ORM\Table(name="ip_users", indexes={@ORM\Index(name="user_login_key", columns={"user_login"}), @ORM\Index(name="user_nicename", columns={"user_nicename"})})
 * @ORM\Entity(repositoryClass="Admin\Entity\Repository\IpUsersRepository")
 * @Annotation\Name("IpUser")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */

class IpUsers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Id:"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_login", type="string", length=60, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Tên đăng nhập:"})
     */
    private $userLogin = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_pass", type="string", length=64, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Mật khẩu:"})
     */
    private $userPass = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_nicename", type="string", length=50, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Tên đầy đủ:"})
     */
    private $userNicename = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=100, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Địa chỉ Email:"})
     */
    private $userEmail = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_url", type="string", length=100, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Url:"})
     */
    private $userUrl = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="user_registered", type="datetime", nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Đăng ký:"})
     */
    private $userRegistered = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="user_activation_key", type="string", length=60, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Tên đăng nhập:"})
     */
    private $userActivationKey = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_status", type="integer", nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Tên đăng nhập:"})
     */
    private $userStatus = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="display_name", type="string", length=250, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Tên hiển thị:"})
     */
    private $displayName = '';

    public function __construct()
    {
        $this->userRegistered = new \DateTime();
    }

    public function getUserLogin(){
        return $this->userLogin;
    }
    public function setUserLogin($userLogin){
        $this->userLogin = $userLogin;
        return $this;
    }

    public function getUserPass(){
        return $this->userPass;
    }
    public function setUserPass($userPass){
        $this->userPass = $userPass;
        return $this;
    }

    public function getUserNicename(){
        return $this->userNicename;
    }
    public function setUserNicename($userNicename){
        $this->userNicename = $userNicename;
        return $this;
    }

    public function getUserEmail(){
        return $this->userEmail;
    }
    public function setUserEmail($userEmail){
        $this->userEmail = $userEmail;
        return $this;
    }

    public function getUserUrl(){
        return $this->userUrl;
    }
    public function setUserUrl($userUrl){
        $this->userUrl = $userUrl;
        return $this;
    }

    public function getUserRegistered(){
        return $this->userRegistered;
    }
    public function setUserRegistered($userRegistered){
        $this->userRegistered = $userRegistered;
        return $this;
    }

    public function getUserActivationKey(){
        return $this->userActivationKey;
    }
    public function setUserActivationKey($userActivationKey){
        $this->userActivationKey = $userActivationKey;
        return $this;
    }

    public function getUserStatus(){
        return $this->userStatus;
    }
    public function setUserStatus($userStatus){
        $this->userStatus = $userStatus;
        return $this;
    }

    public function getDisplayName(){
        return $this->displayName;
    }
    public function setDisplayName($displayName){
        $this->displayName = $displayName;
        return $this;
    }
}
