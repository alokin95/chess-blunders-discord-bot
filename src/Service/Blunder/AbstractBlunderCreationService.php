<?php

namespace App\Service\Blunder;

use App\Entity\Blunder;
use App\Repository\BlunderRepository;
use App\Service\Fen\FenFormatService;

abstract class  AbstractBlunderCreationService
{
    protected GetBlunderInterface $blunder;
    protected FenFormatService $fenFormatService;
    protected BlunderRepository $blunderRepository;

    public function __construct(GetBlunderInterface $blunder)
    {
        $this->blunder              = $blunder;
        $this->fenFormatService     = new FenFormatService();
        $this->blunderRepository    = new BlunderRepository();
    }

    public abstract function createBlunder(): Blunder;

    protected function checkIfBlunderAlreadyExists(Blunder $blunder)
    {
        return $this->blunderRepository->findOneBy(
            [
                'blunderId' => $blunder->getBlunderId(),
                'blunder_provider' => $blunder->getBlunderProvider()
            ]
        );
    }

}