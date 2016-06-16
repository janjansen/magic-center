<?php
/**
 * Created by PhpStorm.
 * User: ROSomkin
 * Date: 17.06.2016
 * Time: 11:58
 */

namespace AppBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class AppExtension extends \Twig_Extension
{
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getPhones',[$this, 'getPhones']),
        );
    }

    public function getPhones()
    {
        return $this->container
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:Content')
            ->findOneBy(['key' => 'CONTACT_PHONES'])
            ->getContent();
    }

    public function getName()
    {
        return 'app_extension';
    }
}