<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Form\RegistrationType;
use App\Repository\RegistrationRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/registration', name: 'registration_')]
class RegistrationController extends AbstractController
{

    private RegistrationRepository $registrationRepository;
    private StudentRepository $studentRepository;

    public function __construct(RegistrationRepository $registrationRepository, StudentRepository $studentRepository)
    {
        $this->registrationRepository = $registrationRepository;
        $this->studentRepository = $studentRepository;
    }

    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(): Response
    {
        $data['students'] =  $this->studentRepository->findAll();
        $data['title'] = 'Matriculas de  alunos ativos';
        return $this->render('registration/index.html.twig', $data);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {

        $message='';
        $registration = new Registration();

        $form = $this->createForm(RegistrationType::class, $registration);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->registrationRepository->persist($registration);
            $message = 'Matricula realizado com sucesso';
        }

        $data['title'] = 'Matricular aluno em curso';
        $data['form'] = $form;
        $data['message'] = $message;

        return $this->renderForm('registration/form.html.twig', $data);
    }

}
