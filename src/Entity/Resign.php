<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="resignations")
 * @ORM\HasLifecycleCallbacks()
 */
class Resign extends BaseEntity
{
    /**
     * @ORM\Column(name="user", type="string", nullable=false)
     */
    private ?string $user = null;

    /**
     * @ORM\ManyToOne(targetEntity="Blunder")
     * @ORM\JoinColumn(name="blunder_id", referencedColumnName="id")
     */
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