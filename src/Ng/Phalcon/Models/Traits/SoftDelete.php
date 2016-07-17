<?php
/**
 * SoftDelete Traits
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


use Ng\Phalcon\Models\Interfaces\NgModelSoftDelete;

use Phalcon\Mvc\Model\Behavior\SoftDelete as BehaviourSoftDelete;

/**
 * SoftDelete Traits
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
trait SoftDelete
{
    /**
     * Check the model if it's implement soft delete or not
     *
     * @return bool
     */
    public static function useSoftDelete()
    {
        return true;
    }

    /**
     * Return the deleted field from the model
     *
     * @return string
     */
    public static function getDeletedField()
    {
        if (!self::useSoftDelete()) {
            return "";
        }

        $field = NgModelSoftDelete::DELETED_FIELD;

        if (method_exists(get_called_class(), "transformKey")) {
            $field = self::transformKey($field);
        }

        if (!property_exists(get_called_class(), $field)) {
            return "";
        }

        return $field;
    }

    /**
     * Return the deleted by field from the model
     *
     * @return string
     */
    public static function getDeletedByField()
    {
        if (!self::useSoftDelete()) {
            return "";
        }

        $field = NgModelSoftDelete::DELETED_BY;

        if (method_exists(get_called_class(), "transformKey")) {
            $field = self::transformKey($field);
        }

        if (!property_exists(get_called_class(), $field)) {
            return "";
        }

        return $field;
    }

    /**
     * Return the deleted time field from the model
     *
     * @return string
     */
    public static function getDeletedTimeField()
    {
        if (!self::useSoftDelete()) {
            return "";
        }

        $field = NgModelSoftDelete::DELETED_AT;

        if (method_exists(get_called_class(), "transformKey")) {
            $field = self::transformKey($field);
        }

        if (!property_exists(get_called_class(), $field)) {
            return "";
        }

        return $field;
    }

    /**
     * Implement Soft Delete Behaviour by Phalcon
     *
     * @return void
     */
    protected function implementSoftDelete()
    {
        if (!method_exists($this, "addBehaviour")) {
            return;
        }

        if (empty($this::getDeletedField())) {
            return;
        }

        $opt = array(
            'field' => $this::getDeletedField(),
            'value' => NgModelSoftDelete::VALUE_DEL,
        );

        $this->addBehavior(new BehaviourSoftDelete($opt));
    }
}
