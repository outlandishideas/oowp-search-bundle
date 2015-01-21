<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 17/01/2015
 * Time: 19:53
 */

namespace Outlandish\OowpSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Outlandish\OowpBundle\Manager\PostManager;
use Outlandish\FacetedBundle\Form\DataTransformer\ConnectedItemsToPostsTransformer;

class PostToPostType extends AbstractType {

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

        $resolver->setRequired(array('post_type'));
        $resolver->setDefaults(array('mapped' => false));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ConnectedItemsToPostsTransformer($this->postManager, $options['post_type']);
        $builder->addModelTransformer($transformer);


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

    public function getParent()
    {
        return 'choice';
    }


}