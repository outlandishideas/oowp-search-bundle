<?php

namespace spec\Outlandish\OowpSearchBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderTypeSpec extends ObjectBehavior
{
    /**
     * Checks that OrderType is initialisable
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType('Outlandish\OowpSearchBundle\Form\Type\OrderType');
    }

    /**
     * Checks that the name of this Form Type is order
     */
    public function its_name_is_order()
    {
        $this->getName()->shouldReturn('order');
    }

    /**
     * Checks that the parent of this Form Type is choice
     *
     * This Form Type should have a parent type of choice as it will
     * be displayed to the user as a select box, checkboxes or a
     * radio button group
     */
    public function its_parent_type_is_choice()
    {
        $this->getParent()->shouldReturn('choice');
    }

    /**
     * Checks that the setDefaults() method on the OptionsResolver class is called
     */
    public function it_should_set_the_default_options(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::type('array'))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    /**
     * Checks that the default value for the mapped option is set to false
     *
     * The default value for the mapped option should be false as this Data for this
     * form type will be handled by an Event Listener, so that the correct key can
     * be set on the returned data from the form.
     */
    public function it_should_set_the_default_for_mapped_to_false(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('mapped', false))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    /**
     * Checks that the default value for the required option is set to true
     *
     * The default value for the required option should be set to true as we want to determine
     * the order that will be set on the WP Query arguments that this form field will
     * help to generate.
     */
    public function it_should_set_the_default_for_required_to_true(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('required', true))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    /**
     * Checks that the default value for the choices option is set to DESC and ASC
     *
     * These are the two values that WP_Query will accept for the order argument when querying
     * posts in WordPress.
     */
    public function it_should_set_the_default_for_choices_to_be_desc_and_asc(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('choices', ['DESC' => 'Descending', 'ASC' => 'Ascending']))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }
}
