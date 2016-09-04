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

        if (!in_array($field, $this->getAllFields())) {
            throw new Exception(sprintf(self::PROPERTY_NOTFOUND, $field));
        }

        switch ($key) {
        case "get":
            $return         = $this->{$field};
            break;
        case "set":
            $this->{$field} = $arguments[0];
            break;
        default:
            throw new Exception("Only Get and Set has Magic Method");
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
        $field = self::getPrimaryKey();
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
        $class      = get_called_class();
        if (!method_exists($class, "getPrefix")) {
            return $key;
        }

        if (!empty($class::getPrefix())) {
            $key    = sprintf("%s%s", $class::getPrefix(), ucfirst($key));
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

	/**
	 * @return array
	 */
	public function getAllFields()
    {
        $exclude = array(
            '_dependencyInjector', '_modelsManager', '_modelsMetaData',
            '_errorMessages', '_operationMade', '_dirtyState', '_transaction',
            '_uniqueKey', '_uniqueParams', '_uniqueTypes', '_skipped',
            '_related', '_snapshot',
        );

        return array_diff(array_keys(get_object_vars($this)), $exclude);
    }

	/**
	 * @param Model\Row $row
	 *
	 * @return NgModel
	 */
	public static function rowBuilder(Model\Row $row)
	{
		/** @var NgModel $class */
		$class	= get_called_class();
		$class	= new $class();
		foreach ($class::getPublicFields() as $field) {
			$func	= sprintf("set%s", ucfirst($field));
			$class->$func($row->readAttribute($field));
		}

		return $class;
	}
}
