<?php declare(strict_types = 1);

namespace BrandEmbassyTest\Memory;

use BrandEmbassy\Memory\MemoryConfiguration;
use BrandEmbassy\Memory\MemoryLimitProvider;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class MemoryLimitProviderTest extends TestCase
{

    /**
     * @dataProvider phpConfigurationProvider
     */
    public function testShouldGetLimitInBytes(string $phpConfigurationValue, int $expectedValue): void
    {
        $configuration = $this->createMemoryConfigurationMock($phpConfigurationValue);

        $limitProvider = new MemoryLimitProvider($configuration);
        $result = $limitProvider->getLimitInBytes();

        $this->assertSame($expectedValue, $result);
    }

    public function phpConfigurationProvider(): array
    {
        return [
            'without unit type, just bytes' => ['500', 500],
            '1 GB with big "G"' => ['1G', 1 * 1024 * 1024 * 1024],
            '500 MB with big "M"' => ['500M', 500 * 1024 * 1024],
            '24 kB with small "k"' => ['24k', 24 * 1024],
            '2 GB with small "g"' => ['2g', 2 * 1024 * 1024 * 1024],
            'unlimited memory' => ['-1', -1],
        ];
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
