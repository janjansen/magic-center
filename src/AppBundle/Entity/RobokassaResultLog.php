<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/19/16
 * Time: 3:04 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="robokassa_result_log")
 */
class RobokassaResultLog
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $params;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $failComment;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
     * Set params
     *
     * @param string $params
     *
     * @return RobokassaResultLog
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Get params
     *
     * @return string
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return RobokassaResultLog
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set failComment
     *
     * @param string $failComment
     *
     * @return RobokassaResultLog
     */
    public function setFailComment($failComment)
    {
        $this->failComment = $failComment;

        return $this;
    }

    /**
     * Get failComment
     *
     * @return string
     */
    public function getFailComment()
    {
        return $this->failComment;
    }
}
