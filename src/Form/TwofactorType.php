<?php

namespace App\Form;

use App\Form\Model\Twofactor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TwofactorType extends AbstractType
{
    public const NAME = 'twofactor';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', PasswordType::class, ['label' => 'form.password'])
            ->add('submit', SubmitType::class, ['label' => 'form.twofactor-enable']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Twofactor::class]);
    }

    public function getBlockPrefix(): string
    {
        return self::NAME;
    }
}
