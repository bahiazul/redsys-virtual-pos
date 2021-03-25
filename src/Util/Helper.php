<?php
/**
 * Redsys Virtual POS
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */

namespace nkm\RedsysVirtualPos\Util;

/**
 * Static helpers
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://opensource.org/licenses/MIT The MIT License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */
class Helper
{
    /**
     * Encodes data with base64url encoding
     *
     * @param  string $data The data to encode
     * @return string       The encoded data, as a string or FALSE on failure
     */
    public static function base64url_encode($data)
    {
        return strtr(base64_encode($data), '+/', '-_');
    }

    /**
     * Decodes data encoded with base64url
     *
     * @param  string $data The encoded data
     * @return string       Returns the original data or FALSE on failure.
     *                      The returned data may be binary.
     */
    public static function base64url_decode($data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    /**
     * Generate a keyed hash value using the HMAC method with the SHA-256 algo.
     *
     * @param  string $data Message to be hashed
     * @param  string $key  Shared secret key used for generating the HMAC
     *                      variant of the message digest
     * @return string       Returns the raw binary representation of the message
     *                      digest.
     */
    public static function hash_hmac_sha256($data, $key)
    {
        return hash_hmac('sha256', $data, $key, true);
    }

    /**
     * Encrypts plaintext with given parameters using the 3DES cipher
     *
     * @param  string $data The data that will be encrypted
     * @param  string $key  The key with which the data will be encrypted
     * @return string       Returns the encrypted data as a string or FALSE on
     *                      failure.
     */
    public static function encrypt_3DES($data, $key)
    {
        $iv = "\0\0\0\0\0\0\0\0";
        $padded_data = $data;

        if (strlen($padded_data) % 8) {
            $padded_data = str_pad($padded_data, strlen($padded_data) + 8 - strlen($padded_data) % 8, "\0");
        }

        return openssl_encrypt($padded_data, "DES-EDE3-CBC", $key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $iv);
    }

    /**
     * Converts any variable into a string without raising Errors, Notices or
     * getting weird results (like "Array")
     *
     * @param  mixed $var
     * @return string
     */
    public static function stringify($var)
    {
        if (is_array($var) || (is_object($var) && !method_exists($var, '__toString'))) {
            $var = '';
        } elseif (!is_string($var)) {
            $var = strval($var);
        }

        return $var;
    }
}
