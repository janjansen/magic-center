<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/13/16
 * Time: 11:04 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\ProfileForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CpController extends Controller
{
    /**
     * @Route("/my/profile")
     */
    public function myProfileAction()
    {
        return $this->render('my/profile.html.twig');
    }

    /**
     * @Route("/my/profile/edit")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myProfileEditAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(ProfileForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->get('doctrine.orm.default_entity_manager');
            $em->persist($user);
            $em->flush();
            $this->get('session')->getFlashBag()->set('profile_edit_success', 'Профиль успешно изменен');
            return new RedirectResponse('/my/profile');
        }

        return $this->render('my/profile_edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/my/orders")
     */
    public function myOrdersListAction()
    {
        /**
         * @var $user User
         */
        $user = $this->getUser();
        return $this->render('my/my_orders.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/my/lessons")
     */
    public function myLessonsListAction()
    {
        /**
         * @var $user User
         */
        $user = $this->getUser();
        return $this->render('my/my_lessons.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/my/lessons/{id}")
     */
    public function myLessonsByIdentAction($id)
    {
        /**
         * @var $user User
         */
        $user = $this->getUser();

        $lesson = $this->getDoctrine()->getRepository('AppBundle:Lesson')->findByUserIdAndLessonId($user->getId(), $id);
        if(!$lesson) {
            throw new NotFoundHttpException;
        }
        return $this->render('my/show_lesson.html.twig', ['lesson' => $lesson]);
    }
}