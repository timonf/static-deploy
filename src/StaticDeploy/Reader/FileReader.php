<?php

/*
 * This file is part of StaticDeploy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StaticDeploy\Reader;

/**
 * FileReader will parse a whole directory structure
 *
 * @author Timon <dev@timonf.de>
 */
class FileReader
{
    public function read($resource)
    {
        if (is_dir($resource)) {
            return $this->readDirectory($resource, true);
        } else {
            return array();
        }
    }

    /**
     * Reading the directory recursive
     *
     * @see http://stackoverflow.com/questions/5172784/php-scandir-is-too-slow
     *
     * @param string $directory
     * @param bool $recursive
     * @thorws \Exception
     * @return bool|array
     */
    public function readDirectory($directory, $recursive = true)
    {
        if (is_dir($directory) === false) {
            return false;
        }

        try {
            $resource = opendir($directory);
            $contents = array();

            while (false !== ($item = readdir($resource)))
            {
                if (in_array($item, array('.', '..'))
                    || substr($item, 0, 1) == '_') {
                    continue;
                }

                $absoluteItem = $directory . DIRECTORY_SEPARATOR . $item;
                if ($recursive === true && is_dir($absoluteItem)) {
                    $contents[$item] = $this->readDirectory($absoluteItem, $recursive);
                } else {
                    $contents[$item] = $absoluteItem;
                }
            }
        } catch(\Exception $e) {
            return false;
        }

        return $contents;
    }
}