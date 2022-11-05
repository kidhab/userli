<?php

namespace App\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReservedNameAdmin extends Admin
{
    protected function generateBaseRoutePattern(bool $isChildAdmin = false): string {
        return 'reservedname';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name', TextType::class, ['disabled' => !$this->isNewObject()]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('name');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id', null, [
                'route' => [
                    'name' => 'edit',
                ],
            ])
            ->addIdentifier('name', null, [
                'route' => [
                    'name' => 'edit',
                ],
            ])
            ->add('creationTime')
            ->add('updatedTime');
    }
}
