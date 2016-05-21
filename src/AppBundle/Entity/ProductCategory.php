<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/16
 * Time: 12:01 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_category")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductCategory
{
    const SERVER_PATH_TO_IMAGE_FOLDER = '/home/bh59203/public_html/rs2/web/images/categories/';
    const WEB_PATH_TO_IMAGE_FOLDER = '/images/categories/';

    /**
     * Unmapped property to handle file uploads
     */
    private $file;

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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Product", mappedBy="category")
     */
    protected $products;

    /**
     * @ORM\Column(type="string")
     */
    protected $filename;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $isHidden;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return ProductCategory
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
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return ProductCategory
     */
    public function addProduct(\AppBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product $product
     */
    public function removeProduct(\AppBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getAvailableProducts()
    {
        $result = [];
        foreach ($this->products as $p) {
            if ($p->getIsHidden()) {
                continue;
            }            
        }

        return $result;
    }


    /**
     * Set isHidden
     *
     * @param integer $isHidden
     *
     * @return ProductCategory
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
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
////        if (!is_null($file)) {
//        $this->setFilename('');
//
//        if (null === $this->getFile()) {
//            return;
//        }

        $name = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(
            self::SERVER_PATH_TO_IMAGE_FOLDER,
            $name
        );

        $this->filename = $name;

        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function upload()
    {
        return false;
        if (null === $this->getFile()) {
            return;
        }

        $name = uniqid() . '.' . $this->getFile()->getClientOriginalExtension();
        $this->getFile()->move(
            self::SERVER_PATH_TO_IMAGE_FOLDER,
            $name
        );

        $this->filename = $name;

//        $this->setFile(null);
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->upload();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->upload();
    }

    public function getWebPath()
    {
        if(!$this->getFilename()) {
            return false;
        }
        return static::WEB_PATH_TO_IMAGE_FOLDER . $this->getFilename();
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return ProductImage
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }
}
