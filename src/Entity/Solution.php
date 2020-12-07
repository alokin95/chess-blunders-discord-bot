<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Solution extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Blunder", inversedBy="userSolutions")
     * @ORM\JoinColumn(name="blunder_id", referencedColumnName="id")
     */
    private $blunder;

    /**
     * @ORM\Column(name="user_id", type="string")
     */
    private $user;

    /**
     * @ORM\Column(name="submitted_solution", type="array")
     */
    private $submittedSolution;

    public function getBlunder()
    {
        return $this->blunder;
    }

    public function setBlunder($blunder)
    {
        $this->blunder = $blunder;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getSubmittedSolution()
    {
        return $this->submittedSolution;
    }

    public function setSubmittedSolution($submittedSolution)
    {
        $this->submittedSolution = $submittedSolution;
    }


}