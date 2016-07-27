<?php

namespace Cheppers\AssetJar\Test;

use Cheppers\AssetJar\AssetJar;
use Cheppers\AssetJar\Test\Helper\AssetJarAwareTestHelper;

/**
 * Class AssetJarAwareTest.
 *
 * @package Cheppers\AssetJar\Test
 */
class AssetJarAwareTest extends \PHPUnit_Framework_TestCase
{

    public function testHasAssetJar()
    {
        $asset_jar_aware = new AssetJarAwareTestHelper();
        static::assertFalse($asset_jar_aware->hasAssetJar());

        $asset_jar_aware = new AssetJarAwareTestHelper();
        $asset_jar_aware->setAssetJar(new AssetJar());
        static::assertTrue($asset_jar_aware->hasAssetJar());
    }

    public function testGetSet()
    {
        $asset_jar = new AssetJar([
            'a' => 'b',
            'c' => [
              'd' => [
                  'e' => 'f',
                  'g' => 'h',
              ]
            ],
        ]);

        $asset_jar_aware = new AssetJarAwareTestHelper();
        static::assertNull($asset_jar_aware->getAssetJarValue('my_g', $key_exists));
        static::assertFalse($key_exists);
        static::assertNull($asset_jar_aware->getAssetJarMap('my_g'));
        static::assertEquals([], $asset_jar_aware->getAssetJarMapping());

        try {
            $asset_jar_aware->setAssetJarValue('my_g', 'new_g_value', false);
            $this->fail('Expected exception 1 not thrown');
        } catch (\RuntimeException $e) {
            $this->assertEquals(1, $e->getCode());
            $this->assertEquals('@todo', $e->getMessage());
        }

        $asset_jar_aware->setAssetJar($asset_jar);
        static::assertNull($asset_jar_aware->getAssetJarValue('my_g', $key_exists));
        static::assertFalse($key_exists);

        $asset_jar_aware->setAssetJarMap('my_g', ['c', 'd', 'g']);
        static::assertEquals('h', $asset_jar_aware->getAssetJarValue('my_g'));
        static::assertEquals(['c', 'd', 'g'], $asset_jar_aware->getAssetJarMap('my_g'));

        $asset_jar_aware->setAssetJarValue('my_g', 'new_g_value', false);
        static::assertEquals('new_g_value', $asset_jar_aware->getAssetJarValue('my_g'));

        $asset_jar_aware->setAssetJarMapping([
            'my_g' => ['c', 'd', 'g'],
            'my_e' => ['c', 'd', 'e'],
        ]);
        static::assertEquals('f', $asset_jar_aware->getAssetJarValue('my_e'));
    }
}
