<?php
/**
 * Created by PhpStorm.
 * User: ROSomkin
 * Date: 15.06.2016
 * Time: 13:17
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class EmailController extends Controller
{

    /**
     * @Route("/email/fromShop")
     * @param Request $r
     * @return RedirectResponse
     */
    public function fromShopAction(Request $r)
    {
//        Nikol.shop@bk.ru
        $data = [
            ['key' => 'Имя', 'value' => $r->get('name')],
            ['key' => 'Email', 'value' => $r->get('email')],
            ['key' => 'Сообщение', 'value' => $r->get('msg')],
        ];

        $body = $this->renderView(":parts:default_email.html.twig", ['data' => $data]);
        $this->sendEmail('Nikol.shop@bk.ru', 'Запрос с сайта nikol-magic-school.ru', $body);

        $this->get('session')->getFlashBag()->set('success', 'Ваша заявка принята');
        return new RedirectResponse('/shop');
    }

    /**
     * @Route("/email/fromContacts")
     * @param Request $r
     * @return RedirectResponse
     */
    public function fromContactsAction(Request $r)
    {
        $data = [
            ['key' => 'Имя', 'value' => $r->get('name')],
            ['key' => 'Email', 'value' => $r->get('email')],
            ['key' => 'Сообщение', 'value' => $r->get('msg')],
        ];

        $body = $this->renderView(":parts:default_email.html.twig", ['data' => $data]);
        $this->sendEmail('Nikol.shop@bk.ru', 'Запрос с сайта nikol-magic-school.ru', $body);
        
        $this->get('session')->getFlashBag()->set('success', 'Ваша заявка принята');
        return new RedirectResponse('/contacts');
    }

    /**
     * @Route("/email/fromAppointment")
     * @param Request $r
     * @return RedirectResponse
     */
    public function fromAppointmentAction(Request $r)
    {
//        4991363551@mail.ru
        $data = [
            ['key' => 'Имя', 'value' => $r->get('name')],
            ['key' => 'Email', 'value' => $r->get('email')],
            ['key' => 'Телефон', 'value' => $r->get('phone')],
            ['key' => 'Вид приема', 'value' => $r->get('types')],
            ['key' => 'Город', 'value' => $r->get('city')],
        ];

        $body = $this->renderView(":parts:default_email.html.twig", ['data' => $data]);
        $this->sendEmail('4991363551@mail.ru', 'Запрос с сайта nikol-magic-school.ru', $body);

        $this->get('session')->getFlashBag()->set('success', 'Ваша заявка принята');
        return new RedirectResponse('/appointment');
    }

    /**
     * @Route("/email/fromMain")
     * @param Request $r
     * @return RedirectResponse
     */
    public function fromMainAction(Request $r)
    {
//        info@nikol-magic-school.ru
        $data = [
            ['key' => 'Имя', 'value' => $r->get('name')],
            ['key' => 'Email', 'value' => $r->get('email')],
            ['key' => 'Сообщение', 'value' => $r->get('msg')],
        ];

        $body = $this->renderView(":parts:default_email.html.twig", ['data' => $data]);
        $this->sendEmail('info@nikol-magic-school.ru', 'Запрос с сайта nikol-magic-school.ru', $body);

        $this->get('session')->getFlashBag()->set('success', 'Ваша заявка принята');
        return new RedirectResponse('/');
    }

    protected function sendEmail($to, $subject, $body)
    {
        $message = new \Swift_Message();
        $message->setFrom('robot@nikol-magic-school.ru');
        $message->setTo($to);
        $message->setSubject($subject);
        $message->setBody($body,'text/html');

        $this->get('mailer')->send($message);
    }
}