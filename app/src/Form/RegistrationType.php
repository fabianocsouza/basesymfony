<?php

namespace App\Form;


use App\Entity\Course;
use App\Entity\Registration;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => 'name',
                'label' => 'Aluno: '
            ])
            ->add('course', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'name',
                'label' => 'Curso: '
            ])
            ->add('Salvar', SubmitType::class)
            ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Registration::class,
        ]);
    }
}
