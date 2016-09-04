<?php
/**
 * NgModelMultiLanguage Interface
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
 * NgModelMultiLanguage Interface
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
interface NgModelMultiLanguage
{
    const LANG_FIELD  = "lang";

    // is this model want to implement multi language behaviour
    public static function useMultiLanguage();

    // get the field that is used as lang field
    public static function getLangField();
}
