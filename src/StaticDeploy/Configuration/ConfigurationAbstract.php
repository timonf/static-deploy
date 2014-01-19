<?php

/*
 * This file is part of StaticDeploy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StaticDeploy\Configuration;

use StaticDeploy\Parser\ParserInterface;

abstract class ConfigurationAbstract
{
    /**
     * @var ParserInterface[]
     */
    protected $parsers;

    /**
     * @var array
     */
    protected $registeredExtensions = array();

    /**
     * @param ParserInterface $parser
     */
    public function addParser(ParserInterface $parser)
    {
        $extensions = $parser->getCapableExtension();
        if (!is_array($extensions)) {
            $extensions = array($extensions);
        }
        foreach($extensions as $extension) {
            $this->registeredExtensions[] = $extension;
        }
        $this->parsers[] = $parser;
    }

    /**
     * @param ParserInterface[] $parsers
     */
    public function addParsers(array $parsers)
    {
        foreach($parsers as $parser) {
            $this->addParser($parser);
        }
    }

    /**
     * @return ParserInterface[]
     */
    public function getParsers()
    {
        return $this->parsers;
    }

    /**
     * @param  string $fileExtension
     * @return null|ParserInterface
     */
    public function getParserForFileExtension($fileExtension)
    {
        if (!in_array($fileExtension, $this->registeredExtensions)) {
            // extension is not known, so let us find a plain parser
            $fileExtension = '';
        }

        foreach ($this->parsers as $parser) {
            $extensions = $parser->getCapableExtension();
            if (!is_array($extensions)) {
                $extensions = array($extensions);
            }
            foreach($extensions as $extension) {
                if ($extension == $fileExtension) {
                    return $parser;
                }
            }
        }

        return null;
    }
}