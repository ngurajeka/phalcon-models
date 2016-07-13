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
 * @link     https://github.com/ngurajeka/phalcon-models
 */
namespace Ng\Phalcon\Models\Interfaces;


/**
 * Model Interface
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
interface NgModelHistorical
{
    const REALID_FIELD  = "realId";
    const CURRENT_FIELD = "isCurrent";

    const CURRENT_ACTIVE    = 1;
    const CURRENT_NOTACTIVE = 0;

    // is this model want to implement historical behaviour
    public static function useHistorical();

    // get the field that is used as an Id
    public static function getIdField();

    // get current field (if useHistorical behaviour)
    public static function getCurrentField();
}
