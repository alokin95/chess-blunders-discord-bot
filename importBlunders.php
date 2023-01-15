<?php

use App\Entity\APIBlunder;
use App\Exception\ExceptionHandler;
use App\Service\Fen\FenFormatService;

include __DIR__.'/core/bootstrap.php';

$fenFormatService = new FenFormatService();


try {
    $filepath = config('lichess', 'file_path');
    $file = fopen($filepath, 'r');
    
    $key = 0;
    while (($data = fgetcsv($file)) !== false) {
        $apiBlunder = new APIBlunder();
        $apiBlunder->setJson($data);
    
        entityManager()->persist($apiBlunder);

        echo "Blunder $key imported\n";
        $key++;
    }
    fclose($file);
    
    entityManager()->flush();
} catch (Throwable $throwable) {
    $exceptionHandler = new ExceptionHandler();
    $exceptionHandler->handle($throwable, basename(__FILE__, '.php'));
}
