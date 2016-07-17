<?php
/**
 * Timestamp Traits
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
namespace Ng\Phalcon\Models\Traits;


use Ng\Phalcon\Models\Interfaces\NgModelTimeStamp;

/**
 * Timestamp Traits
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
trait TimeStamp
{
    /**
     * Check the model if it's implement timestamp behaviour or not
     *
     * @return bool
     */
    public static function useTimestamp()
    {
        return true;
    }

    /**
     * Get created by field
     *
     * @return string
     */
    public static function getCreatedByField()
    {
        if (!self::useTimestamp()) {
            return "";
        }

        $field  = NgModelTimeStamp::CREATED_BY;
        $class  = get_called_class();
        if (method_exists($class, "transformKey")) {
            $field = $class::transformKey($field);
        }

        if (!property_exists($class, $field)) {
            return "";
        }

        return $field;
    }

    /**
     * Get created time field
     *
     * @return string
     */
    public static function getCreatedTimeField()
    {
        if (!self::useTimestamp()) {
            return "";
        }

        $field  = NgModelTimeStamp::CREATED_AT;
        $class  = get_called_class();
        if (method_exists($class, "transformKey")) {
            $field = $class::transformKey($field);
        }

        if (!property_exists($class, $field)) {
            return "";
        }

        return $field;
    }

    /**
     * Get updated by field
     *
     * @return string
     */
    public static function getUpdatedByField()
    {
        if (!self::useTimestamp()) {
            return "";
        }

        $field  = NgModelTimeStamp::UPDATED_BY;
        $class  = get_called_class();
        if (method_exists($class, "transformKey")) {
            $field = $class::transformKey($field);
        }

        if (!property_exists($class, $field)) {
            return "";
        }

        return $field;
    }

    /**
     * Get updated time field
     *
     * @return string
     */
    public static function getUpdatedTimeField()
    {
        if (!self::useTimestamp()) {
            return "";
        }

        $field  = NgModelTimeStamp::UPDATED_AT;
        $class  = get_called_class();
        if (method_exists($class, "transformKey")) {
            $field = $class::transformKey($field);
        }

        if (!property_exists($class, $field)) {
            return "";
        }

        return $field;
    }
}
