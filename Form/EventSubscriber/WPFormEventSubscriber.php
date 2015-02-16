<?php
/**
 *
 */
namespace Outlandish\OowpSearchBundle\Form\EventSubscriber;

use Outlandish\OowpSearchBundle\Form\Type\AbstractCustomFieldType;
use Outlandish\OowpSearchBundle\Form\Type\OrderByType;
use Outlandish\OowpSearchBundle\Form\Type\OrderType;
use Outlandish\OowpSearchBundle\Form\Type\PostToPostType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class WPFormEventSubscriber
 * @package Outlandish\OowpSearchBundle\Form\EventSubscriber
 */
class WPFormEventSubscriber implements EventSubscriberInterface
{

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::SUBMIT   => 'onSubmit',
        );
    }

    /**
     * @param FormEvent $event
     */
    public function onSubmit(FormEvent $event)
    {
        $data = $event->getData();

        $postTypeFields = $this->getPostTypeFields($event);
        $this->addPostTypeFieldsToData($postTypeFields, $data);

        $orderFields = $this->getOrderFields($event);
        $this->addOrderFieldsToData($orderFields, $data);

        $orderByFields = $this->getOrderByFields($event);
        $this->addOrderByFieldsToData($orderByFields, $data);

        $postToPostFields = $this->getPostToPostFields($event);
        $this->addPostToPostFieldsToData($postToPostFields, $data);

        $fields = $this->getCustomFieldFields($event);
        $this->addCustomFieldFieldsToData($fields, $data);

        $event->setData($data);

    }

    /**
     * filter the the fields of the form for OrderType
     *
     * @param FormEvent $event
     * @return Form[]
     */
    private function getOrderFields(FormEvent $event)
    {
        return $this->getFieldsByType($event, 'Outlandish\OowpSearchBundle\Form\Type\OrderType');
    }

    /**
     * Parse the Order Field Type and add it's data to the forms data
     *
     * @param Form[] $fields
     * @param array $data
     */
    private function addOrderFieldsToData(array $fields, array &$data)
    {
        foreach ($fields as $field) {
            $data = array_merge($data, ['order' => $field->getData()]);
        }
    }

    /**
     * @param FormEvent $event
     * @return Form[]
     */
    private function getOrderByFields(FormEvent $event)
    {
        return $this->getFieldsByType($event, 'Outlandish\OowpSearchBundle\Form\Type\OrderByType');

    }

    /**
     * @param Form[] $fields
     * @param array $data
     */
    private function addOrderByFieldsToData(array $fields, array &$data)
    {
        foreach ($fields as $field) {
            $value = $field->getData();

            if ($this->isWordPressOrderBy($value)) {
                $orderby = ['order_by' => $value];
            } else {
                $orderby = ['order_by' => 'meta_value', 'meta_key' => $value];
            }
            $data = array_merge($data, $orderby);
        }
    }

    /**
     * @param $value
     * @return bool
     */
    private function isWordPressOrderBy($value)
    {
        return in_array($value, OrderByType::getProtectedValues());
    }

    /**
     * @param FormEvent $event
     * @return Form[]
     */
    private function getPostToPostFields(FormEvent $event)
    {
        return array_filter($event->getForm()->all(), function ($field) {
            return $field instanceof Form ? $field->getConfig()->getType()->getInnerType() instanceof PostToPostType : false;
        });
    }

    /**
     * @param Form[] $fields
     * @param array $data
     */
    private function addPostToPostFieldsToData(array $fields, array &$data)
    {

        $connectedItems = array();
        $connectedTypes = array();

        foreach ($fields as $field) {
            $items = $field->getNormData();

            if ($this->nothingSelected($items)) {
                continue;
            }

            $this->ensureArray($items);

            $this->addPostIdsToConnectedItems($connectedItems, $items);

            $this->updateConnectedTypes($data, $field, $connectedTypes);

        }

        $this->AddConnectedQueryToData($data, $connectedTypes, $connectedItems);
    }

    /**
     * @param $items
     * @return bool
     */
    private function nothingSelected($items)
    {
        return empty($items);
    }

    /**
     * @param $items
     */
    private function ensureArray(&$items)
    {
        if (!is_array($items)) {
            $items = array($items);
        }
    }

    /**
     * @param $connectedItems
     * @param $items
     */
    private function addPostIdsToConnectedItems(&$connectedItems, $items)
    {
        $connectedItems = array_merge($connectedItems, array_map(function ($item) {
            return $item->ID;
        }, $items));
    }

    /**
     * @param $field
     * @return mixed
     */
    private function getPostTypeOfField($field)
    {
        return $field->getConfig()->getOption('post_type');
    }

    /**
     * @param array $data
     * @param Form $field
     * @param array $connectedTypes
     * @return array
     */
    private function updateConnectedTypes(array &$data, Form $field, array &$connectedTypes)
    {
        $childPostType = $this->getPostTypeOfField($field);
        $postTypes = is_array($data['post_type']) ? $data['post_type'] : [$data['post_type']];
        foreach ($postTypes as $postType) {
            $connectedTypes[] = $this->generateConnectedType($postType, $childPostType);
        }
    }

    /**
     * @param $postType
     * @param $childPostType
     * @return string
     */
    private function generateConnectedType($postType, $childPostType)
    {
        $types = [$postType, $childPostType];
        sort($types);
        $connectedType = implode('_', $types);

        return $connectedType;
    }

    /**
     * @param $connectedTypes
     * @param $connectedItems
     * @return bool
     */
    private function hasConnectedPosts($connectedTypes, $connectedItems)
    {
        return !empty($connectedTypes) && !empty($connectedItems);
    }

    /**
     * @param array $data
     * @param $connectedTypes
     * @param $connectedItems
     * @return array
     */
    private function AddConnectedQueryToData(array &$data, $connectedTypes, $connectedItems)
    {
        if ($this->hasConnectedPosts($connectedTypes, $connectedItems)) {
            $postToPost = [
                'connection_type' => array_unique($connectedTypes),
                'connection_items' => array_unique($connectedItems)
            ];
            $data = array_merge($data, $postToPost);
        }
    }

    /**
     * @param FormEvent $event
     * @return Form[]
     */
    private function getCustomFieldFields(FormEvent $event)
    {
        return array_filter($event->getForm()->all(), function ($field) {
            return $field instanceof Form ? $field->getConfig()->getType()->getInnerType() instanceof AbstractCustomFieldType : false;
        });
    }

    /**
     * @param $fields
     * @param $data
     */
    private function addCustomFieldFieldsToData($fields, &$data)
    {
        $metaQuery = array();

        foreach ($fields as $field) {
            $value = $field->getData();
            if ($value) {
                $metaQuery[] = $this->createSubMetaQuery($field, $value);
            }
        }
        $this->addRelationToMetaQuery($metaQuery);
        $this->addMetaQueryToData($data, $metaQuery);
    }

    /**
     * @param $field
     * @param $value
     * @return array
     */
    private function createSubMetaQuery($field, $value)
    {
        $key = $field->getConfig()->getOption('meta_key');
        $compare = $field->getConfig()->getOption('compare');
        $type = $field->getConfig()->getOption('type');

        return array(
            'key' => $key,
            'value' => $value,
            'compare' => $compare,
            'type' => $type
        );
    }

    /**
     * @param $metaQuery
     */
    private function addRelationToMetaQuery(&$metaQuery)
    {
        if (count($metaQuery) > 1) {
            $metaQuery['relation'] = 'AND';
        }
    }

    /**
     * @param $data
     * @param $metaQuery
     */
    private function addMetaQueryToData(&$data, $metaQuery)
    {
        if (!empty($metaQuery)) {
            $data = array_merge($data, ['meta_query' => $metaQuery]);
        }
    }

    private function getPostTypeFields($event)
    {
        return $this->getFieldsByType($event, 'Outlandish\OowpSearchBundle\Form\Type\PostTypeType');
    }

    private function getFieldsByType($event, $class)
    {
        return array_filter($event->getForm()->all(), function ($field) use ($class) {
            return $field instanceof Form ? $field->getConfig()->getType()->getInnerType() instanceof $class : false;
        });
    }

    /**
     * @param Form[] $postTypeFields
     * @param array $data
     */
    private function addPostTypeFieldsToData(array $postTypeFields, array &$data)
    {
        /** @var Form[] $postTypeFields */
        foreach ($postTypeFields as $field) {
            $value = $field->getData();

            if ($value == 'all' || $value === null) {
                $value = array_keys($field->getConfig()->getOptions()['choices']);
            }

            $data = array_merge($data, ['post_type' => $value]);
        }
    }

}