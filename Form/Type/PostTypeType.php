<?php

namespace Outlandish\OowpSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Outlandish\OowpBundle\Manager\PostManager;

/**
 * Class PostTypeType
 * @package Outlandish\OowpSearchBundle\Form\Type
 */
class PostTypeType extends AbstractType
{

    /**
     * @var PostManager
     */
    private $postManager;

    /**
     * @param PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $defaultPosts = $this->postManager->postTypeMapping();
        array_walk($defaultPosts, function(&$class, $name){
            $class = $class::friendlyName();
        });
        $resolver->setDefaults(array(
            'choices' => $defaultPosts,
            'multiple' => false,
            'expanded' => true,
            'required' => false,
            'empty_data' => 'all',
            'empty_value' => 'All'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'post_type';
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }


}