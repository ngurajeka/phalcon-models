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
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
namespace Ng\Phalcon\Models\Interfaces;


/**
 * Model Interface
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
interface NgModel
{
    const ID = "id";

    /**
     * Get the id value from the model
     *
     * @return int
     */
    public function getId();

    /**
     * Get the model prefix
     *
     * @return string
     */
    public static function getPrefix();

    /**
     * Transform a key / attribute / property with the model prefix
     *
     * @param string $key
     *
     * @return string
     */
    public static function transformKey($key);

    /**
     * Get primary key
     *
     * @return string
     */
    public static function getPrimaryKey();

    /**
     * Get public fields
     *
     * @return array
     */
    public static function getPublicFields();
}
