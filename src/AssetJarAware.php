<?php

namespace Cheppers\AssetJar;

/**
 * Trait AssetJarAware.
 *
 * @package Cheppers\AssetJar
 */
trait AssetJarAware
{

    /**
     * AssetJar.
     *
     * @var \Cheppers\AssetJar\AssetJarInterface
     */
    protected $assetJar = null;

    /**
     * Asset name and parents pairs.
     *
     * @var array
     */
    protected $assetJarMapping = [];

    /**
     * @see \Cheppers\AssetJar\AssetJarAwareInterface::hasAssetJar()
     *
     * @return bool
     */
    public function hasAssetJar()
    {
        return !empty($this->assetJar);
    }

    /**
     * @see \Cheppers\AssetJar\AssetJarAwareInterface::getAssetJar()
     *
     * @return \Cheppers\AssetJar\AssetJarInterface
     */
    public function getAssetJar()
    {
        return $this->assetJar;
    }

    /**
     * @see \Cheppers\AssetJar\AssetJarAwareInterface::setAssetJar()
     *
     * @param \Cheppers\AssetJar\AssetJarInterface $asset_jar
     *
     * @return $this
     */
    public function setAssetJar(AssetJarInterface $asset_jar)
    {
        $this->assetJar = $asset_jar;

        return $this;
    }

    /**
     * @see \Cheppers\AssetJar\AssetJarAwareInterface::getAssetJarValue()
     *
     * @param string $name
     * @param null $key_exists
     *
     * @return mixed|null
     */
    public function &getAssetJarValue($name, &$key_exists = null)
    {
        $null = null;
        if (!$this->hasAssetJar()) {
            $key_exists = false;

            return $null;
        }

        $parents = $this->getAssetJarMap($name);
        if ($parents === null) {
            $key_exists = false;

            return $null;
        }

        return $this
            ->getAssetJar()
            ->getValue($parents, $key_exists);
    }

    /**
     * @see \Cheppers\AssetJar\AssetJarAwareInterface::setAssetJarValue()
     *
     * @param string $name
     * @param mixed $value
     * @param bool $force
     *
     * @return $this
     */
    public function setAssetJarValue($name, $value, $force = false)
    {
        if (!$this->hasAssetJar()) {
            throw new \RuntimeException('@todo', 1);
        }

        $this
            ->getAssetJar()
            ->setValue($this->getAssetJarMap($name), $value, $force);

        return $this;
    }

    /**
     * @see \Cheppers\AssetJar\AssetJarAwareInterface::getAssetJarMapping()
     *
     * @return array
     */
    public function getAssetJarMapping()
    {
        return $this->assetJarMapping;
    }

    /**
     * @see \Cheppers\AssetJar\AssetJarAwareInterface::setAssetJarMapping()
     *
     * @param array $mapping
     *
     * @return $this
     */
    public function setAssetJarMapping(array $mapping)
    {
        $this->assetJarMapping = $mapping;

        return $this;
    }

    /**
     * @see \Cheppers\AssetJar\AssetJarAwareInterface::getAssetJarMap()
     *
     * @param string $name
     *
     * @return string[]|null
     *   Parents.
     */
    public function getAssetJarMap($name)
    {
        return isset($this->assetJarMapping[$name]) ? $this->assetJarMapping[$name] : null;
    }

    /**
     * @see \Cheppers\AssetJar\AssetJarAwareInterface::setAssetJarMap()
     *
     * @param string $name
     * @param string[] $parents
     *
     * @return $this
     */
    public function setAssetJarMap($name, array $parents)
    {
        $this->assetJarMapping[$name] = $parents;

        return $this;
    }
}
