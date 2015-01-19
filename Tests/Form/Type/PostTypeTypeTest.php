<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 17/01/2015
 * Time: 20:08
 */

namespace Outlandish\FacetedBundle\Tests\Form\Type;

use Symfony\Component\Form\Test\TypeTestCase;

class PostTypeTypeTest extends TypeTestCase {

    public function testChoiceListAndChoicesCanBeEmpty()
    {
        $this->factory->create('choice');
    }

}
