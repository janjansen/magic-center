<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/20/16
 * Time: 2:55 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity()
 * @ORM\Table(name="employee")
 * @ORM\HasLifecycleCallbacks()
 */
class Employee
{
    const SERVER_PATH_TO_IMAGE_FOLDER = '/home/bh59203/public_html/rs2/web/images/employees';
    const WEB_PATH_TO_IMAGE_FOLDER = '/images/employees/';

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
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $isHidden;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Lesson", inversedBy="masters")
     * @ORM\JoinTable(name="master_lesson")
     */
    private $lessons;

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
     * @return Employee
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
     * Set name
     *
     * @param string $name
     *
     * @return Employee
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
     * @return Employee
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
     * Set isHidden
     *
     * @param integer $isHidden
     *
     * @return Employee
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
        $this->setFilename('');
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
     * Constructor
     */
    public function __construct()
    {
        $this->lessons = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lesson
     *
     * @param \AppBundle\Entity\Lesson $lesson
     *
     * @return Employee
     */
    public function addLesson(\AppBundle\Entity\Lesson $lesson)
    {
        $this->lessons[] = $lesson;

        return $this;
    }

    /**
     * Remove lesson
     *
     * @param \AppBundle\Entity\Lesson $lesson
     */
    public function removeLesson(\AppBundle\Entity\Lesson $lesson)
    {
        $this->lessons->removeElement($lesson);
    }

    /**
     * Get lessons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLessons()
    {
        return $this->lessons;
    }
}
