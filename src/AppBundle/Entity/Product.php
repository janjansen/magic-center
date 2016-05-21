<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/11/16
 * Time: 4:35 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     *
     * @var float
     */
    protected $cost;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PurchaseProduct", mappedBy="product")
     */
    protected $purchaseProducts;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProductImage", mappedBy="product")
     */
    protected $images;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProductCategory", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $isHidden;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $reservedTill;

    public $basketQuantity = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->purchaseProducts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set cost
     *
     * @param string $cost
     *
     * @return Product
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
     * Set isHidden
     *
     * @param integer $isHidden
     *
     * @return Product
     */
    public function setIsHidden($isHidden)
    {
        $this->isHidden = $isHidden;

        return $this;
    }

    /**
     * Get isHidden
     *
     * @return integer
     */
    public function getIsHidden()
    {
        return $this->isHidden;
    }

    /**
     * Add purchaseProduct
     *
     * @param \AppBundle\Entity\PurchaseProduct $purchaseProduct
     *
     * @return Product
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
     * Add image
     *
     * @param \AppBundle\Entity\ProductImage $image
     *
     * @return Product
     */
    public function addImage(\AppBundle\Entity\ProductImage $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\ProductImage $image
     */
    public function removeImage(\AppBundle\Entity\ProductImage $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\ProductCategory $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\ProductCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\ProductCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getMainImageWebPath()
    {
        foreach($this->getImages() as $i) {
            return $i->getWebPath();
        }

        return false;
    }
    

    /**
     * Set reservedTill
     *
     * @param \DateTime $reservedTill
     *
     * @return Product
     */
    public function setReservedTill($reservedTill)
    {
        $this->reservedTill = $reservedTill;

        return $this;
    }

    /**
     * Get reservedTill
     *
     * @return \DateTime
     */
    public function getReservedTill()
    {
        return $this->reservedTill;
    }
}
