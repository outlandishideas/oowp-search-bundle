<?php

namespace Outlandish\OowpSearchBundle\Form\Type;

use Outlandish\OowpBundle\Manager\PostManager;
use Outlandish\OowpSearchBundle\Form\EventSubscriber\WPFormEventSubscriber;
use Outlandish\RoutemasterBundle\Manager\QueryManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;
use Symfony\Component\Form\Extension\Core\View\ChoiceView;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

/**
 * Class WPQueryType
 * @package Outlandish\OowpSearchBundle\Form\Type
 */
abstract class WPQueryType extends AbstractType
{

    /**
     * @var PostManager
     */
    protected $postManager;

    /**
     * @var QueryManager
     */
    protected $queryManager;

    /**
     * @param PostManager  $postManager
     * @param QueryManager $queryManager
     */
    public function __construct(PostManager $postManager, QueryManager $queryManager)
    {
        $this->postManager = $postManager;
        $this->queryManager = $queryManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder
//            ->add('order', 'order')
//            ->add('order_by', 'order_by')
//            ->add('post_type', 'post_type')
//            ->add('blog', 'post_to_post', array(
//                'post_type' => 'blog',
//                'required'    => false,
//                'choice_list' => new ObjectChoiceList($this->queryManager->query(array('post_type' => 'blog'))->posts, 'post_title')
//            ))
//            ->add('number', 'number_custom_field', array('meta_key' => 'number'))
//            ->add('save', 'submit');

        $builder->addEventSubscriber(new WPFormEventSubscriber());
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wp_query';
    }


}