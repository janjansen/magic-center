<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/11/16
 * Time: 3:38 PM
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $scoreAmount;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserLesson", mappedBy="user")
     */
    protected $userLessons;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Purchase", mappedBy="user")
     */
    protected $purchases;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     */
    protected $fname;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     */
    protected $lname;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     */
    protected $mname;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Type(type="numeric")
     * @Assert\LessThan(32)
     * @Assert\GreaterThan(0)
     */
    protected $bday;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Type(type="numeric")
     * @Assert\LessThan(13)
     * @Assert\GreaterThan(0)
     */
    protected $bmonth;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Type(type="numeric")
     * @Assert\LessThan(2020)
     * @Assert\GreaterThan(1900)
     */
    protected $byear;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     */
    protected $phone;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set scoreAmount
     *
     * @param integer $scoreAmount
     *
     * @return User
     */
    public function setScoreAmount($scoreAmount)
    {
        $this->scoreAmount = $scoreAmount;

        return $this;
    }

    /**
     * Get scoreAmount
     *
     * @return integer
     */
    public function getScoreAmount()
    {
        return $this->scoreAmount;
    }

    /**
     * Add userLesson
     *
     * @param \AppBundle\Entity\UserLesson $userLesson
     *
     * @return User
     */
    public function addUserLesson(\AppBundle\Entity\UserLesson $userLesson)
    {
        $this->userLessons[] = $userLesson;

        return $this;
    }

    /**
     * Remove userLesson
     *
     * @param \AppBundle\Entity\UserLesson $userLesson
     */
    public function removeUserLesson(\AppBundle\Entity\UserLesson $userLesson)
    {
        $this->userLessons->removeElement($userLesson);
    }

    /**
     * Get userLessons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserLessons()
    {
        return $this->userLessons;
    }

    /**
     * Add purchase
     *
     * @param \AppBundle\Entity\Purchase $purchase
     *
     * @return User
     */
    public function addPurchase(\AppBundle\Entity\Purchase $purchase)
    {
        $this->purchases[] = $purchase;

        return $this;
    }

    /**
     * Remove purchase
     *
     * @param \AppBundle\Entity\Purchase $purchase
     */
    public function removePurchase(\AppBundle\Entity\Purchase $purchase)
    {
        $this->purchases->removeElement($purchase);
    }

    /**
     * Get purchases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

    /**
     * Set fname
     *
     * @param string $fname
     *
     * @return User
     */
    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * Get fname
     *
     * @return string
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     *
     * @return User
     */
    public function setLname($lname)
    {
        $this->lname = $lname;

        return $this;
    }

    /**
     * Get lname
     *
     * @return string
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set mname
     *
     * @param string $mname
     *
     * @return User
     */
    public function setMname($mname)
    {
        $this->mname = $mname;

        return $this;
    }

    /**
     * Get mname
     *
     * @return string
     */
    public function getMname()
    {
        return $this->mname;
    }

    /**
     * Set bday
     *
     * @param integer $bday
     *
     * @return User
     */
    public function setBday($bday)
    {
        $this->bday = $bday;

        return $this;
    }

    /**
     * Get bday
     *
     * @return integer
     */
    public function getBday()
    {
        return $this->bday;
    }

    /**
     * Set bmonth
     *
     * @param integer $bmonth
     *
     * @return User
     */
    public function setBmonth($bmonth)
    {
        $this->bmonth = $bmonth;

        return $this;
    }

    /**
     * Get bmonth
     *
     * @return integer
     */
    public function getBmonth()
    {
        return $this->bmonth;
    }

    /**
     * Set byear
     *
     * @param integer $byear
     *
     * @return User
     */
    public function setByear($byear)
    {
        $this->byear = $byear;

        return $this;
    }

    /**
     * Get byear
     *
     * @return integer
     */
    public function getByear()
    {
        return $this->byear;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->setUsername($this->getEmail());
        $this->setUsernameCanonical($this->getEmailCanonical());
    }
}
