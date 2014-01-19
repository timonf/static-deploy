<?php

/*
 * This file is part of StaticDeploy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StaticDeploy\Parser;

/**
 * Plain parser. Will do nothing.
 *
 * @author Timon <dev@timonf.de>
 */
class Plain implements ParserInterface
{
    /**
     * @inherit()
     */
    public function parse($resource)
    {
        return file_get_contents($resource);
    }

    /**
     * @inherit()
     */
    public function getCapableExtension()
    {
        // so we can also match any unknown extension!
        return '';
    }

    /**
     * @inherit()
     */
    public function getOutputFilename($filename)
    {
        return $filename;
    }

}