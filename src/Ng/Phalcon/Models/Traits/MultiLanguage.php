<?php
/**
 * MultiLanguage Traits
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


use Ng\Phalcon\Models\Interfaces\NgModelMultiLanguage;

/**
 * MultiLanguage Traits
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
trait MultiLanguage
{
    public static function useMultiLanguage()
    {
        return false;
    }

    public static function getLangField()
    {
        if (!self::useMultiLanguage()) {
            return null;
        }

        $class  = get_called_class();

        if (!method_exists($class, "transformKey")) {
            return NgModelMultiLanguage::LANG_FIELD;
        }

        return $class::transformKey(NgModelMultiLanguage::LANG_FIELD);
    }
}
