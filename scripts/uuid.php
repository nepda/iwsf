<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

echo \Ramsey\Uuid\Uuid::uuid4()->toString() . PHP_EOL;
