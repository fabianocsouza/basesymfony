<?php

namespace App\Form;

use App\Entity\Registration;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::SUBMIT, [$this, "onSubmit"])
            ->add('name', TextType::class,
                ['label' => 'Nome completo do aluno: '])
            ->add('cpf', TextType::class,
                ['attr' => ['minlength' => 11, 'maxlength' => 15],
                    'label' => 'CPF do aluno: '])
            ->add('Salvar', SubmitType::class)
            ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }

   public function onSubmit(FormEvent $event){

       /**
        * @var Student $student
        */

        $student = $event->getData();

        $cpfValido = $this->validateCPF($student->getCpf());

        if(!$cpfValido) {
            $form = $event->getForm();
            $form->get("cpf")->addError(new FormError("Por favor, digitar um cpf válido"));
        }
   }

    private function validateCPF($cpf) {


        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {

                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;

    }

}
