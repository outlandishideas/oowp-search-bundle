<?php

namespace Outlandish\OowpSearchBundle\Form\Type;

use Outlandish\OowpBundle\Manager\QueryManager;
use Outlandish\OowpBundle\Manager\PostManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PostToPostType
 * @package Outlandish\OowpSearchBundle\Form\Type
 */
class PostToPostType extends AbstractType
{
    /**
     * @var QueryManager
     */
    private $queryManager;

    /**
     * @param QueryManager $queryManager
     */
    public function __construct(QueryManager $queryManager)
    {
        $this->queryManager = $queryManager;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        /**
         * @param Options $options
         * @return ObjectChoiceList
         */
        $choiceList = function(Options $options){
            $args = array(
                'post_type' => $options['post_type'],
                'orderby' => 'title'
            );

            return new ObjectChoiceList($this->$queryManager->query($args)->posts, 'post_title');
        };

        $resolver->setRequired(array('post_type'));
        $resolver->setDefaults(array(
            'mapped' => false,
            'multiple' => true,
            'required' => false,
            'choice_list' => $choiceList
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'post_to_post';
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }


}