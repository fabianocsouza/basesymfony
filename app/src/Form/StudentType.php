<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                ['label' => 'Nome completo do aluno: '])
            ->add('cpf', TextType::class,
                ['label' => 'CPF do aluno: '])
            ->add('Salvar', SubmitType::class)
            ->getForm();

    }
}