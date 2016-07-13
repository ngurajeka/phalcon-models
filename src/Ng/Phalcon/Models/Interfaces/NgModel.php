<?php
/**
 * Model Interface
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
namespace Ng\Phalcon\Models\Interfaces;


/**
 * Model Interface
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
interface NgModel
{
    const ID            = "id";

    const CREATED_AT    = "createdTime";
    const CREATED_BY    = "createdBy";
    const UPDATED_AT    = "updatedTime";
    const UPDATED_BY    = "updatedBy";
    const DELETED       = "deleted";
    const DELETED_AT    = "deletedTime";
    const DELETED_BY    = "deletedBy";

    const VALUE_DEL     = 1;
    const VALUE_NOTDEL  = 0;

    // get the id value from the model
    public function getId();

    // is this model want to implement soft delete behaviour
    public static function useSoftDelete();

    // is this model using prefix
    public static function getPrefix();

    // get primary key
    public static function getPrimaryKey();

    // get public fields
    public static function getPublicFields();

    // get created by field
    public static function getCreatedByField();

    // get created time field
    public static function getCreatedTimeField();

    // get updated by field
    public static function getUpdatedByField();

    // get updated time field
    public static function getUpdatedTimeField();

    // get deleted field
    public static function getDeletedField();

    // get deleted by field
    public static function getDeletedByField();

    // get deleted time field
    public static function getDeletedTimeField();
}
