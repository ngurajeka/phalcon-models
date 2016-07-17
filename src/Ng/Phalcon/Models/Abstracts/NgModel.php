<?php
/**
 * NgModel Base
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
namespace Ng\Phalcon\Models\Abstracts;


use Ng\Phalcon\Models\Exception\Exception;
use Ng\Phalcon\Models\Interfaces\NgModel as NgModelInterface;
use Ng\Phalcon\Models\Interfaces\NgModelSoftDelete;
use Ng\Phalcon\Models\Interfaces\NgModelTimeStamp;
use Ng\Phalcon\Models\Traits\Hooks;
use Ng\Phalcon\Models\Traits\SoftDelete;
use Ng\Phalcon\Models\Traits\TimeStamp;

use Phalcon\Mvc\Model;

/**
 * NgModel Base
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
abstract class NgModel extends Model implements NgModelInterface, NgModelSoftDelete, NgModelTimeStamp
{
    use Hooks, SoftDelete, TimeStamp;

    const PROPERTY_NOTFOUND = "Property %s Was Not Found";

    /**
     * Magic method Call
     *
     * @param string $method    Method Called
     * @param array  $arguments Argument passed to when calling the method
     *
     * @throws Exception
     *
     * @return NgModel|mixed
     */
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

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function initialize()
    {
        if (self::useSoftDelete()) {
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

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function getId()
    {
        $field  = self::transformKey(self::getPrimaryKey());
        return (int) $this->{$field};
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public static function getPrefix()
    {
        return "";
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key Key that we wanted to transform
     *
     * @return string
     */
    public static function transformKey($key)
    {
        if (!empty(self::getPrefix())) {
            $key    = sprintf("%s%s", self::getPrefix(), ucfirst($key));
        }

        return $key;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public static function getPrimaryKey()
    {
        return self::transformKey(NgModelInterface::ID);
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public static function getPublicFields()
    {
        return array(self::getPrimaryKey());
    }
}
