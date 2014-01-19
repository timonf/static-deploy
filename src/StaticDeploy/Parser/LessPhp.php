<?php

/*
 * This file is part of StaticDeploy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StaticDeploy\Parser;

use lessc as LessCompiler;

/**
 * Less parser. Will parse less(php) files.
 *
 * @author Timon <dev@timonf.de>
 */
class LessPhp implements ParserInterface
{
    /**
     * @inherit()
     */
    public function parse($resource)
    {
        $lessPhp = new LessCompiler();
        $content = $lessPhp->compileFile($resource);

        return $content;
    }

    /**
     * @inherit()
     */
    public function getCapableExtension()
    {
        return array(
            'less'
        );
    }

    /**
     * @inherit()
     */
    public function getOutputFilename($filename)
    {
        // we want to convert 'example.less' to 'example.css' and
        // 'example.css.less' to 'example.css'
        if (strpos($filename, '.css') > 0) {
            return str_replace('.less', '', $filename);
        } else {
            return str_replace('.less', '.css', $filename);
        }
    }

}
