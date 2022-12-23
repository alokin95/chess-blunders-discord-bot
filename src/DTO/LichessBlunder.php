<?php

namespace App\DTO;

class LichessBlunder
{
    private string $blunderId;

    private string $fenBeforeBlunderMove;

    private string $fenAfterBlunderMove;

    private array $unformattedSolution = [];

    private array $standardNotationSolution = [];
    private string $rating;

    private string $blunderMove;

    public function getBlunderId(): string
    {
        return $this->blunderId;
    }

    public function setBlunderId(string $blunderId): void
    {
        $this->blunderId = $blunderId;
    }

    public function getFenBeforeBlunderMove(): string
    {
        return $this->fenBeforeBlunderMove;
    }

    public function setFenBeforeBlunderMove(string $fenBeforeBlunderMove): void
    {
        $this->fenBeforeBlunderMove = $fenBeforeBlunderMove;
    }

    public function getFenAfterBlunderMove(): string
    {
        return $this->fenAfterBlunderMove;
    }

    public function setFenAfterBlunderMove(string $fenAfterBlunderMove): void
    {
        $this->fenAfterBlunderMove = $fenAfterBlunderMove;
    }

    public function getUnformattedSolution(): array
    {
        return $this->unformattedSolution;
    }

    public function setUnformattedSolution(array $unformattedSolution): void
    {
        $this->unformattedSolution = $unformattedSolution;
    }

    public function getStandardNotationSolution(): array
    {
        return $this->standardNotationSolution;
    }

    public function setStandardNotationSolution(array $standardNotationSolution): void
    {
        $this->standardNotationSolution = $standardNotationSolution;
    }

    public function getRating(): string
    {
        return $this->rating;
    }

    public function setRating(string $rating): void
    {
        $this->rating = $rating;
    }

    public function getBlunderMove(): string
    {
        return $this->blunderMove;
    }

    public function setBlunderMove(string $blunderMove): void
    {
        $this->blunderMove = $blunderMove;
    }
}