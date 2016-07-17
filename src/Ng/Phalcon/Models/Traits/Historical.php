<?php
/**
 * Historical Traits
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


use Ng\Phalcon\Models\Interfaces\NgModel;
use Ng\Phalcon\Models\Interfaces\NgModelHistorical;

/**
 * Historical Traits
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
trait Historical
{
    public static function useHistorical()
    {
        return false;
    }

    public static function getIdField()
    {
        $class  = get_called_class();
        $id     = NgModel::ID;

        if (!method_exists($class, "transformKey")) {
            return $id;
        }

        if (self::useHistorical()) {
            return $class::transformKey(NgModelHistorical::REALID_FIELD);
        }

        return $class::transformKey($id);
    }

    public static function getCurrentField()
    {
        if (!self::useHistorical()) {
            return null;
        }

        $class  = get_called_class();
        $field  = NgModelHistorical::CURRENT_FIELD;

        if (method_exists($class, "transformKey")) {
            $field  = $class::transformKey($field);
        }

        return $field;
    }
}
