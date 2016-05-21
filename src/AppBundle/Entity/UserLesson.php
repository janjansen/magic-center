<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/16
 * Time: 12:56 PM
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_lesson")
 */
class UserLesson
{
    const STATUS_PLACED = 'BOOKED';
    const STATUS_PAID = 'PAID';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userLessons")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lesson", inversedBy="userLessons")
     * @ORM\JoinColumn(name="lesson_id", referencedColumnName="id")
     */
    protected $lesson;

    /**
     * @ORM\Column(type="string")
     */
    protected $status;


    public function getId()
    {
        return $this->id;
    }
    /**
     * Set status
     *
     * @param string $status
     *
     * @return UserLesson
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

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserLesson
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
     * Set lesson
     *
     * @param \AppBundle\Entity\Lesson $lesson
     *
     * @return UserLesson
     */
    public function setLesson(\AppBundle\Entity\Lesson $lesson = null)
    {
        $this->lesson = $lesson;

        return $this;
    }

    /**
     * Get lesson
     *
     * @return \AppBundle\Entity\Lesson
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    public static function getStatusesForAdminView()
    {
        return [
            self::STATUS_PLACED => self::STATUS_PLACED,
            self::STATUS_PAID => self::STATUS_PAID,
        ];
    }
}
