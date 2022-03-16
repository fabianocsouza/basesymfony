<?php

namespace App\Controller;


use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/course', name: 'course_')]
class CourseController extends AbstractController {

    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(): Response
    {
        $data['courses'] = $this->courseRepository->findAll();
        $data['title'] = 'Listar cursos cadastrado';
        return $this->render('course/index.html.twig', $data);
    }

    #[Route('/create', name:'create', methods:['POST', 'GET'])]
    public function create(Request $request): Response
    {
        $message = '';
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->courseRepository->persist($course);
            $message = 'Curso cadastrado realizado sucesso!';
        }

        $data['title'] = 'Cadastrar novo curso';
        $data['form'] = $form;
        $data['message'] = $message;
        return $this->renderForm('course/form.html.twig', $data);
    }

    #[Route('/update/{id}', name: 'update', methods: ['GET', 'POST'])]
    public function update(Request $request, Course $course): Response
    {
        $message = '';
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();
            $message = 'Cadastro editado com sucesso';
        }

        $data['title'] = 'Editar cadastro do curso';
        $data['form'] = $form;
        $data['message'] = $message;
        return $this->renderForm('course/form.html.twig', $data);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['GET', 'POST'])]
    public function delete(Course $course): Response
    {
        $this->courseRepository->delete($course);
        return $this->redirectToRoute('course_list');
    }
}
