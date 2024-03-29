<?php

namespace App\Entity;

use App\Entity\Enum\BlunderProvider;
use App\Repository\BlunderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlunderRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Blunder extends BaseEntity
{
    #[ORM\Column(name: 'blunder_id', type: 'string')]
    private ?string $blunderId = null;

    #[ORM\Column(name: 'blunder_move', type: 'string', nullable: true)]
    private ?string $blunderMove = null;

    #[ORM\Column(name: 'elo', type: 'integer')]
    private ?int $elo = null;

    #[ORM\Column(name: 'fen', type: 'string')]
    private ?string $fen = null;

    #[ORM\Column(name: 'solution', type: 'array')]
    private array $solution = [];

    #[ORM\Column(name: 'to_play', type: 'string')]
    private ?string $toPlay = null;

    #[ORM\Column(name: 'blunder_provider', type: 'string')]
    private ?string $blunderProvider = null;

    public function getBlunderId(): ?string
    {
        return $this->blunderId;
    }

    public function setBlunderId($blunderId)
    {
        $this->blunderId = $blunderId;
    }

    public function getBlunderMove(): ?string
    {
        return $this->blunderMove;
    }

    public function setBlunderMove($blunderMove)
    {
        $this->blunderMove = $blunderMove;
    }

    public function getElo(): ?int
    {
        return $this->elo;
    }

    public function setElo($elo)
    {
        $this->elo = $elo;
    }

    public function getFen(): ?string
    {
        return $this->fen;
    }

    public function setFen($fen)
    {
        $this->fen = $fen;
    }

    public function getSolution(): array
    {
        return $this->solution;
    }

    public function setSolution($solution)
    {
        $this->solution = $solution;
    }

    public function getToPlay(): ?string
    {
        return $this->toPlay;
    }

    public function setToPlay($toPlay)
    {
        $this->toPlay = $toPlay;
    }

    public function getBlunderProvider(bool $useEnum = false): BlunderProvider|string
    {
        return $useEnum ? BlunderProvider::from($this->blunderProvider) : $this->blunderProvider;
    }

    public function setBlunderProvider(?string $blunderProvider): void
    {
        $this->blunderProvider = $blunderProvider;
    }

    public function getNumberOfMoves(): int
    {
        return count($this->getSolution());
    }
}