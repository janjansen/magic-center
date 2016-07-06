<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/16
 * Time: 1:48 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Lesson;
use AppBundle\Entity\LessonRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class LessonController extends Controller
{

    /**
     * @Route("/courses")
     */
    public function allLessonsListAction()
    {
        $lessons = $this->getDoctrine()->getRepository('AppBundle:Lesson')->findBy(['isHidden' => 0]);

        return $this->render('lesson/all_lessons.html.twig', ['lessons' => $lessons]);
    }

    /**
     * @Route("/initialisation/lesson/{id}")
     */
    public function requestAction($id)
    {
        $lesson = $this->getDoctrine()->getRepository('AppBundle:Lesson')->find($id);
        $content = $this->getDoctrine()->getRepository('AppBundle:Content')->findOneBy(['key' => 'INITIALIZATION_PAGE']);
        if (!$lesson) {
            throw new HttpException(404);
        }
        return $this->render('lesson/request.html.twig', ['lesson' => $lesson,'content' => $content]);
    }

    /**
     * @Route("/lessonRequest/create")
     * @param Request $request
     * @return RedirectResponse
     */
    public function createRequestAction(Request $request)
    {
        $data = $this->getLessonRequestData($request->get('r'));

        $lesson = $this->getDoctrine()->getRepository('AppBundle:Lesson')->find($request->get('lid'));
        if (!$lesson) {
            throw new HttpException(404);
        }

        if ($data == false) {
            return new RedirectResponse('/initialisation/lesson/'. $request->get('lid'));
        }
        
        $file = $request->files->get('photo');

        if (!$file) {
            $this->get('session')->getFlashBag()->set('lesson_request_error', 'Не загружена фотография');
            return new RedirectResponse('/initialisation/lesson/'.$request->get('lid'));
        }

        /**
         * @var $file UploadedFile
         */

        if (!in_array($file->getMimeType(), ['jpg' => 'image/jpeg','png' => 'image/png','gif' => 'image/gif',])) {
            $this->get('session')->getFlashBag()->set('lesson_request_error', 'Не корректный файл');
            return new RedirectResponse('/initialisation/lesson/'. $request->get('lid'));
        }

        $r = $this->createLessonRequest($data, $lesson, $file);

        return $this->render('lesson/go_to_payment.html.twig', [
            'r' => $r,
            'ya_scid' => $this->container->getParameter('ya_scid'),
            'ya_shop_id'  => $this->container->getParameter('ya_shop_id'),
        ]);
    }

    protected function createLessonRequest(array $data, Lesson $lesson, UploadedFile $file)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $r = new LessonRequest();
        $r->setCity($data['city']);
        $r->setEmail($data['email']);
        $r->setName($data['name']);
        $r->setPhone($data['phone']);
        $r->setFile($file);
        $r->setStatus(LessonRequest::STATUS_CREATED);
        $r->setLesson($lesson);

        $em->persist($r);
        $em->flush();

        return $r;
    }

    protected function getLessonRequestData($data)
    {
        $flashes = $this->get('session')->getFlashBag();
        $v = $this->get('validator');

        if (count($v->validate(@$data['phone'], [new Assert\NotBlank(), new Assert\NotNull(), new Assert\Length(['min' => 10, 'max' => 15])]))) {
            $flashes->set('lesson_request_error', "Некорректный номер телефона");
            return false;
        }

        if (count($v->validate(@$data['city'], [new Assert\NotBlank(), new Assert\NotNull(), new Assert\Length(['min' => 1, 'max' => 255])]))) {
            $flashes->set('lesson_request_error', "Некорректный адресс");
            return false;
        }

        if (count($v->validate(@$data['email'], [new Assert\NotBlank(), new Assert\NotNull(), new Assert\Email(), new Assert\Length(['min' => 1, 'max' => 255])]))) {
            $flashes->set('lesson_request_error', "Некорректный email");
            return false;
        }

        if (count($v->validate(@$data['name'], [new Assert\NotBlank(), new Assert\NotNull(), new Assert\Length(['min' => 1, 'max' => 1000])]))) {
            $flashes->set('lesson_request_error', "Некорректная фамилия");
            return false;
        }

        return $data;
    }

}