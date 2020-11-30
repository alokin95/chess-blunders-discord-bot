<?php


namespace App\Client;


interface ClientInterface
{
    public function get(string $url, array $query = [], array $headers = []);
//    public function post(string $url, array $body = [], array $headers = []);
}