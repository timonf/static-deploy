<?php

/*
 * This file is part of StaticDeploy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StaticDeploy\Parser\Twig;

use StaticDeploy\Compiler\Environment;

/**
 * Extension to be loaded in Twig.
 * So you can access compiler Environment in Twig.
 *
 * @author Timon <dev@timonf.de>
 */
class Extension extends \Twig_Extension
{
    /**
     * @var \StaticDeploy\Compiler\Environment
     */
    protected $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @inherit()
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('base', array($this, 'getBasepath')),
            new \Twig_SimpleFunction('current', array($this, 'getCurrentPage')),
        );
    }

    /**
     * will return current parsed page
     * @return string
     */
    public function getCurrentPage()
    {
        $givenRelativeFile = str_replace(
            $this->environment->getSourceDirectory(),
            '',
            $this->environment->getSourceFile()
        );

        return str_replace('.twig', '', $givenRelativeFile);
    }

    /**
     * calculates the relative basepath
     * @param  string $suffix if a suffix given, it will return basepath + filename, otherwise just the basepath
     * @return string
     */
    public function getBasepath($suffix = null)
    {
        $relativeDirectory = '.';

        $givenRelativePath = dirname($this->getCurrentPage());

        if ($givenRelativePath === '/') {
            $givenRelativePath = '';
        }

        $depth = substr_count($givenRelativePath, '/');

        for ($i = 0; $i < $depth; $i++) {
            $relativeDirectory .= '/..';
        }

        if ($suffix) {
            return $relativeDirectory . '/' . $suffix;
        } else {
            return $relativeDirectory;
        }
    }

    public function getName()
    {
        return 'static_deploy_core';
    }
}