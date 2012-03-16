<?php
class CArray {

    /**
     * Fill an array with a range of numbers.
     *
     *     // Fill an array with values 5, 10, 15, 20
     *     $values = CArray::range(5, 20);
     *
     * @param   integer  stepping
     * @param   integer  ending number
     * @return  array
     */
    public static function range($step = 10, $max = 100)
    {
        if ($step < 1)
            return array();

        $array = array();
        for ($i = $step; $i <= $max; $i += $step)
        {
            $array[$i] = $i;
        }

        return $array;
    }

    /**
     * Retrieve a single key from an array. If the key does not exist in the
     * array, the default value will be returned instead.
     *
     *     // Get the value "username" from $_POST, if it exists
     *     $username = CArray::get($_POST, 'username');
     *
     *     // Get the value "sorting" from $_GET, if it exists
     *     $sorting = CArray::get($_GET, 'sorting');
     *
     * @param   array   array to extract from
     * @param   string  key name
     * @param   mixed   default value
     * @return  mixed
     */
    public static function get($array, $key, $default = NULL)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    /**
     * Retrieves multiple keys from an array. If the key does not exist in the
     * array, the default value will be added instead.
     *
     *     // Get the values "username", "password" from $_POST
     *     $auth = CArray::extract($_POST, array('username', 'password'));
     *
     * @param   array   array to extract keys from
     * @param   array   list of key names
     * @param   mixed   default value
     * @return  array
     */
    public static function extract($array, array $keys, $default = NULL)
    {
        $found = array();
        foreach ($keys as $key)
        {
            $found[$key] = isset($array[$key]) ? $array[$key] : $default;
        }

        return $found;
    }

    /**
     * Retrieves muliple single-key values from a list of arrays.
     *
     *     // Get all of the "id" values from a result
     *     $ids = CArray::pluck($result, 'id');
     *
     * [!!] A list of arrays is an array that contains arrays, eg: array(array $a, array $b, array $c, ...)
     *
     * @param   array   list of arrays to check
     * @param   string  key to pluck
     * @return  array
     */
    public static function pluck($array, $key)
    {
        $values = array();

        foreach ($array as $row)
        {
            if (isset($row[$key]))
            {
                // Found a value in this row
                $values[] = $row[$key];
            }
        }

        return $values;
    }

    /**
     * Overwrites an array with values from input arrays.
     * Keys that do not exist in the first array will not be added!
     *
     *     $a1 = array('name' => 'john', 'mood' => 'happy', 'food' => 'bacon');
     *     $a2 = array('name' => 'jack', 'food' => 'tacos', 'drink' => 'beer');
     *
     *     // Overwrite the values of $a1 with $a2
     *     $array = CArray::overwrite($a1, $a2);
     *
     *     // The output of $array will now be:
     *     array('name' => 'jack', 'mood' => 'happy', 'food' => 'tacos')
     *
     * @param   array   master array
     * @param   array   input arrays that will overwrite existing values
     * @return  array
     */
    public static function overwrite($array1, $array2)
    {
        foreach (array_intersect_key($array2, $array1) as $key => $value)
        {
            $array1[$key] = $value;
        }

        if (func_num_args() > 2)
        {
            foreach (array_slice(func_get_args(), 2) as $array2)
            {
                foreach (array_intersect_key($array2, $array1) as $key => $value)
                {
                    $array1[$key] = $value;
                }
            }
        }

        return $array1;
    }

    /**
     * Convert a multi-dimensional array into a single-dimensional array.
     *
     *     $array = array('set' => array('one' => 'something'), 'two' => 'other');
     *
     *     // Flatten the array
     *     $array = CArray::flatten($array);
     *
     *     // The array will now be
     *     array('one' => 'something', 'two' => 'other');
     *
     * [!!] The keys of array values will be discarded.
     *
     * @param   array   array to flatten
     * @return  array
     * @since   3.0.6
     */
    public static function flatten($array)
    {
        $flat = array();
        foreach ($array as $key => $value)
        {
            if (is_array($value))
            {
                $flat += CArray::flatten($value);
            }
            else
            {
                $flat[$key] = $value;
            }
        }
        return $flat;
    }


}