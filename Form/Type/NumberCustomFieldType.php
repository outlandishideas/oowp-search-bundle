<?php

namespace Outlandish\OowpSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class NumberCustomFieldType
 * @package Outlandish\OowpSearchBundle\Form\Type
 */
class NumberCustomFieldType extends AbstractCustomFieldType
{

    protected $type = 'NUMERIC';

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'number_custom_field';
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'number';
    }


}