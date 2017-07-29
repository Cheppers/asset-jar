<?php

namespace Sweetchuck\AssetJar;

interface AssetJarAwareInterface
{

    public function hasAssetJar(): bool;

    public function getAssetJar(): ?AssetJarInterface;

    /**
     * @return $this
     */
    public function setAssetJar(?AssetJarInterface $assetJar);

    /**
     * @return mixed
     */
    public function &getAssetJarValue(string $name, &$keyExists = null);

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
    public function setAssetJarValue(string $name, $value, bool $force = false);

    public function getAssetJarMapping(): array;

    /**
     * @return $this
     */
    public function setAssetJarMapping(array $mapping);

    public function getAssetJarMap(string $name): ?array;

    /**
     * @return $this
     */
    public function setAssetJarMap(string $name, ?array $parents);
}
