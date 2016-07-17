<?php
/**
 * NgModelSoftDelete Interface
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
namespace Ng\Phalcon\Models\Interfaces;


/**
 * NgModelSoftDelete Interface
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
interface NgModelSoftDelete
{
    const DELETED_FIELD = "deleted";
    const DELETED_AT    = "deletedTime";
    const DELETED_BY    = "deletedBy";

    const VALUE_DEL     = 1;
    const VALUE_NOTDEL  = 0;

    /**
     * Check the model if it's implement soft delete or not
     *
     * @return bool
     */
    public static function useSoftDelete();

    /**
     * Return the deleted field from the model
     *
     * @return string
     */
    public static function getDeletedField();

    /**
     * Return the deleted by field from the model
     *
     * @return string
     */
    public static function getDeletedByField();

    /**
     * Return the deleted time field from the model
     *
     * @return string
     */
    public static function getDeletedTimeField();
}
