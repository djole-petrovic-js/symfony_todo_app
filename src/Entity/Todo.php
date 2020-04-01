<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Constraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TodoRepository")
 */
class Todo extends AbstractType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contact;

    /**
     * @var string
     * @Constraint\NotBlank
     * @Constraint\Length(
     *   min = 2,
     *   max = 20,
     *   minMessage = "First Name must have at least 2 characters",
     *   maxMessage = "First Name must not have above 20 characters"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @Constraint\NotNull()
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $medium;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priority;

    /**
     * @Constraint\DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_planed;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_deadline;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $completed;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getMedium(): ?string
    {
        return $this->medium;
    }

    public function setMedium(?string $medium): self
    {
        $this->medium = $medium;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
    
    public function getDatePlaned(): ?\DateTimeInterface
    {
        return $this->date_planed;
    }

    public function setDatePlaned(?\DateTimeInterface $date_planed): self
    {
        $this->date_planed = $date_planed;

        return $this;
    }

    public function getDateDeadline(): ?\DateTimeInterface
    {
        return $this->date_deadline;
    }

    public function setDateDeadline(?\DateTimeInterface $date_deadline): self
    {
        $this->date_deadline = $date_deadline;

        return $this;
    }

    public function getCompleted(): ?int
    {
        return $this->completed;
    }

    public function setCompleted(?int $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name',TextType::class,[
                'empty_data' => '',
                'required' => true
            ])
            ->add('last_name',TextType::class,[
                'empty_data' => '',
                'required' => true
            ])
            ->add('description',TextType::class,[
                'empty_data' => '',
                'required' => true
            ])
            ->add('contact',TextType::class,[
                'empty_data' => '',
                'required' => true
            ])
            ->add('medium',TextType::class,[
                'empty_data' => '',
                'required' => true
            ])
            ->add('duration',IntegerType::class,[
                'empty_data' => '',
                'required' => true
            ])
            ->add('priority',IntegerType::class,[
                'empty_data' => '',
                'required' => true
            ])
            ->add('date_planed',DateTimeType::class,[
                'empty_data' => '',
                'required' => true
            ])
            ->add('date_deadline',DateTimeType::class,[
                'empty_data' => '',
                'required' => true
            ])
            ->add('completed',IntegerType::class,[
                'empty_data' => '',
                'required' => true
            ])
            ->add('submit',SubmitType::class);
    }
}