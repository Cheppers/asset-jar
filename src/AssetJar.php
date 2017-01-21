<?php

namespace Cheppers\AssetJar;

class AssetJar implements AssetJarInterface
{
    use AssetJarTrait;

    /**
     * @param array $assets
     *   Initial values.
     */
    public function __construct(array $assets = [])
    {
        $this->assets = $assets;
    }
}
