<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/16
 * Time: 3:18 PM
 */


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="purchase_product")
 */
class PurchaseProduct
{
    const STATUS_BOOKED = 'BOOKED';
    const STATUS_PAID = 'PAID';
    const STATUS_CANCELED = 'CANCELED';
    const STATUS_DELIVERED = 'DELIVERED';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="purchaseProducts")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Purchase", inversedBy="purchaseProducts")
     * @ORM\JoinColumn(name="purchase_id", referencedColumnName="id")
     */
    protected $purchase;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     *
     * @var float
     */
    protected $cost;

    /**
     * @ORM\Column(type="string")
     */
    protected $status;

    public function __toString()
    {
        return (string)$this->getId();
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
     * Set cost
     *
     * @param string $cost
     *
     * @return PurchaseProduct
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return PurchaseProduct
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set purchase
     *
     * @param \AppBundle\Entity\Purchase $purchase
     *
     * @return PurchaseProduct
     */
    public function setPurchase(\AppBundle\Entity\Purchase $purchase = null)
    {
        $this->purchase = $purchase;

        return $this;
    }

    /**
     * Get purchase
     *
     * @return \AppBundle\Entity\Purchase
     */
    public function getPurchase()
    {
        return $this->purchase;
    }

    public static function getStatusesForAdminView()
    {
        return [
            self::STATUS_BOOKED => self::STATUS_BOOKED,
            self::STATUS_PAID => self::STATUS_PAID,
            self::STATUS_CANCELED => self::STATUS_CANCELED,
            self::STATUS_DELIVERED => self::STATUS_DELIVERED,
        ];
    }


    /**
     * Set status
     *
     * @param string $status
     *
     * @return PurchaseProduct
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
}
