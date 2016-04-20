<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/16
 * Time: 2:19 PM
 */

namespace AppBundle\Repository;

use AppBundle\Entity\UserLesson;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class LessonRepository
 * @package AppBundle\Repository
 */
class LessonRepository extends EntityRepository
{
    public function findByUserIdAndLessonId($uid, $lid)
    {
        $q = <<<RAW_SQL
            SELECT l.id
            FROM lesson l
            INNER JOIN user_lesson ul ON ul.lesson_id = l.id
            WHERE
                ul.user_id = :uid
                AND l.id = :lid
                AND ul.status = :paid
RAW_SQL;

        $stmt = $this->getEntityManager()->getConnection()->prepare($q);
        $stmt->bindValue('uid', $uid);
        $stmt->bindValue('lid', $lid);
        $stmt->bindValue('paid', UserLesson::STATUS_PAID);
        $stmt->execute();
        $row = $stmt->fetch();
        if (empty($row)) {
            throw new NotFoundHttpException;
        }

        return $this->find($row['id']);
    }
}