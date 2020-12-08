<?php

namespace App\Exception;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ExceptionHandler
{

    private $logger;
    private $errors;

    public function __construct() {
        $this->logger = new Logger('discord_bot', [ new StreamHandler(__DIR__ . '/../var/log/bot.log') ] );
    }

    public function handle( \Throwable $ex , $discordMessage) {

        $message = $this->get_message($ex);

        if($detailed_message = $this->get_caller($ex)){
            $message = $detailed_message . $message;
        }

        $this->logger->info( '=============================' );
        $this->logger->info( $discordMessage );
        $this->logger->error( $message );

        $this->errors[] = $ex->getMessage();
    }

    /**
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    public function get_message(\Throwable $ex){
        return <<<EOD
 Message: {$ex->getMessage()} 
 Trace: {$ex->getTraceAsString()}
EOD;

    }

    public function get_caller(\Throwable $ex){

        $trace = $ex->getTrace();
        foreach ($trace as $key => $value){
            $caller_key = $key;
        }

        if(isset($caller_key)){

            return 'File: ' .  $trace[$caller_key]['file'] . ' Line: ' . $trace[$caller_key]['line'];

        }

    }

    public function __destruct() {

    }


}