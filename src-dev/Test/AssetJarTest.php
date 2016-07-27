<?php

namespace Cheppers\AssetJar\Test;

use Cheppers\AssetJar\AssetJar;

/**
 * Class JarTest.
 *
 * @package Cheppers\Test\Jar
 */
class AssetJarTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $asset_jar = new AssetJar();
        static::assertEquals([], $asset_jar->getValue([]));

        $asset_jar = new AssetJar([]);
        static::assertEquals([], $asset_jar->getValue([]));

        $asset_jar = new AssetJar(['foo' => 'bar']);
        static::assertEquals(['foo' => 'bar'], $asset_jar->getValue([]));
    }

    /**
     * @return array
     */
    public function casesGetValue()
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
     *
     * @param array $parents
     * @param mixed $expected_value
     * @param bool $expected_key_exists
     */
    public function testGetValue(array $parents, $expected_value, $expected_key_exists)
    {
        $asset_jar = new AssetJar([
            'a' => 'b',
            'c' => [
                'd' => [
                    'e' => 'f',
                    'g' => 'h',
                ],
            ],
        ]);
        static::assertEquals($expected_value, $asset_jar->getValue($parents, $key_exists));
        static::assertEquals($expected_key_exists, $key_exists);
    }

    /**
     * @return array
     */
    public function casesSetValue()
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
     *
     *
     * @param mixed $expected
     * @param array $parents
     * @param mixed$value
     * @param bool $force
     */
    public function testSetValue($expected, array $parents, $value, $force)
    {
        $asset_jar = new AssetJar([
            'a' => 'b',
            'c' => [
                'd' => [
                    'e' => 'f',
                    'g' => 'h',
                ],
            ],
        ]);
        $asset_jar->setValue($parents, $value, $force);
        static::assertEquals($expected, $asset_jar->getValue($parents));
    }

    public function testUnsetValue()
    {
        $asset_jar = new AssetJar([
            'a' => 'b',
            'c' => [
                'd' => [
                    'e' => 'f',
                    'g' => 'h',
                ],
            ],
        ]);
        $asset_jar->unsetValue(['c', 'd'], $key_exists);
        static::assertTrue($key_exists);

        $asset_jar->unsetValue(['c', 'd'], $key_exists);
        static::assertFalse($key_exists);
    }

    public function testKeyExists()
    {
        $asset_jar = new AssetJar([
            'a' => 'b',
            'c' => [
                'd' => [
                    'e' => 'f',
                    'g' => 'h',
                ],
            ],
        ]);
        static::assertTrue($asset_jar->keyExists(['c', 'd']));
        static::assertFalse($asset_jar->keyExists(['c', 'd', 'h']));
    }
}
