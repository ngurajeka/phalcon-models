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
abstract class NgModel extends Model implements NgModelInterface,
	NgModelSoftDelete, NgModelTimeStamp {
	use Hooks, SoftDelete, TimeStamp;

	const PROPERTY_NOTFOUND = "Property %s Was Not Found";

	/**
	 * Magic Method Set
	 *
	 * @param string $name	Field Name
	 * @param string $value	New Value of the Field
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @return NgModel
	 */
	public function __set($name, $value)
	{
		$field	= strtolower($name);
		if (!property_exists($this, $field)) {
			throw new \InvalidArgumentException("'$field' was not found");
		}

		$func	= "set" . ucfirst($field);
		if (method_exists($this, $func) &&
			is_callable(array($this, $func))) {
			$this->$func($value);
			return $this;
		}

		$this->{$field}	= $value;
		return $this;
	}

	/**
	 * Magic Method Get
	 *
	 * @param string $name	Field Name
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @return mixed
	 */
	public function __get($name)
	{
		$field	= strtolower($name);
		if (!property_exists($this, $field)) {
			throw new \InvalidArgumentException("'$field' was not found");
		}

		$func	= "get" . ucfirst($field);
		return (method_exists($this, $func) &&
			is_callable(array($this, $func)))
			? $this->$func() : $this->{$field};
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
	 * Set Primary Key Value
	 *
	 * @param int $id	Primary Key Value
	 *
	 * @throws \BadMethodCallException
	 * @throws \InvalidArgumentException
	 *
	 * @return NgModel
	 */
	public function setId($id)
	{
		$field	= self::getPrimaryKey();
		if ($this->{$field} !== null) {
			throw new \BadMethodCallException("'$field' has been set already");
		}

		if (!is_int($id) || $id < 1) {
			throw new \InvalidArgumentException("'$field' value is Invalid");
		}

		$this->{$field}	= $id;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @return int
	 */
	public function getId()
	{
		$field	= self::getPrimaryKey();
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
		$class		= get_called_class();
		if (!method_exists($class, "getPrefix")) {
			return $key;
		}

		if (!empty($class::getPrefix())) {
			$key	= sprintf("%s%s", $class::getPrefix(), ucfirst($key));
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
	 * Get All Fields excluding DI Property
	 *
	 * @return array
	 */
	public function getAllFields()
	{
		$exclude	= array(
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
		foreach ($class->getAllFields() as $field) {
			$func	= sprintf("set%s", ucfirst($field));
			$class->$func($row->readAttribute($field));
		}

		return $class;
	}
}
