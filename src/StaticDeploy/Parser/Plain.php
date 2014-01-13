<?php

namespace StaticDeploy\Parser;

/**
 * Plain parser. Will do nothing.
 *
 * @author Timon <dev@timonf.de>
 *
 * @api
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