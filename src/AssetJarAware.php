<?php

namespace Cheppers\AssetJar;

trait AssetJarAware
{

    /**
     * @var \Cheppers\AssetJar\AssetJarInterface
     */
    protected $assetJar = null;

    /**
     * Asset name and parents pairs.
     *
     * @var array
     */
    protected $assetJarMapping = [];

    public function hasAssetJar(): bool
    {
        return isset($this->assetJar);
    }

    public function getAssetJar(): ?AssetJarInterface
    {
        return $this->assetJar;
    }

    /**
     * @return $this
     */
    public function setAssetJar(?AssetJarInterface $assetJar)
    {
        $this->assetJar = $assetJar;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function &getAssetJarValue(string $name, &$keyExists = null)
    {
        $null = null;
        if (!$this->hasAssetJar()) {
            $keyExists = false;

            return $null;
        }

        $parents = $this->getAssetJarMap($name);
        if ($parents === null) {
            $keyExists = false;

            return $null;
        }

        return $this
            ->getAssetJar()
            ->getValue($parents, $keyExists);
    }

    /**
     * @return $this
     */
    public function setAssetJarValue(string $name, $value, bool $force = false)
    {
        if (!$this->hasAssetJar()) {
            throw new \RuntimeException('@todo', 1);
        }

        $this
            ->getAssetJar()
            ->setValue($this->getAssetJarMap($name), $value, $force);

        return $this;
    }

    public function getAssetJarMapping(): array
    {
        return $this->assetJarMapping;
    }

    /**
     * @return $this
     */
    public function setAssetJarMapping(array $mapping)
    {
        $this->assetJarMapping = $mapping;

        return $this;
    }

    public function getAssetJarMap(string $name): ?array
    {
        return isset($this->assetJarMapping[$name]) ? $this->assetJarMapping[$name] : null;
    }

    /**
     * @return $this
     */
    public function setAssetJarMap(string $name, ?array $parents)
    {
        if ($parents === null) {
            unset($this->assetJarMapping[$name]);
        } else {
            $this->assetJarMapping[$name] = $parents;
        }

        return $this;
    }
}
