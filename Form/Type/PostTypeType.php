<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 17/01/2015
 * Time: 19:53
 */

namespace Outlandish\OowpSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Outlandish\OowpBundle\Manager\PostManager;

class PostTypeType extends AbstractType {

    /**
     * @var PostManager
     */
    private $postManager;

    /**
     * @param PostManager $postManager
     */
    function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $defaultPosts = $this->postManager->postTypeMapping();
        array_walk($defaultPosts, function(&$class, $name){
            $class = $class::friendlyName();
        });
        $resolver->setDefaults(array(
            'choices' => $defaultPosts,
            'multiple' => true
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

    public function getParent()
    {
        return 'choice';
    }


}