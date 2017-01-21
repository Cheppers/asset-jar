<?php

namespace Cheppers\AssetJar;

/**
 * Interface AssetJarInterface.
 *
 * @package Cheppers\AssetJar
 */
interface AssetJarInterface
{

    /**
     * Retrieves a value from a nested array with variable depth.
     *
     * This helper function should be used when the depth of the array element
     * being retrieved may vary (that is, the number of parent keys is variable).
     * It is primarily used for form structures and renderable arrays.
     *
     * Without this helper function the only way to get a nested array value with
     * variable depth in one line would be using eval(), which should be avoided:
     *
     * @code
     * // Do not do this! Avoid eval().
     * // May also throw a PHP notice, if the variable array keys do not exist.
     * eval('$value = $array[\'' . implode("']['", $parents) . "'];");
     * @endcode
     *
     * Instead, use this helper function:
     * @code
     * $value = NestedArray::getValue($form, $parents);
     * @endcode
     *
     * A return value of NULL is ambiguous, and can mean either that the requested
     * key does not exist, or that the actual value is NULL. If it is required to
     * know whether the nested array key actually exists, pass a third argument
     * that is altered by reference:
     * @code
     * $key_exists = NULL;
     * $value = NestedArray::getValue($form, $parents, $key_exists);
     * if ($key_exists) {
     *   // Do something with $value.
     * }
     * @endcode
     *
     * However if the number of array parent keys is static, the value should
     * always be retrieved directly rather than calling this function.
     * For instance:
     * @code
     * $value = $form['signature_settings']['signature'];
     * @endcode
     *
     * @param array $parents
     *   An array of parent keys of the value, starting with the outermost key.
     * @param bool $keyExists
     *   (optional) If given, an already defined variable that is altered by
     *   reference.
     *
     * @return mixed
     *   The requested nested value. Possibly NULL if the value is NULL or not all
     *   nested parent keys exist. $key_exists is altered by reference and is a
     *   Boolean that indicates whether all nested parent keys exist (TRUE) or not
     *   (FALSE). This allows to distinguish between the two possibilities when
     *   NULL is returned.
     *
     * @see NestedArray::setValue()
     * @see NestedArray::unsetValue()
     */
    public function &getValue(array $parents, &$keyExists = null);

    /**
     * Sets a value in a nested array with variable depth.
     *
     * This helper function should be used when the depth of the array element you
     * are changing may vary (that is, the number of parent keys is variable). It
     * is primarily used for form structures and renderable arrays.
     *
     * Example:
     *
     * @code
     * // Assume you have a 'signature' element somewhere in a form. It might be:
     * $form['signature_settings']['signature'] = array(
     *   '#type' => 'text_format',
     *   '#title' => t('Signature'),
     * );
     * // Or, it might be further nested:
     * $form['signature_settings']['user']['signature'] = array(
     *   '#type' => 'text_format',
     *   '#title' => t('Signature'),
     * );
     * @endcode
     *
     * To deal with the situation, the code needs to figure out the route to the
     * element, given an array of parents that is either
     * @code array('signature_settings', 'signature') @endcode
     * in the first case or
     * @code array('signature_settings', 'user', 'signature') @endcode
     * in the second case.
     *
     * Without this helper function the only way to set the signature element in
     * one line would be using eval(), which should be avoided:
     * @code
     * // Do not do this! Avoid eval().
     * eval('$form[\'' . implode("']['", $parents) . '\'] = $element;');
     * @endcode
     *
     * Instead, use this helper function:
     * @code
     * NestedArray::setValue($form, $parents, $element);
     * @endcode
     *
     * However if the number of array parent keys is static, the value should
     * always be set directly rather than calling this function. For instance,
     * for the first example we could just do:
     * @code
     * $form['signature_settings']['signature'] = $element;
     * @endcode
     *
     * @param array $parents
     *   An array of parent keys, starting with the outermost key.
     * @param mixed $value
     *   The value to set.
     * @param bool $force
     *   (optional) If TRUE, the value is forced into the structure even if it
     *   requires the deletion of an already existing non-array parent value. If
     *   FALSE, PHP throws an error if trying to add into a value that is not an
     *   array. Defaults to FALSE.
     *
     * @return $this
     *
     * @see NestedArray::unsetValue()
     * @see NestedArray::getValue()
     */
    public function setValue(array $parents, $value, bool $force = false);

    /**
     * Unsets a value in a nested array with variable depth.
     *
     * This helper function should be used when the depth of the array element you
     * are changing may vary (that is, the number of parent keys is variable). It
     * is primarily used for form structures and renderable arrays.
     *
     * Example:
     *
     * @code
     * // Assume you have a 'signature' element somewhere in a form. It might be:
     * $form['signature_settings']['signature'] = array(
     *   '#type' => 'text_format',
     *   '#title' => t('Signature'),
     * );
     * // Or, it might be further nested:
     * $form['signature_settings']['user']['signature'] = array(
     *   '#type' => 'text_format',
     *   '#title' => t('Signature'),
     * );
     * @endcode
     *
     * To deal with the situation, the code needs to figure out the route to the
     * element, given an array of parents that is either
     * @code array('signature_settings', 'signature') @endcode
     * in the first case or
     * @code array('signature_settings', 'user', 'signature') @endcode
     * in the second case.
     *
     * Without this helper function the only way to unset the signature element in
     * one line would be using eval(), which should be avoided:
     * @code
     * // Do not do this! Avoid eval().
     * eval('unset($form[\'' . implode("']['", $parents) . '\']);');
     * @endcode
     *
     * Instead, use this helper function:
     * @code
     * NestedArray::unset_nested_value($form, $parents, $element);
     * @endcode
     *
     * However if the number of array parent keys is static, the value should
     * always be set directly rather than calling this function. For instance, for
     * the first example we could just do:
     * @code
     * unset($form['signature_settings']['signature']);
     * @endcode
     *
     * @param array $parents
     *   An array of parent keys, starting with the outermost key and including
     *   the key to be unset.
     * @param bool $keyExists
     *   (optional) If given, an already defined variable that is altered by
     *   reference.
     *
     * @return $this
     *
     * @see NestedArray::setValue()
     * @see NestedArray::getValue()
     */
    public function unsetValue(array $parents, &$keyExists = null);

    /**
     * Determines whether a nested array contains the requested keys.
     *
     * This helper function should be used when the depth of the array element to
     * be checked may vary (that is, the number of parent keys is variable). See
     * NestedArray::setValue() for details. It is primarily used for form
     * structures and renderable arrays.
     *
     * If it is required to also get the value of the checked nested key, use
     * NestedArray::getValue() instead.
     *
     * If the number of array parent keys is static, this helper function is
     * unnecessary and the following code can be used instead:
     *
     * @code
     * $value_exists = isset($form['signature_settings']['signature']);
     * $key_exists = array_key_exists('signature', $form['signature_settings']);
     * @endcode
     *
     * @param array $parents
     *   An array of parent keys of the value, starting with the outermost key.
     *
     * @return bool
     *   TRUE if all the parent keys exist, FALSE otherwise.
     *
     * @see NestedArray::getValue()
     */
    public function keyExists(array $parents): bool;
}
