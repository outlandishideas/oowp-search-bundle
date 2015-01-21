<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 18/01/2015
 * Time: 22:45
 */

namespace Outlandish\OowpSearchBundle\Form\Type;


use Outlandish\OowpBundle\Manager\PostManager;
use Outlandish\RoutemasterBundle\Manager\QueryManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

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
        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) {
            $this->handlePostToPostTypes($event);
            $this->handleOrderByType($event);
            $this->handleOrderType($event);
        });
    }

    protected function handleOrderType(FormEvent $event)
    {
        /** @var Form[] $fields */
        $fields = array_filter($event->getForm()->all(), function($field){
            return $this->filterFieldsByType($field, 'OrderType');
        });

        foreach($fields as $field){
            $event->setData(array_merge(
                $event->getData(),
                array('order' => $field->getData())
            ));
        }
    }

    protected function handleOrderByType(FormEvent $event)
    {
        /** @var Form[] $fields */
        $fields = array_filter($event->getForm()->all(), function($field){
            return $this->filterFieldsByType($field, 'OrderByType');
        });

        foreach($fields as $field){
            $value = $field->getData();

            //if the fieldData is in the protected values, then set the order_by to the $value
            //else set order_by to meta_value, and meta_key to the $value
            if(in_array($value, OrderByType::getProtectedValues())){
                $event->setData(array_merge(
                    $event->getData(),
                    array('order_by' => $value)
                ));
            } else {
                $event->setData(array_merge(
                    $event->getData(),
                    array(
                        'order_by' => 'meta_value',
                        'meta_key' => $value
                    )
                ));
            }
        }
    }

    /**
     * @param Form $field
     * @param $class
     * @return bool
     */
    protected function filterFieldsByType(Form $field, $class)
    {
        return $field->getConfig()->getType()->getInnerType() instanceof $class;
    }

    protected function handlePostToPostTypes(FormEvent $event)
    {
        $data = $event->getData();

        $connectedItems = array();
        $connectedTypes = array();

        /** @var Form[] $fields */
        $fields = array_filter($event->getForm()->all(), function($field){
            return $this->filterFieldsByType($field, 'OrderByType');
        });

        foreach($fields as $field){
            //if we have no items, ignore this field
            //if $items is not array turn it into one
            //items should be an array of Posts
            $items = $field->getNormData();
            if(empty($items)) continue;
            if(!is_array($items)) $items = array($items);

            //add the ids of each of the connected post items to the $connectedItems array
            $connectedItems = array_merge($connectedItems, array_map(function($item){ return $item->ID; },$items));

            $childPostType = $field->getConfig()->getOption('post_type');

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

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'wp_query';
    }


}