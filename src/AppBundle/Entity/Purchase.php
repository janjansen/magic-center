<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/11/16
 * Time: 4:50 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="purchase")
 */
class Purchase
{

    const STATUS_PLACED = 'PLACED';
    const STATUS_DELIVERY_APPOINTED = 'DELIVERY_APPOINTED';
    const STATUS_DELIVERED = 'DELIVERED';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PurchaseProduct", mappedBy="purchase", cascade={"persist", "remove"})
     */
    protected $purchaseProducts;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="purchases")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    protected $user;

    /**
     * @ORM\Column(type="string")
     */
    protected $phone;

    /**
     * @ORM\Column(type="text")
     */
    protected $address;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deliveryAt;

    /**
     * @ORM\Column(type="string")
     */
    protected $status;

    public static function getStatusesForAdminView()
    {
        return [
            self::STATUS_PLACED => self::STATUS_PLACED,
            self::STATUS_DELIVERY_APPOINTED => self::STATUS_DELIVERY_APPOINTED,
            self::STATUS_DELIVERED => self::STATUS_DELIVERED,
        ];
    }

    public function __toString()
    {
        return (string)$this->getId();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->purchaseProducts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add purchaseProduct
     *
     * @param \AppBundle\Entity\PurchaseProduct $purchaseProduct
     *
     * @return Purchase
     */
    public function addPurchaseProduct(\AppBundle\Entity\PurchaseProduct $purchaseProduct)
    {
        $this->purchaseProducts[] = $purchaseProduct;

        return $this;
    }

    /**
     * Remove purchaseProduct
     *
     * @param \AppBundle\Entity\PurchaseProduct $purchaseProduct
     */
    public function removePurchaseProduct(\AppBundle\Entity\PurchaseProduct $purchaseProduct)
    {
        $this->purchaseProducts->removeElement($purchaseProduct);
    }

    /**
     * Get purchaseProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchaseProducts()
    {
        return $this->purchaseProducts;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Purchase
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Purchase
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getAmount()
    {
        $sum = 0;
        foreach($this->getPurchaseProducts() as $pp) {
            $sum = $sum + $pp->getCost();
        }
        return $sum;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Purchase
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
     * Set address
     *
     * @param string $address
     *
     * @return Purchase
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set deliveryAt
     *
     * @param \DateTime $deliveryAt
     *
     * @return Purchase
     */
    public function setDeliveryAt($deliveryAt)
    {
        $this->deliveryAt = $deliveryAt;

        return $this;
    }

    /**
     * Get deliveryAt
     *
     * @return \DateTime
     */
    public function getDeliveryAt()
    {
        return $this->deliveryAt;
    }
    
    public function getTotalAmount()
    {
        $amount = 0;
        foreach ($this->getPurchaseProducts() as $pp) {
            $amount += $pp->getCost();
        }
        
        return $amount;
    }
}
