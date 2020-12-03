<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
require_once __DIR__.'/../core/bootstrap.php';

return ConsoleRunner::createHelperSet($entity_manager);
