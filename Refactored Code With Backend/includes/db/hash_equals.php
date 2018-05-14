<?php

/**
 * Polyfill for PHP's hash_equals()
 *
 * The function behaves the same way as the original, including
 * error messages and return values.
 *
 * https://gist.github.com/christianfutterlieb/3cf85bc3fe16c70c0442
 *
 * @see http://php.net/manual/en/function.hash-equals.php
 */
namespace {
    /**
     *
     */
    if (!function_exists('hash_equals')) {

        /**
         * Timing attack safe string comparison
         *
         * Compares two strings using the same time whether they're equal or not.
         * This function should be used to mitigate timing attacks; for instance, when testing crypt() password hashes.
         *
         * @param string $known_string The string of known length to compare against
         * @param string $user_string The user-supplied string
         * @return boolean Returns TRUE when the two strings are equal, FALSE otherwise.
         */
        function hash_equals($known_string, $user_string)
        {
            if (func_num_args() !== 2) {
                // handle wrong parameter count as the native implentation
                trigger_error('hash_equals() expects exactly 2 parameters, ' . func_num_args() . ' given', E_USER_WARNING);
                return null;
            }
            if (is_string($known_string) !== true) {
                trigger_error('Expected known_string to be string, ' . gettype($known_string) . ' given', E_USER_WARNING);
                return false;
            }
            if (is_string($user_string) !== true) {
                trigger_error('Expected user_string to be string, ' . gettype($user_string) . ' given', E_USER_WARNING);
                return false;
            }
            if (\Cf\HashEqualsCompat\strlen($known_string) !== \Cf\HashEqualsCompat\strlen($user_string)) {
                return false;
            }

            $compare = ($known_string ^ $user_string);
            $result = 0;
            for ($j = 0; $j < \Cf\HashEqualsCompat\strlen($compare); $j++) {
                $result |= ord($compare[$j]);
            }
            return ($result === 0);
        }
    }
}

namespace Cf\HashEqualsCompat {
    if (!\function_exists('Cf\\HashEqualsCompat\\strlen')) {
        if (defined('MB_OVERLOAD_STRING') && (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING)) {
            function strlen($string)
            {
                return \mb_strlen($string, '8bit');
            }
        } else {
            function strlen($string)
            {
                return \strlen($string);
            }
        }
    }
}
