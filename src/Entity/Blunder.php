<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Blunder extends BaseEntity
{
    /**
     * @ORM\Column(name="blunder_id", type="string")
     */
    private $blunderId;

    /**
     * @ORM\Column(name="blunder_move", type="string")
     */
    private $blunderMove;

    /**
     * @ORM\Column(name="elo", type="integer")
     */
    private $elo;

    /**
     * @ORM\Column(name="fen", type="string")
     */
    private $fen;

    /**
     * @ORM\Column(name="solution", type="array")
     */
    private $solution;

    /**
     * @ORM\Column(name="pv", type="array")
     */
    private $pv;

    public function getBlunderId()
    {
        return $this->blunderId;
    }

    public function setBlunderId($blunderId)
    {
        $this->blunderId = $blunderId;
    }

    public function getBlunderMove()
    {
        return $this->blunderMove;
    }

    public function setBlunderMove($blunderMove)
    {
        $this->blunderMove = $blunderMove;
    }

    public function getElo()
    {
        return $this->elo;
    }

    public function setElo($elo)
    {
        $this->elo = $elo;
    }

    public function getFen()
    {
        return $this->fen;
    }

    public function setFen($fen)
    {
        $this->fen = $fen;
    }

    public function getSolution()
    {
        return $this->solution;
    }

    public function setSolution($solution)
    {
        $this->solution = $solution;
    }

    public function getPv()
    {
        return $this->pv;
    }

    public function setPv($pv)
    {
        $this->pv = $pv;
    }

}