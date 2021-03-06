<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/11/16
 * Time: 4:39 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_image")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductImage
{
    const SERVER_PATH_TO_IMAGE_FOLDER = '/home/bh59203/public_html/rs2/web/images/products/';
    const WEB_PATH_TO_IMAGE_FOLDER = '/images/products/';

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
    protected $filename;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="images")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $isHidden;

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

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return ProductImage
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
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
//        if (!is_null($file)) {
            $this->setFilename('');
//        }

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

    public function __toString()
    {
        return $this->getFilename();
    }

    /**
     * Set isHidden
     *
     * @param integer $isHidden
     *
     * @return ProductImage
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
}
