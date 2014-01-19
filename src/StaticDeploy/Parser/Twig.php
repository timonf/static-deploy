<?php

/*
 * This file is part of StaticDeploy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StaticDeploy\Parser;

use \Twig_Parser as TwigParser;
use \Twig_Environment as TwigEnvironment;
use \Twig_Loader_String as TwigLoader;
use StaticDeploy\Compiler\Environment;
use StaticDeploy\Compiler\HasEnvironmentInterface;
use StaticDeploy\Parser\Twig\Extension;

/**
 * Twig parser. Will parse Twig templates.
 *
 * @author Timon <dev@timonf.de>
 */
class Twig implements ParserInterface, HasEnvironmentInterface
{
    /**
     * @var \StaticDeploy\Compiler\Environment
     */
    protected $environment;

    /**
     * @param Environment $environment
     */
    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @inherit()
     */
    public function parse($resource)
    {
        $this->environment->setSourceFile($resource);

        $loader = new \Twig_Loader_Filesystem(array(
            $this->environment->getSourceDirectory()
        ));

        $resource = str_replace(
            $this->environment->getSourceDirectory(),
            '',
            $resource
        );

        $twig = new TwigEnvironment($loader);
        $twig->addExtension(new Extension($this->environment));

        $content = $twig->render($resource, array(
            'app' => $this->environment
        ));

        return $content;
    }

    /**
     * @inherit()
     */
    public function getCapableExtension()
    {
        return 'twig';
    }

    /**
     * @inherit()
     */
    public function getOutputFilename($filename)
    {
        return str_replace('.twig', '', $filename);
    }

}
