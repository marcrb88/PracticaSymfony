<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * This class defines the ProviderFormType. It will contain name field (TextType),
 * email (TextType), phone (IntegerType), provider_type (ChoiceType), 
 * an active (ChoiceType) and a submit button
 */
class ProviderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('name', TextType::class)
            ->add('email', TextType::class)
            ->add('phone', IntegerType::class)
            ->add('provider_type', ChoiceType::class, [
                'choices'  => [
                    'Hotel' => 1,
                    'Pista' => 2,
                    'Complement' => 3,
                ],
            ])
            ->add('active', ChoiceType::class, [
                'choices'  => [
                    'Si' => 1,
                    'No' => 0,
                ],
            ])
            ->add('Salvar', SubmitType::class)
            ->getForm();
    }
}