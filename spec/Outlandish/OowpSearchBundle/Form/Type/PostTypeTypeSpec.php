<?php

namespace spec\Outlandish\OowpSearchBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Outlandish\OowpBundle\Manager\PostManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostTypeTypeSpec extends ObjectBehavior
{
    public function let(PostManager $postManager)
    {
        $this->beConstructedWith($postManager);
        $postManager->postTypeMapping()->willReturn([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Outlandish\OowpSearchBundle\Form\Type\PostTypeType');
    }

    public function it_sets_default_options(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::type('array'))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    public function it_sets_the_default_option_for_multiple_as_false(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('multiple', false))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    public function it_sets_the_default_option_for_expanded_to_true(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('expanded', true));
        $this->setDefaultOptions($resolver);
    }

    public function it_sets_the_default_option_for_required_to_false(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('required', false));
        $this->setDefaultOptions($resolver);
    }

    public function it_sets_the_default_option_for_empty_data_to_all(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('empty_data', 'all'));
        $this->setDefaultOptions($resolver);
    }

    public function it_sets_the_default_option_for_empty_value_to_all(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(Argument::withEntry('empty_value', 'All'));
        $this->setDefaultOptions($resolver);
    }

    public function it_sets_the_default_option_for_choices_to_all(OptionsResolverInterface $resolver)
    {
        //we check that this is an array as that is what we have set
        //postManager to return when we call postTypeMapping()
        $resolver->setDefaults(Argument::withEntry('choices', array()));
        $this->setDefaultOptions($resolver);
    }

    public function its_name_is_post_type()
    {
        $this->getName()->shouldReturn('post_type');
    }

    public function its_parent_form_type_is_choice()
    {
        $this->getParent()->shouldReturn('choice');
    }

}
