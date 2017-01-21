<?php

namespace Cheppers\AssetJar;

/**
 * Borrowed from Drupal 8 \Drupal\Component\Utility\NestedArray.
 */
trait AssetJarTrait
{
    /**
     * @var array
     */
    protected $assets = [];

    public function &getValue(array $parents, &$keyExists = null)
    {
        $ref = &$this->assets;
        foreach ($parents as $parent) {
            if (is_array($ref) && array_key_exists($parent, $ref)) {
                $ref = &$ref[$parent];
            } else {
                $keyExists = false;
                $null = null;

                return $null;
            }
        }
        $keyExists = true;

        return $ref;
    }

    /**
     * @return $this
     */
    public function setValue(array $parents, $value, bool $force = false)
    {
        $ref = &$this->assets;
        foreach ($parents as $parent) {
            // PHP auto-creates container arrays and NULL entries without error if
            // $ref is NULL, but throws an error if $ref is set, but not an array.
            if ($force && isset($ref) && !is_array($ref)) {
                $ref = [];
            }

            $ref = &$ref[$parent];
        }

        $ref = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetValue(array $parents, &$keyExists = null)
    {
        $unsetKey = array_pop($parents);
        $ref = &$this->getValue($parents, $keyExists);
        if ($keyExists && is_array($ref) && array_key_exists($unsetKey, $ref)) {
            $keyExists = true;
            unset($ref[$unsetKey]);
        } else {
            $keyExists = false;
        }

        return $this;
    }

    public function keyExists(array $parents): bool
    {
        // Although this function is similar to PHP's array_key_exists(), its
        // arguments should be consistent with getValue().
        $keyExists = null;
        $this->getValue($parents, $keyExists);

        return $keyExists;
    }
}
