<?php

namespace App\Service\Blunder;

use App\Entity\Blunder;
use App\Repository\BlunderRepository;
use App\Service\Fen\FenFormatService;

abstract class  AbstractBlunderCreationService
{
    protected GetBlunderInterface $getBlunder;
    protected FenFormatService $fenFormatService;
    protected BlunderRepository $blunderRepository;

    public function __construct(GetBlunderInterface $getBlunder)
    {
        $this->getBlunder           = $getBlunder;
        $this->fenFormatService     = new FenFormatService();
        $this->blunderRepository    = new BlunderRepository();
    }

    public abstract function createBlunder(): Blunder;

    protected function checkIfBlunderAlreadyExists(Blunder $blunder)
    {
        return $this->blunderRepository->findOneBy(
            [
                'blunderId' => $blunder->getBlunderId(),
                'blunderProvider' => $blunder->getBlunderProvider()
            ]
        );
    }

}