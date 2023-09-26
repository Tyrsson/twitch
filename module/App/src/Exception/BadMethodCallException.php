<?php

declare(strict_types=1);

namespace App\Exception;

class BadMethodCallException extends \BadMethodCallException implements
    ExceptionInterface
{
}
