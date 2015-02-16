<?php

namespace Outlandish\OowpSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AbstractCustomFieldType
 * @package Outlandish\OowpSearchBundle\Form\Type
 */
abstract class AbstractCustomFieldType extends AbstractType
{

    protected $type = 'CHAR';
    protected $compare = "=";

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'meta_key'
        ));

        $resolver->setDefaults(array(
            'mapped' => false,
            'compare' => $this->compare,
            'type' => $this->type
        ));
    }

}