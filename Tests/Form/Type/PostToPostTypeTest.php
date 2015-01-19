<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 17/01/2015
 * Time: 23:30
 */

namespace Outlandish\FacetedBundle\Tests\Form\Type;


use Symfony\Component\Form\Test\TypeTestCase;

class PostToPostTypeTest extends TypeTestCase {

    /**
     * @expectedException \Symfony\Component\Form\Exception\InvalidArgumentException
     */
    public function testPostToPostThrowsExceptionIfNoPostTypeSet()
    {
        $this->factory->create('post_to_post');
    }

}
