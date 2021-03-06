<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 12/12/15
 * Time: 17:17
 */

namespace core\Model;


class SimpleObject
{
    /**
     * Construct with an array if passed
     *
     * @param array $array
     */
    public function __construct($array = array())
    {
        $this->fromArray($array);
    }

    /**
     * Simple to array
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();

        foreach ($this as $property => $value) {
            $array[$property] = $value;
        }

        return $array;
    }

    /**
     * Return array with index to use with PDO
     *
     * @param array $properties
     * @return array
     */
    public function toArrayPDO($properties = array())
    {
        $array = array();

        foreach ($this as $property => $value) {
            if (!empty($properties)) {
                if (in_array($property, $properties)) {
                    $array[':' . $property] = $value;
                }
            } else {
                $array[':' . $property] = $value;
            }
        }

        return $array;
    }

    /**
     * Return an string to SET for an update
     *
     * @param array $properties
     * @return string
     */
    public function toSetUpdatePDO($properties = array())
    {
        $array = array();

        foreach ($this as $property => $value) {
            if (!empty($properties)) {
                if (in_array($property, $properties)) {
                    $array[] = $property . '=:' . $property;
                }
            } else {
                $array[] = $property . '=:' . $property;
            }
        }

        return implode(",\n", $array);
    }

    /**
     * Set array values to the object
     *
     * @param array $array
     */
    public function fromArray($array = array())
    {
        if (!empty($array)) {
            foreach ($array as $property => $value) {
                if (property_exists($this, $property)) {
                    $this->{$property} = $value;
                }
            }
        }
    }

}