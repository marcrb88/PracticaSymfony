<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Here I've defined the IdFormType of my Id request. It will be an integer number field
 * with a subbmit button.
 */
class IdFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('provider_id', IntegerType::class)
            ->add('Salvar', SubmitType::class)
            ->getForm();
    }
}