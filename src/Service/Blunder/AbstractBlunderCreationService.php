<?php


namespace App\Service\Blunder;


use App\Repository\BlunderRepository;
use App\Service\FenFormatService;

abstract class  AbstractBlunderCreationService
{
    protected $blunder;
    protected $fenFormatService;
    protected $blunderRepository;

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