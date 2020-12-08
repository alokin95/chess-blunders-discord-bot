<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="Solved_Blunders")
 */
class SolvedBlunder extends BaseEntity
{
    /**
     * @ORM\Column(name="user_id", type="string")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Blunder", inversedBy="correctSubmissions")
     * @ORM\JoinColumn(name="blunder_id", referencedColumnName="id")
     */
    private $blunder;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getBlunder()
    {
        return $this->blunder;
    }

    public function setBlunder($blunder)
    {
        $this->blunder = $blunder;
    }

}