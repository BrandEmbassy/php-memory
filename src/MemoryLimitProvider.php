<?php declare(strict_types = 1);

namespace BrandEmbassy\Memory;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Nette\Utils\Strings;

class MemoryLimitProvider
{

    private const BYTES_AMOUNT = 1024;

    /**
     * @var MemoryConfiguration
     */
    private $configuration;

    public function __construct(MemoryConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getLimitInBytes(): int
    {
        $limitFromConfiguration = Strings::trim($this->configuration->getMemoryLimit());
        $lastCharacter = $this->extractLastCharacterFromString($limitFromConfiguration);

        if (static::isIntegerish($lastCharacter)) {
            return (int)$limitFromConfiguration;
        }

        $intValueFromConfiguration = (int)$limitFromConfiguration;
        $multiplier = self::BYTES_AMOUNT ** MemoryLimitUnitTypes::byName($lastCharacter)->getValue();

        return $intValueFromConfiguration * $multiplier;
    }

    private function extractLastCharacterFromString(string $wholeString): string
    {
        return Strings::upper(\substr($wholeString, -1));
    }

    private function isIntegerish(string $value): bool
    {
        try {
            Assertion::integerish($value);
        } catch (AssertionFailedException $e) {
            return false;
        }

        return true;
    }

}
