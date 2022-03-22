<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegistrationRepository::class)
 */
class Registration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $enrolment_date;
    

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="enrolment")
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="registrations")
     */
    private $student;

    public function __construct()
    {
        $this->setEnrolmentDate(new \DateTime());
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnrolmentDate(): ?\DateTime
    {
        return $this->enrolment_date;
    }

    public function setEnrolmentDate(\DateTimeInterface $enrolment_date): self
    {
        $this->enrolment_date = $enrolment_date;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }


    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }
}
