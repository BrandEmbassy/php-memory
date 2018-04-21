<?php declare(strict_types = 1);

namespace BrandEmbassy\Memory;

class MemoryConfiguration
{

    public function getMemoryLimit(): string
    {
        return \ini_get('memory_limit');
    }

}
