<?php
/**
 * NgModelTimeStamp Interface
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
 * NgModelTimeStamp Interface
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-models
 */
interface NgModelTimeStamp
{
    const CREATED_AT    = "createdTime";
    const CREATED_BY    = "createdBy";
    const UPDATED_AT    = "updatedTime";
    const UPDATED_BY    = "updatedBy";

    /**
     * Check the model if it's implement timestamp behaviour or not
     *
     * @return bool
     */
    public static function useTimestamp();

    /**
     * Get created by field
     *
     * @return string
     */
    public static function getCreatedByField();

    /**
     * Get created time field
     *
     * @return string
     */
    public static function getCreatedTimeField();

    /**
     * Get updated by field
     *
     * @return string
     */
    public static function getUpdatedByField();

    /**
     * Get updated time field
     *
     * @return string
     */
    public static function getUpdatedTimeField();
}
