<?php

declare(strict_types=1);

namespace App\View\Helper;

use Laminas\View\Helper\AbstractHelper;

use function array_key_exists;

final class Config extends AbstractHelper
{
    /** @var array<mixed> $config */
    protected $config;

    /** @param array<array-key, bool|int|string> $config */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function __invoke(?string $key = null): array
    {
        if ($key === null) {
            return $this->config;
        }
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }
        return [];
    }
}
