<?php

namespace spec\Outlandish\OowpSearchBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class OrderByTypeSpec
 * @package spec\Outlandish\OowpSearchBundle\Form\Type
 */
class OrderByTypeSpec extends ObjectBehavior
{
    /**
     * Checks that this OrderByType can initialised
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType('Outlandish\OowpSearchBundle\Form\Type\OrderByType');
    }

    /**
     * Checks that the name of this Form Type is order_by
     */
    public function its_name_is_order_by()
    {
        $this->getName()->shouldReturn('order_by');
    }

    /**
     * Checks that the parent type of this Form Type is choice
     *
     * The parent type of this Form Type should be choice as there are
     * a set of choices that we want to represent to the user
     */
    public function its_parent_type_is_choice()
    {
        $this->getParent()->shouldReturn('choice');
    }

    /**
     * Checks that the it sets the default values
     */
    public function it_sets_the_default_values(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::type('array'))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    /**
     * Checks that the default value for mapped options is set to false
     *
     * Set the default value for mapped to false as the data for this field will be
     * handled by an Event Listener to ensure that the data produced can be turned
     * into the the WP Query class.
     */
    public function it_sets_the_default_for_mapped_to_false(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('mapped', false))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    /**
     * Checks that the default value for choice option is set to an array of title and date
     */
    public function it_sets_the_default_for_choices_to_title_and_date(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('choices', ['title' => 'Title', 'date' => 'Date']))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }
}
