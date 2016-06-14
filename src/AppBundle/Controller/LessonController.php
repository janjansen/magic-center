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
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LessonController extends Controller
{

    /**
     * @Route("/courses")
     */
    public function allLessonsListAction()
    {
        $lessons = $this->getDoctrine()->getRepository('AppBundle:Lesson')->findBy(['isHidden' => 0]);
        $content = $this->getDoctrine()->getRepository('AppBundle:Content')->findOneBy(['key' => 'COURSE_POPUP']);
        return $this->render('lesson/all_lessons.html.twig', ['lessons' => $lessons, 'content' => $content]);
    }

    /**
     * @Route("/initialisation/lesson/{id}")
     */
    public function requestAction($id)
    {
        $lesson = $this->getDoctrine()->getRepository('AppBundle:Lesson')->find($id);
        if (!$lesson) {
            throw new HttpException(404);
        }
        return $this->render('lesson/request.html.twig', ['lesson' => $lesson]);
    }

}