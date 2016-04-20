<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/16
 * Time: 12:50 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LessonRepository")
 * @ORM\Table(name="lesson")
 * @ORM\HasLifecycleCallbacks()
 */
class Lesson
{
    const SERVER_PATH_TO_IMAGE_FOLDER = '/home/roman/www/magic/web/video/lessons/';
    const WEB_PATH_TO_IMAGE_FOLDER = '/video/lessons/';

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
     * @ORM\Column(type="decimal", precision=8, scale=2)
     *
     * @var float
     */
    protected $cost;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserLesson", mappedBy="lesson")
     */
    protected $userLessons;

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
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
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

        $name = md5(uniqid()) . md5(microtime())  . '.' . $this->getFile()->getClientOriginalExtension();

        $this->getFile()->move(
            self::SERVER_PATH_TO_IMAGE_FOLDER,
            $name
        );


        $this->filename = $name;

        $this->setFile(null);
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userLessons = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add userLesson
     *
     * @param \AppBundle\Entity\UserLesson $userLesson
     *
     * @return Lesson
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
     * Set cost
     *
     * @param string $cost
     *
     * @return Lesson
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
}
