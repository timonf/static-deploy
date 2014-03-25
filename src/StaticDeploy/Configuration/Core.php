<?php

/*
 * This file is part of StaticDeploy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StaticDeploy\Configuration;

use StaticDeploy\Parser\Plain;
use StaticDeploy\Parser\Twig;
use StaticDeploy\Parser\LessPhp;

/**
 * Loader for all internal plugins.
 *
 * You can build your custom Configuration loader using ConfigurationInterface
 * and ConfigurationAbstract.
 *
 * @author Timon <dev@timonf.de>
 */
class Core extends ConfigurationAbstract implements ConfigurationInterface
{
    /**
     * @inherit()
     */
    public function initializePlugins()
    {
        $this->addParsers(array(
            new Twig(),
            new Plain(),
            new LessPHP()
        ));
    }
}