<?php declare(strict_types = 1);

namespace BrandEmbassy\Memory;

class MemoryConfiguration
{

    private const MEMORY_LIMIT_KEY = 'memory_limit';

    public function getMemoryLimit(): string
    {
        return \trim(\ini_get(self::MEMORY_LIMIT_KEY));
    }

}
