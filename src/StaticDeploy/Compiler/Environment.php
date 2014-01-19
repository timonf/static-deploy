<?php

/*
 * This file is part of StaticDeploy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StaticDeploy\Compiler;

class Environment implements EnvironmentInterface
{
    /** @var string */
    protected $sourceDirectory;

    /** @var string */
    protected $targetDirectory;

    /** @var string */
    protected $sourceFile;

    public function setSourceDirectory($sourceDirectory)
    {
        $this->sourceDirectory = $sourceDirectory;
    }

    public function getSourceDirectory()
    {
        return $this->sourceDirectory;
    }

    public function setSourceFile($sourceFile)
    {
        $this->sourceFile = $sourceFile;
    }

    public function getSourceFile()
    {
        return $this->sourceFile;
    }

    public function getRenderTime()
    {
        return new \DateTime();
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function setTargetDirectory($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }
}