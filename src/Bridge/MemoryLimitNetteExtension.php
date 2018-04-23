<?php declare(strict_types = 1);

namespace BrandEmbassy\Memory\Bridge;

use BrandEmbassy\Memory\MemoryConfiguration;
use BrandEmbassy\Memory\MemoryLimitProvider;
use Nette\DI\CompilerExtension;

class MemoryLimitNetteExtension extends CompilerExtension
{

    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('phpMemory.configuration'))
            ->setFactory(MemoryConfiguration::class);

        $builder->addDefinition($this->prefix('phpMemory.limitProvider'))
            ->setFactory(MemoryLimitProvider::class)
            ->setAutowired();
    }

}
