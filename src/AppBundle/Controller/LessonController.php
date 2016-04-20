<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/16
 * Time: 1:48 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LessonController extends Controller
{

    /**
     * @Route("/lessons")
     */
    public function allLessonsListAction()
    {
        $lessons = $this->getDoctrine()->getRepository('AppBundle:Lesson')->findBy(['isHidden' => 0]);
        return $this->render('lesson/all_lessons.html.twig', ['lessons' => $lessons]);
    }

}