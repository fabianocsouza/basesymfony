<?php

namespace App\Controller;

use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Student;
use App\Repository\StudentRepository;

#[Route('/student', name: 'student_')]
class StudentController extends AbstractController
{
    private StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(): Response
    {
        $data['students'] = $this->studentRepository->findAll();
        $data['title'] = 'Listar alunos cadastrados';

        return $this->render('student/index.html.twig', $data);
    }

    #[Route('/create', name: 'create', methods: ['POST', 'GET'])]
    public function add(Request $request): Response
    {
        $message = '';
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->studentRepository->persist($student);
            $message = 'Cadastro realizado com sucesso!';
        }


        $data['title'] = 'Cadastrar novo aluno';
        $data['form'] = $form;
        $data['message'] = $message;
        return $this->renderForm('student/form.html.twig', $data);

    }


    #[Route('/update/{id}', name: 'update', methods: ['GET', 'POST'])]
    public function update(Request $request, Student $student): Response
    {

        $message = '';
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();
            $message = 'Cadastro editado com sucesso';
        }

        $data['title'] = 'Editar cadastro de aluno';
        $data['form'] = $form;
        $data['message'] = $message;
        return $this->renderForm('student/form.html.twig', $data);

    }

    #[Route('/delete/{id}', name: 'delete', methods: ['GET', 'POST'])]
    public function delete(Student $student): Response
    {
        $this->studentRepository->delete($student);
        return $this->redirectToRoute('student_list');
    }


}