<?php

namespace Sweetchuck\AssetJar\Test;

use Sweetchuck\AssetJar\AssetJar;

class AssetJarTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct(): void
    {
        $asset_jar = new AssetJar();
        static::assertEquals([], $asset_jar->getValue([]));

        $asset_jar = new AssetJar([]);
        static::assertEquals([], $asset_jar->getValue([]));

        $asset_jar = new AssetJar(['foo' => 'bar']);
        static::assertEquals(['foo' => 'bar'], $asset_jar->getValue([]));
    }

    public function casesGetValue(): array
    {
        return [
            [
                'parents' => [],
                'value' => [
                    'a' => 'b',
                    'c' => [
                        'd' => [
                            'e' => 'f',
                            'g' => 'h',
                        ]
                    ]
                ],
                'key_exists' => true,
            ],
            [
                'parents' => ['a'],
                'value' => 'b',
                'key_exists' => true,
            ],
            [
                'parents' => ['c', 'd'],
                'value' => [
                    'e' => 'f',
                    'g' => 'h',
                ],
                'key_exists' => true,
            ],
            [
                'parents' => ['c', 'd', 'none'],
                'value' => null,
                'key_exists' => false,
            ],
        ];
    }

    /**
     * @dataProvider casesGetValue
     */
    public function testGetValue(array $parents, $expectedValue, bool $expectedKeyExists): void
    {
        $assetJar = new AssetJar([
            'a' => 'b',
            'c' => [
                'd' => [
                    'e' => 'f',
                    'g' => 'h',
                ],
            ],
        ]);
        static::assertEquals($expectedValue, $assetJar->getValue($parents, $key_exists));
        static::assertEquals($expectedKeyExists, $key_exists);
    }

    public function casesSetValue(): array
    {
        return [
            [
                'expected' => 'i',
                'parents' => ['a'],
                'value' => 'i',
                'force' => false,
            ],
            [
                'expected' => 'i',
                'parents' => ['a', 'l'],
                'value' => 'i',
                'force' => true,
            ],
        ];
    }

    /**
     * @dataProvider casesSetValue
     */
    public function testSetValue($expected, array $parents, $value, bool $force): void
    {
        $assetJar = new AssetJar([
            'a' => 'b',
            'c' => [
                'd' => [
                    'e' => 'f',
                    'g' => 'h',
                ],
            ],
        ]);
        $assetJar->setValue($parents, $value, $force);
        static::assertEquals($expected, $assetJar->getValue($parents));
    }

    public function testUnsetValue(): void
    {
        $assetJar = new AssetJar([
            'a' => 'b',
            'c' => [
                'd' => [
                    'e' => 'f',
                    'g' => 'h',
                ],
            ],
        ]);
        $assetJar->unsetValue(['c', 'd'], $key_exists);
        static::assertTrue($key_exists);

        $assetJar->unsetValue(['c', 'd'], $key_exists);
        static::assertFalse($key_exists);
    }

    public function testKeyExists(): void
    {
        $assetJar = new AssetJar([
            'a' => 'b',
            'c' => [
                'd' => [
                    'e' => 'f',
                    'g' => 'h',
                ],
            ],
        ]);
        static::assertTrue($assetJar->keyExists(['c', 'd']));
        static::assertFalse($assetJar->keyExists(['c', 'd', 'h']));
    }
}
