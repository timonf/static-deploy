<?php

namespace StaticDeploy\Parser;

/**
 * Interface for all parsers
 *
 * @author Timon <dev@timonf.de>
 *
 * @api
 */
interface ParserInterface
{
    /**
     * Returns capable extension
     *
     * @return string|array
     */
    public function getCapableExtension();

    /**
     * Returns a capable filename for output (index.html.twig should return index.html)
     *
     * @param  string $filename
     * @return string capable filename
     */
    public function getOutputFilename($filename);

    /**
     * Will parse given file and returns the parsed/compiled content
     *
     * @param  string $resource filename to load
     * @return string
     */
    public function parse($resource);

}