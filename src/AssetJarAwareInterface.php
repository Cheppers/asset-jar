<?php

namespace Cheppers\AssetJar;

/**
 * Interface AssetJarAwareInterface.
 *
 * @package Cheppers\AssetJar
 */
interface AssetJarAwareInterface
{

    /**
     * @return bool
     */
    public function hasAssetJar();

    /**
     * @return \Cheppers\AssetJar\AssetJarInterface
     */
    public function getAssetJar();

    /**
     * @param \Cheppers\AssetJar\AssetJarInterface $asset_jar
     *
     * @return $this
     */
    public function setAssetJar(AssetJarInterface $asset_jar);

    /**
     * @param string $name
     * @param null $key_exists
     *
     * @return mixed
     */
    public function &getAssetJarValue($name, &$key_exists = null);

    /**
     * Set a value in the assetJar.
     *
     * @param string $name
     *   Asset name.
     * @param mixed $value
     *   The value to set.
     * @param bool $force
     *   (optional) If TRUE, the value is forced into the structure even if it
     *   requires the deletion of an already existing non-array parent value. If
     *   FALSE, PHP throws an error if trying to add into a value that is not an
     *   array. Defaults to FALSE.
     *
     * @return $this
     */
    public function setAssetJarValue($name, $value, $force = false);

    /**
     * @return array
     */
    public function getAssetJarMapping();

    /**
     * @param array $mapping
     *
     * @return $this
     */
    public function setAssetJarMapping(array $mapping);
}
