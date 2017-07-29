<?php

namespace Sweetchuck\AssetJar\Test;

use Sweetchuck\AssetJar\AssetJar;
use Sweetchuck\AssetJar\Test\Helper\AssetJarAwareTestHelper;

class AssetJarAwareTest extends \PHPUnit_Framework_TestCase
{

    public function testHasAssetJar(): void
    {
        $assetJarAware = new AssetJarAwareTestHelper();
        static::assertFalse($assetJarAware->hasAssetJar());

        $assetJarAware = new AssetJarAwareTestHelper();
        $assetJarAware->setAssetJar(new AssetJar());
        static::assertTrue($assetJarAware->hasAssetJar());
    }

    public function testGetSetAssetJar(): void
    {
        $assetJarAware = new AssetJarAwareTestHelper();
        static::assertNull($assetJarAware->getAssetJar());
    }

    public function testGetValueSetValue(): void
    {
        $assetJar = new AssetJar([
            'a' => 'b',
            'c' => [
              'd' => [
                  'e' => 'f',
                  'g' => 'h',
              ]
            ],
        ]);

        $assetJarAware = new AssetJarAwareTestHelper();
        static::assertNull($assetJarAware->getAssetJarValue('my_g', $keyExists));
        static::assertFalse($keyExists);
        static::assertNull($assetJarAware->getAssetJarMap('my_g'));
        static::assertEquals([], $assetJarAware->getAssetJarMapping());

        try {
            $assetJarAware->setAssetJarValue('my_g', 'new_g_value', false);
            $this->fail('Expected exception 1 not thrown');
        } catch (\RuntimeException $e) {
            $this->assertEquals(1, $e->getCode());
            $this->assertEquals('@todo', $e->getMessage());
        }

        $assetJarAware->setAssetJar($assetJar);
        static::assertNull($assetJarAware->getAssetJarValue('my_g', $keyExists));
        static::assertFalse($keyExists);

        $assetJarAware->setAssetJarMap('my_g', ['c', 'd', 'g']);
        static::assertEquals('h', $assetJarAware->getAssetJarValue('my_g'));
        static::assertEquals(['c', 'd', 'g'], $assetJarAware->getAssetJarMap('my_g'));

        $assetJarAware->setAssetJarValue('my_g', 'new_g_value', false);
        static::assertEquals('new_g_value', $assetJarAware->getAssetJarValue('my_g'));

        $assetJarAware->setAssetJarMapping([
            'my_g' => ['c', 'd', 'g'],
            'my_e' => ['c', 'd', 'e'],
        ]);
        static::assertEquals('f', $assetJarAware->getAssetJarValue('my_e'));
    }
}
