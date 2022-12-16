<?php

namespace App\Service\Blunder;

use App\Repository\BlunderRepository;
use App\Service\Fen\FenFormatService;

abstract class  AbstractBlunderCreationService
{
    protected BlunderInterface $blunder;
    protected FenFormatService $fenFormatService;
    protected BlunderRepository $blunderRepository;

    public function __construct(BlunderInterface $blunder)
    {
        $this->blunder              = $blunder;
        $this->fenFormatService     = new FenFormatService();
        $this->blunderRepository    = new BlunderRepository();
    }

    public abstract function createBlunder();

    protected function checkIfBlunderAlreadyExists($blunder)
    {
        return $this->blunderRepository->findOneBy(['blunderId' => $blunder->getBlunderId()]);
    }

}