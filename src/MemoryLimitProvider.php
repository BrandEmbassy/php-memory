<?php declare(strict_types = 1);

namespace BrandEmbassy\Memory;

class MemoryLimitProvider
{

    private const BYTES_MULTIPLIER = 1024;
    private const LAST_CHARACTER_OFFSET = -1;

    /**
     * @var MemoryConfiguration
     */
    private $configuration;

    public function __construct(MemoryConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return int
     * @throws MemoryLimitNotSetException
     */
    public function getLimitInBytes(): int
    {
        $limitFromConfiguration = $this->getLimitFromConfiguration();
        $lastCharacter = $this->extractLastCharacterFromString($limitFromConfiguration);

        if (\ctype_digit($lastCharacter)) {
            return (int)$limitFromConfiguration;
        }

        $multiplier = $this->getMultiplier($lastCharacter);

        return (int)$limitFromConfiguration * $multiplier;
    }

    /**
     * @return string
     * @throws MemoryLimitNotSetException
     */
    private function getLimitFromConfiguration(): string
    {
        $limitFromConfiguration = $this->configuration->getMemoryLimit();

        if ($limitFromConfiguration === '') {
            throw new MemoryLimitNotSetException();
        }

        return $limitFromConfiguration;
    }

    private function extractLastCharacterFromString(string $wholeString): string
    {
        $lastCharacter = \substr($wholeString, self::LAST_CHARACTER_OFFSET);

        return \strtoupper($lastCharacter);
    }

    private function getMultiplier(string $lastCharacter): int
    {
        $unitTypeMultiplier = MemoryLimitUnitTypeMultipliers::byName($lastCharacter)->getValue();
        \assert(\is_int($unitTypeMultiplier));

        return self::BYTES_MULTIPLIER ** $unitTypeMultiplier;
    }

}
