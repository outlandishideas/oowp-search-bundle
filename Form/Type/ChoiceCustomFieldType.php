<?php

namespace Outlandish\OowpSearchBundle\Form\Type;

/**
 * Choice Form Type for creating a meta_query in your Wordpress Query
 *
 * Class ChoiceCustomFieldType
 * @package Outlandish\OowpSearchBundle\Form\Type
 */
class ChoiceCustomFieldType extends AbstractCustomFieldType
{

    protected $type = 'CHAR';

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'choice_custom_field';
    }

    public function getParent()
    {
        return 'choice';
    }


}