<?php

namespace App\Controller;

use App\Repository\RegistrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/registration', name: 'registration_')]
class RegistrationController extends AbstractController
{

    private RegistrationRepository $registrationRepository;

    public function __construct(RegistrationRepository $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }

    #[Route('/', name: 'registration', methods: ['GET'])]
    public function index(): Response
    {
        $data['registrations'] =  $this->registrationRepository->findAll();
        $data['title'] = 'Matriculas de  alunos ativos';
        return $this->render('registration/index.html.twig', $data);
    }

}