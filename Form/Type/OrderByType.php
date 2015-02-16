<?php

namespace Outlandish\OowpSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class OrderByType
 * @package Outlandish\OowpSearchBundle\Form\Type
 */
class OrderByType extends AbstractType
{

    /**
     * An array of a protected values for WP_Query
     *
     * If the chosen value does not appear here, it is assumed to be a metakey
     *
     * @var array
     */
    protected static $protectedValues = array(
        'none',
        'ID',
        'author',
        'title',
        'name',
        'type',
        'date',
        'modified',
        'parent',
        'rand',
        'comment_count',
        'menu_order',
        'post__in'
    );

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'mapped' => false,
            'choices' => array(
                'title' => 'Title',
                'date' => 'Date',
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
        return 'order_by';
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * @return array
     */
    public static function getProtectedValues()
    {
        return static::$protectedValues;
    }


}