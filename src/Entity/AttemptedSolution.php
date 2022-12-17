<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'AttemptedSolutions')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class AttemptedSolution extends BaseEntity
{
    #[ORM\ManyToOne(targetEntity: 'Blunder')]
    #[ORM\JoinColumn(name: 'blunder_id', referencedColumnName: 'id')]
    private Blunder $blunder;

    #[ORM\Column(name: 'user_id', type: 'string')]
    private ?string $user = null;

    #[ORM\Column(name: 'submitted_solution', type: 'array')]
    private ?string $submittedSolution = null;

    public function getBlunder(): Blunder
    {
        return $this->blunder;
    }

    public function setBlunder($blunder)
    {
        $this->blunder = $blunder;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getSubmittedSolution(): ?string
    {
        return $this->submittedSolution;
    }

    public function setSubmittedSolution($submittedSolution)
    {
        $this->submittedSolution = $submittedSolution;
    }


}