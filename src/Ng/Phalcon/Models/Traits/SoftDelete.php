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


use Ng\Phalcon\Models\Interfaces\NgModel;

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
    public static function useSoftDelete()
    {
        return true;
    }

    protected function implementSoftDelete()
    {
        if (!method_exists($this, "addBehaviour")) {
            return;
        }

        if (!method_exists($this, "getDeletedField")) {
            return;
        }

        if (!empty($this::getDeletedField())) {
            return;
        }

        $opt = array(
            'field' => $this::getDeletedField(),
            'value' => NgModel::VALUE_DEL,
        );

        $this->addBehavior(new BehaviourSoftDelete($opt));
    }

}
