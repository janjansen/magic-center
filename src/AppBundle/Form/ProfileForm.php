<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/14/16
 * Time: 10:37 AM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileForm extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bday')
            ->add('bmonth')
            ->add('byear')
            ->add('fname')
            ->add('lname')
            ->add('mname')
            ->add('phone')
            ->add('city')
        ;
    }


    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'csrf_protection' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'profile';
    }
}