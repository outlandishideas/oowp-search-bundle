<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 18/01/2015
 * Time: 22:45
 */

namespace Outlandish\FacetedBundle\Form\Type;


use Outlandish\OowpBundle\Manager\PostManager;
use Outlandish\RoutemasterBundle\Manager\QueryManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;

abstract class WPQueryType extends AbstractType {

    /**
     * @var PostManager
     */
    protected $postManager;

    /**
     * @var QueryManager
     */
    protected $queryManager;

    public function __construct(PostManager $postManager, QueryManager $queryManager)
    {
        $this->postManager = $postManager;
        $this->queryManager = $queryManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) { $this->handlePostToPostTypes($event); });
    }

    protected function handlePostToPostTypes(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $connectedItems = array();
        $connectedTypes = array();

        /** @var Form $child */
        foreach($form->all() as $child){
            //skip non PostToPostType fields
            if(!$child->getConfig()->getType()->getInnerType() instanceof PostToPostType) continue;

            //if we have no items, ignore this field
            //if $items is not array turn it into one
            //items should be an array of Posts
            $items = $child->getNormData();
            if(empty($items)) continue;
            if(!is_array($items)) $items = array($items);

            //add the ids of each of the connected post items to the $connectedItems array
            $connectedItems = array_merge($connectedItems, array_map(function($item){ return $item->ID; },$items));

            $childPostType = $child->getConfig()->getOption('post_type');

            //foreach of the post types that we will be searching for, create a connectedType string
            foreach($data['post_type'] as $postType){
                $types = array($postType, $childPostType);
                sort($types);
                $connectedTypes[] = implode('_', $types);
            }

            array_unique($connectedTypes);
        }

        if(!empty($connectedTypes) && !empty($connectedTypes)){
            $event->setData(array_merge($data, array(
                'connection_type' => $connectedTypes,
                'connection_items' => $connectedItems
            )));
        }
    }

}