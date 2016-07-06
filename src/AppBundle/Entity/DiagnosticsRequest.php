<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity()
 * @ORM\Table(name="diagnostics_request")
 * @ORM\HasLifecycleCallbacks()
 */
class DiagnosticsRequest
{
    const STATUS_CREATED = 'CREATED';
    const STATUS_PAID = 'PAID';

    const SERVER_PATH_TO_IMAGE_FOLDER = '/home/bh59203/public_html/rs2/web/images/diagnostics_request/';
    const WEB_PATH_TO_IMAGE_FOLDER = '/images/diagnostics_request/';

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
     * @ORM\Column(type="text")
     */
    protected $answer1;

    /**
     * @ORM\Column(type="text")
     */
    protected $answer2;

    /**
     * @ORM\Column(type="text")
     */
    protected $answer3;

    /**
     * @ORM\Column(type="text")
     */
    protected $answer4;

    /**
     * @ORM\Column(type="text")
     */
    protected $answer5;

    /**
     * @ORM\Column(type="text")
     */
    protected $answer6;

    /**
     * @ORM\Column(type="text")
     */
    protected $answer7;

    /**
     * @ORM\Column(type="text")
     */
    protected $answer8;

    /**
     * @ORM\Column(type="string")
     */
    protected $status;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        if (null === $file) {
            return;
        }

        $name = md5(uniqid()) . md5(microtime())  . '.' . $file->getClientOriginalExtension();

        $file->move(
            self::SERVER_PATH_TO_IMAGE_FOLDER,
            $name
        );


        $this->filename = $name;

//        $this->setFile(null);

//        $this->file = $file;
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
        return $this->getId().'';
    }

    public static function getStatusesForAdminView()
    {
        return [
            self::STATUS_CREATED => 'Создана',
            self::STATUS_PAID => 'Оплачена',
        ];
    }

    public function getStatusRusName()
    {
        return self::getStatusesForAdminView()[$this->getStatus()];
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
     * @return DiagnosticsRequest
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
     * Set answer1
     *
     * @param string $answer1
     *
     * @return DiagnosticsRequest
     */
    public function setAnswer1($answer1)
    {
        $this->answer1 = $answer1;

        return $this;
    }

    /**
     * Get answer1
     *
     * @return string
     */
    public function getAnswer1()
    {
        return $this->answer1;
    }

    /**
     * Set answer2
     *
     * @param string $answer2
     *
     * @return DiagnosticsRequest
     */
    public function setAnswer2($answer2)
    {
        $this->answer2 = $answer2;

        return $this;
    }

    /**
     * Get answer2
     *
     * @return string
     */
    public function getAnswer2()
    {
        return $this->answer2;
    }

    /**
     * Set answer3
     *
     * @param string $answer3
     *
     * @return DiagnosticsRequest
     */
    public function setAnswer3($answer3)
    {
        $this->answer3 = $answer3;

        return $this;
    }

    /**
     * Get answer3
     *
     * @return string
     */
    public function getAnswer3()
    {
        return $this->answer3;
    }

    /**
     * Set answer4
     *
     * @param string $answer4
     *
     * @return DiagnosticsRequest
     */
    public function setAnswer4($answer4)
    {
        $this->answer4 = $answer4;

        return $this;
    }

    /**
     * Get answer4
     *
     * @return string
     */
    public function getAnswer4()
    {
        return $this->answer4;
    }

    /**
     * Set answer5
     *
     * @param string $answer5
     *
     * @return DiagnosticsRequest
     */
    public function setAnswer5($answer5)
    {
        $this->answer5 = $answer5;

        return $this;
    }

    /**
     * Get answer5
     *
     * @return string
     */
    public function getAnswer5()
    {
        return $this->answer5;
    }

    /**
     * Set answer6
     *
     * @param string $answer6
     *
     * @return DiagnosticsRequest
     */
    public function setAnswer6($answer6)
    {
        $this->answer6 = $answer6;

        return $this;
    }

    /**
     * Get answer6
     *
     * @return string
     */
    public function getAnswer6()
    {
        return $this->answer6;
    }

    /**
     * Set answer7
     *
     * @param string $answer7
     *
     * @return DiagnosticsRequest
     */
    public function setAnswer7($answer7)
    {
        $this->answer7 = $answer7;

        return $this;
    }

    /**
     * Get answer7
     *
     * @return string
     */
    public function getAnswer7()
    {
        return $this->answer7;
    }

    /**
     * Set answer8
     *
     * @param string $answer8
     *
     * @return DiagnosticsRequest
     */
    public function setAnswer8($answer8)
    {
        $this->answer8 = $answer8;

        return $this;
    }

    /**
     * Get answer8
     *
     * @return string
     */
    public function getAnswer8()
    {
        return $this->answer8;
    }

/**
 * Set status
 *
 * @param string $status
 *
 * @return DiagnosticsRequest
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
