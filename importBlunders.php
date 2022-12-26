<?php

use App\DTO\LichessBlunder;
use App\Entity\APIBlunder;
use App\Entity\Blunder;
use App\Entity\Enum\BlunderProvider;
use App\Service\Blunder\Lichessorg\LichessBlunderHelperService;
use App\Service\Fen\FenFormatService;
use PChess\Chess\Chess;

include __DIR__.'/core/bootstrap.php';

$fenFormatService = new FenFormatService();


try {
    $filepath = config('lichess', 'file_path');
    $file = fopen($filepath, 'r');
    
    $key = 0;
    while (($data = fgetcsv($file)) !== false) {
        if ($key == 50000) {
            break;
        }
        $apiBlunder = new APIBlunder();
        $apiBlunder->setJson($data);
    
        entityManager()->persist($apiBlunder);
        $key++;
    }
    fclose($file);
    
    entityManager()->flush();
} catch (Throwable $throwable) {
    $exceptionHandler = new ExceptionHandler();
    $exceptionHandler->handle($throwable, basename(__FILE__, '.php'));
}
