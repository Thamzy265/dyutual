<?php
/**
 * Environment file loader.
 *
 * Reads the file `.env` in the root folder of the project. It puts each value
 * into an internal array. Use the function env() to read a value.
 *
 * The loader reads the file one time only. The include order does not matter.
 */

if (!class_exists('Env')) {

    class Env
    {
        /** @var array The values of the environment file. */
        protected static $values = array();

        /** @var bool The loader sets this flag to true after the first read. */
        protected static $loaded = false;

        /**
         * Reads the environment file.
         *
         * @param string|null $path The full path of the file. The default path
         *                          is the file `.env` in the root folder.
         */
        public static function load($path = null)
        {
            if (self::$loaded && $path === null) {
                return;
            }

            if ($path === null) {
                $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
            }

            self::$loaded = true;

            if (!is_readable($path)) {
                return;
            }

            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if ($lines === false) {
                return;
            }

            foreach ($lines as $line) {
                $line = trim($line);

                // Ignore an empty line and a comment line.
                if ($line === '' || $line[0] === '#' || $line[0] === ';') {
                    continue;
                }

                // Ignore a line that has no equals sign.
                $position = strpos($line, '=');
                if ($position === false) {
                    continue;
                }

                $key   = trim(substr($line, 0, $position));
                $value = trim(substr($line, $position + 1));

                if ($key === '') {
                    continue;
                }

                $value = self::clean($value);

                self::$values[$key] = $value;
            }
        }

        /**
         * Removes the quotation marks and the trailing comment from a value.
         *
         * @param  string $value The raw value.
         * @return string The clean value.
         */
        protected static function clean($value)
        {
            $length = strlen($value);

            // Keep the content of a quoted value without a change.
            if ($length >= 2) {
                $first = $value[0];
                $last  = $value[$length - 1];

                if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                    return substr($value, 1, $length - 2);
                }
            }

            // Remove a comment that comes after an unquoted value.
            $hash = strpos($value, ' #');
            if ($hash !== false) {
                $value = substr($value, 0, $hash);
            }

            return trim($value);
        }

        /**
         * Gives the value of one key.
         *
         * @param  string $key     The name of the key.
         * @param  mixed  $default The value to give if the key is absent.
         * @return mixed  The value of the key, or the default value.
         */
        public static function get($key, $default = null)
        {
            self::load();

            if (isset(self::$values[$key]) && self::$values[$key] !== '') {
                return self::$values[$key];
            }

            // Read the value from the server environment as an alternative.
            $fromServer = getenv($key);
            if ($fromServer !== false && $fromServer !== '') {
                return $fromServer;
            }

            return $default;
        }

        /**
         * Tests if a key has a value.
         *
         * @param  string $key The name of the key.
         * @return bool   True if the key has a value.
         */
        public static function has($key)
        {
            return self::get($key) !== null;
        }
    }
}

if (!function_exists('env')) {
    /**
     * Gives the value of one key of the environment file.
     *
     * @param  string $key     The name of the key.
     * @param  mixed  $default The value to give if the key is absent.
     * @return mixed  The value of the key, or the default value.
     */
    function env($key, $default = null)
    {
        return Env::get($key, $default);
    }
}
