<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * In this class I've defined the OptionFormType. It has to be an Integer TypeField
 * and a Submitt button
 */
class OptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('option', IntegerType::class)
            ->add('Salvar', SubmitType::class)
            ->getForm();
    }
}