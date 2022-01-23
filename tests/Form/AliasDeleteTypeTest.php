<?php

namespace App\Tests\Form;

use App\Form\AliasDeleteType;
use App\Form\Model\Delete;
use Symfony\Component\Form\Test\TypeTestCase;

class AliasDeleteTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $password = 'password';
        $formData = ['password' => $password];

        $form = $this->factory->create(AliasDeleteType::class);

        $object = new Delete();
        $object->password = $password;

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
