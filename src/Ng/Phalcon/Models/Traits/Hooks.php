<?php
/**
 * Hooks Traits
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

/**
 * Hooks Traits
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
trait Hooks
{
    protected function hookCreatedTime()
    {
        // check created time, and set to now if empty
        if (!method_exists($this, "getCreatedTime")) {
            return;
        }

        // check if field is exist
        $field = $this::getCreatedTimeField();
        if (!is_string($field) OR empty($field)) {
            return;
        }

        if (!property_exists($this, $field)) {
            return;
        }

        if (is_null($this->{$field})) {
            return;
        }

        $this->{$field} = date("Y-m-d H:i:s");
    }

    protected function hookUpdatedTime()
    {
        // check updated time, and set to now if empty
        if (!method_exists($this, "getUpdatedTimeField")) {
            return;
        }

        // check if field is exist
        $field = $this::getUpdatedTimeField();
        if (!is_string($field) OR empty($field)) {
            return;
        }

        if (!property_exists($this, $field)) {
            return;
        }

        if (is_null($this->{$field})) {
            return;
        }

        $this->{$field} = date("Y-m-d H:i:s");
    }

    protected function hookDeleted()
    {
        // check deleted field, and set to 0 if empty
        if (!method_exists($this, "getDeletedField")) {
            return;
        }

        // check if field is exist
        $field = $this::getDeletedField();
        if (!is_string($field) OR empty($field)) {
            return;
        }

        if (!property_exists($this, $field)) {
            return;
        }

        if (is_null($this->{$field})) {
            return;
        }

        $this->{$field} = NgModel::VALUE_NOTDEL;
    }
}
