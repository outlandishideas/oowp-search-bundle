<?php

namespace spec\Outlandish\OowpSearchBundle\Form\Type;

use Outlandish\OowpBundle\Manager\PostManager;
use Outlandish\OowpBundle\Manager\QueryManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostToPostTypeSpec extends ObjectBehavior
{
    public function let(PostManager $postManager, QueryManager $queryManager)
    {
        $this->beConstructedWith($postManager, $queryManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Outlandish\OowpSearchBundle\Form\Type\PostToPostType');
    }

    public function its_name_is_post_to_post()
    {
        $this->getName()->shouldReturn('post_to_post');
    }

    public function its_parent_is_choice()
    {
        $this->getParent()->shouldReturn('choice');
    }

    public function it_sets_the_required_options_and_the_default_options(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(Argument::type('array'))->shouldBeCalled();
        $resolver->setDefaults(Argument::type('array'))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    public function it_sets_post_type_as_a_required_option(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(Argument::containing('post_type'))->shouldBeCalled();
        $resolver->setDefaults(Argument::type('array'))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    public function it_sets_the_default_option_for_mapped_to_false(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(Argument::type('array'))->shouldBeCalled();
        $resolver->setDefaults(Argument::withEntry('mapped', false))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    public function it_sets_the_default_option_for_multiple_to_true(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(Argument::type('array'))->shouldBeCalled();
        $resolver->setDefaults(Argument::withEntry('multiple', true))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    public function it_sets_the_default_option_for_required_to_false(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(Argument::type('array'))->shouldBeCalled();
        $resolver->setDefaults(Argument::withEntry('required', false))->shouldBeCalled();
        $this->setDefaultOptions($resolver);
    }

    //todo: figure out how to check for a closure for choice_list
//    public function it_sets_the_default_option_for_choice_list_to_a_closure(OptionsResolverInterface $resolver)
//    {
//        $resolver->setRequired(Argument::type('array'))->shouldBeCalled();
//        $resolver->setDefaults(Argument::withEntry('choice_list', 'closure'))->shouldBeCalled();
//        $this->setDefaultOptions($resolver);
//    }
}
