<?php

namespace Outlandish\OowpSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class OrderType
 * @package Outlandish\OowpSearchBundle\Form\Type
 */
class OrderType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'mapped' => false,
            'required' => true,
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

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }

}