<?php

namespace spec\Outlandish\OowpSearchBundle\Form\Type;

use Outlandish\OowpBundle\Manager\QueryManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Specification for PostToPostType
 *
 * Class PostToPostTypeSpec
 * @package spec\Outlandish\OowpSearchBundle\Form\Type
 */
class PostToPostTypeSpec extends ObjectBehavior
{
    /**
     * Check that it is constructed with PostManager and QueryManager
     */
    public function let(QueryManager $queryManager)
    {
        $this->beConstructedWith($queryManager);
    }

    /**
     * Check that it is initalizable
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType('Outlandish\OowpSearchBundle\Form\Type\PostToPostType');
    }

    /**
     * Check that the getName() method returns post_to_post
     */
    public function its_name_is_post_to_post()
    {
        $this->getName()->shouldReturn('post_to_post');
    }

    /**
     * Check that the getParent() method returns choice
     *
     * This field should be a choice type field, either a select field
     * checkboxes or radio button group when displayed to the user
     */
    public function its_parent_is_choice()
    {
        $this->getParent()->shouldReturn('choice');
    }

    /**
     * Check that it sets the required options and the default options
     *
     * This checks to see that the setRequired() and setDefaults() methods
     * are correctly called with an array argument on the class that
     * implements the ObjectResolverInterface
     */
    public function it_sets_the_required_options_and_the_default_options(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(Argument::type('array'))->shouldBeCalled();
        $resolver->setDefaults(Argument::type('array'))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    /**
     * Checks that the post_type option is set as required
     *
     */
    public function it_sets_post_type_as_a_required_option(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(Argument::containing('post_type'))->shouldBeCalled();
        $resolver->setDefaults(Argument::type('array'))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    /**
     * Checks that the default value for the mapped option is false
     *
     */
    public function it_sets_the_default_option_for_mapped_to_false(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(Argument::type('array'))->shouldBeCalled();
        $resolver->setDefaults(Argument::withEntry('mapped', false))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    /**
     * Checks that the default value for the multiple option is set to true
     *
     */
    public function it_sets_the_default_option_for_multiple_to_true(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(Argument::type('array'))->shouldBeCalled();
        $resolver->setDefaults(Argument::withEntry('multiple', true))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    /**
     * Checks that the default value for the required option is set to false
     *
     */
    public function it_sets_the_default_option_for_required_to_false(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(Argument::type('array'))->shouldBeCalled();
        $resolver->setDefaults(Argument::withEntry('required', false))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    //
    /**
     * Checks that the default value for the choice_list option is set to closure
     * @todo: figure out how to check for a closure
     */
    public function it_sets_the_default_option_for_choice_list_to_a_closure(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(Argument::type('array'))->shouldBeCalled();
        $resolver->setDefaults(Argument::withKey('choice_list'))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }
}
