<?php

namespace Cheppers\AssetJar;

/**
 * Class AssetJar.
 *
 * Borrowed from Drupal 8 \Drupal\Component\Utility\NestedArray.
 *
 * @package Cheppers\AssetJar
 */
class AssetJar implements AssetJarInterface
{

    /**
     * @var array
     */
    protected $assets = [];

    /**
     * AssetJar constructor.
     *
     * @param array $assets
     *   Initial values.
     */
    public function __construct(array $assets = [])
    {
        $this->assets = $assets;
    }

    /**
     * {@inheritdoc}
     */
    public function &getValue(array $parents, &$key_exists = null)
    {
        $ref = &$this->assets;
        foreach ($parents as $parent) {
            if (is_array($ref) && array_key_exists($parent, $ref)) {
                $ref = &$ref[$parent];
            } else {
                $key_exists = false;
                $null = null;

                return $null;
            }
        }
        $key_exists = true;

        return $ref;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue(array $parents, $value, $force = false)
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
     * {@inheritdoc}
     */
    public function unsetValue(array $parents, &$key_existed = null)
    {
        $unset_key = array_pop($parents);
        $ref = &$this->getValue($parents, $key_existed);
        if ($key_existed && is_array($ref) && array_key_exists($unset_key, $ref)) {
            $key_existed = true;
            unset($ref[$unset_key]);
        } else {
            $key_existed = false;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function keyExists(array $parents)
    {
        // Although this function is similar to PHP's array_key_exists(), its
        // arguments should be consistent with getValue().
        $key_exists = null;
        $this->getValue($parents, $key_exists);

        return $key_exists;
    }
}
