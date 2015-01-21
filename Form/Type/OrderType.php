<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 17/01/2015
 * Time: 19:53
 */

namespace Outlandish\FacetedBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType {


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'mapped' => false,
            'choices' => array(
                'DESC' => 'Descending',
                'ASC' => 'Ascending',
            )
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'order';
    }

    public function getParent()
    {
        return 'choice';
    }

}