<?php
/**
 * Model Base
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
namespace Ng\Phalcon\Models;


use Ng\Phalcon\Models\Interfaces\NgModel as NgModelInterface;
use Ng\Phalcon\Models\Interfaces\NgModelHistorical;
use Ng\Phalcon\Models\Traits\Historical;
use Ng\Phalcon\Models\Traits\Hooks;
use Ng\Phalcon\Models\Traits\SoftDelete;

use Phalcon\Mvc\Model;

/**
 * Model Base
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
abstract class NgModel extends Model implements NgModelInterface, NgModelHistorical
{
    use Historical, Hooks, SoftDelete;

    const PROPERTY_NOTFOUND = "Property %s Was Not Found";

    public function __call($method, $arguments)
    {
        $key    = substr($method, 0, 3);
        $field  = lcfirst(substr($method, 3));
        $return = $this;

        if (!array_key_exists($field, get_object_vars($this))) {
            throw new Exception(sprintf(self::PROPERTY_NOTFOUND, $field));
        }

        switch ($key) {
            case "get":
                $return         = $this->{$field};
                break;
            case "set":
                $this->{$field} = $arguments[0];
                break;
        }

        return $return;
    }

    public function initialize()
    {
        if ($this::useSoftDelete() === true) {
            $this->implementSoftDelete();
        }
    }

    public function beforeValidationOnCreate()
    {
        $this->hookCreatedTime();
        $this->hookUpdatedTime();
        $this->hookDeleted();
    }

    public function beforeCreate()
    {
        $this->beforeValidationOnCreate();
    }

    public function beforeValidationOnUpdate()
    {
        $this->hookUpdatedTime();
    }

    public function beforeUpdate()
    {
        $this->beforeValidationOnUpdate();
    }

    public function getId()
    {
        $id     = $this::getIdField();
        $func   = sprintf("get%s", ucfirst($id));
        return $this->$func();
    }

    public static function getPrefix()
    {
        return "";
    }

    public static function getPrimaryKey()
    {
        return self::transformKey(NgModelInterface::ID);
    }

    // get public fields
    public static function getPublicFields()
    {
        return array(
            self::getIdField(), self::transformKey(NgModelInterface::CREATED_AT)
        );
    }

    // get created by field
    public static function getCreatedByField()
    {
        return self::transformKey(NgModelInterface::CREATED_BY);
    }

    // get created time field
    public static function getCreatedTimeField()
    {
        return self::transformKey(NgModelInterface::CREATED_AT);
    }

    // get updated by field
    public static function getUpdatedByField()
    {
        return self::transformKey(NgModelInterface::UPDATED_BY);
    }
    // get updated time field
    public static function getUpdatedTimeField()
    {
        return self::transformKey(NgModelInterface::UPDATED_AT);
    }

    // get deleted field
    public static function getDeletedField()
    {
        return self::transformKey(NgModelInterface::DELETED);
    }

    // get deleted by field
    public static function getDeletedByField()
    {
        return self::transformKey(NgModelInterface::DELETED_BY);
    }

    // get deleted time field
    public static function getDeletedTimeField()
    {
        return self::transformKey(NgModelInterface::DELETED_AT);
    }

    protected static function transformKey($key)
    {
        if (!empty(self::getPrefix()))  {
            $key    = sprintf("%s%s", self::getPrefix(), ucfirst($key));
        }

        return $key;
    }
}
