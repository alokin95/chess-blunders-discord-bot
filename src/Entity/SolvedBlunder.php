<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'Solved_Blunders')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class SolvedBlunder extends BaseEntity
{
    #[ORM\Column(name: 'user_id', type: 'string')]
    private ?string $user = null;

    #[ORM\ManyToOne(targetEntity: 'Blunder', inversedBy: 'correctSubmissions')]
    #[ORM\JoinColumn(name: 'blunder_id', referencedColumnName: 'id')]
    private Blunder $blunder;

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getBlunder(): Blunder
    {
        return $this->blunder;
    }

    public function setBlunder($blunder)
    {
        $this->blunder = $blunder;
    }

}