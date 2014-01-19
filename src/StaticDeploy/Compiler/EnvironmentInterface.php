<?php

/*
 * This file is part of StaticDeploy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StaticDeploy\Compiler;

interface EnvironmentInterface {
    public function getSourceDirectory();
    public function getTargetDirectory();
    public function getSourceFile();
}