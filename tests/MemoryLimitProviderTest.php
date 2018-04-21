<?php declare(strict_types = 1);

namespace BrandEmbassyTest\Memory;

use BrandEmbassy\Memory\MemoryConfiguration;
use BrandEmbassy\Memory\MemoryLimitNotSetException;
use BrandEmbassy\Memory\MemoryLimitProvider;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class MemoryLimitProviderTest extends TestCase
{

    /**
     * @dataProvider phpConfigurationProvider
     *
     * @param string $phpConfigurationValue
     * @param int $expectedLimit
     */
    public function testShouldGetLimitInBytes(string $phpConfigurationValue, int $expectedLimit): void
    {
        $configuration = $this->createMemoryConfigurationMock($phpConfigurationValue);

        $limitProvider = new MemoryLimitProvider($configuration);
        $actualLimit = $limitProvider->getLimitInBytes();

        $this->assertSame($expectedLimit, $actualLimit);
    }

    public function phpConfigurationProvider(): array
    {
        return [
            'without unit type, just bytes' => ['500', 500],
            '1 GB with big "G"' => ['1G', 1 * 1024 * 1024 * 1024],
            '128 MB with big "M"' => ['128M', 128 * 1024 * 1024],
            '128 MB with small "m"' => ['128m', 128 * 1024 * 1024],
            '24 kB with small "k"' => ['24k', 24 * 1024],
            '2 GB with small "g"' => ['2g', 2 * 1024 * 1024 * 1024],
            'unlimited memory' => ['-1', -1],
            'invalid float value' => ['2.5M', 2 * 1024 * 1024],
        ];
    }

    public function testShouldThrowExceptionWhenMemoryLimitOptionIsNotSet(): void
    {
        $this->expectException(MemoryLimitNotSetException::class);

        $configuration = $this->createMemoryConfigurationMock('');

        $limitProvider = new MemoryLimitProvider($configuration);
        $limitProvider->getLimitInBytes();
    }

    /**
     * @param string $limitToReturn
     * @return MemoryConfiguration&MockInterface
     */
    private function createMemoryConfigurationMock(string $limitToReturn): MemoryConfiguration
    {
        /** @var MemoryConfiguration&MockInterface $mock */
        $mock = Mockery::mock(MemoryConfiguration::class);
        $mock->shouldReceive('getMemoryLimit')->andReturn($limitToReturn);

        return $mock;
    }

}
