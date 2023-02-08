<?php

namespace App\Service\Rating;

class UserRatingService
{
    const CONSTANT = 30;

    public function calculateUserRating
    (
        int $currentUserRating,
        int $blunderRating,
        int $constant = self::CONSTANT,
        bool $blunderIsSolved = true
    ): int
    {
        $successProbability = $this->calculateProbability($blunderRating, $currentUserRating);

        if ($blunderIsSolved) {
            $currentUserRating = $currentUserRating + $constant * (1 - $successProbability);
        }
        else {
            $currentUserRating = $currentUserRating + $constant * (0 - $successProbability);
        }

        return $currentUserRating;
    }

    /**
     * Calculates probability for success or failure when comparing two ratings
     */
    private function calculateProbability(int $rating1, int $rating2): float
    {
        return (
            (1.0) / (1 + 1.0 * pow(10, (1.0 * ($rating1 - $rating2)) / 400))
        );
    }

    public function getConstantByNumberOfTries(int $numberOfTries): int
    {
        if ($numberOfTries <= 1) {
            return self::CONSTANT;
        }

        if ($numberOfTries <= 3) {
            return 20;
        }

        if ($numberOfTries <= 5) {
            return 10;
        }

        return 5;
    }
}