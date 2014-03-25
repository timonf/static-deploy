<?php

/*
 * This file is part of StaticDeploy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StaticDeploy\Compiler;

use StaticDeploy\Parser\ParserInterface;
use StaticDeploy\Parser\Plain;
use StaticDeploy\Parser\Twig;
use StaticDeploy\Reader\FileReader;
use StaticDeploy\Configuration\ConfigurationAbstract;

/**
 * Compiler class
 *
 * @author Timon <dev@timonf.de>
 */
class Compiler
{
    /** @var Environment */
    protected $environment;

    /** @var ConfigurationAbstract */
    protected $configuration;

    /**
     * @param Environment $environment
     * @param ConfigurationAbstract $configuration
     */
    public function __construct(Environment $environment, ConfigurationAbstract $configuration)
    {
        $this->environment = $environment;
        $this->configuration = $configuration;
    }

    /**
     * @return int status code
     */
    public function run()
    {
        $fileReader = new FileReader;
        $files = $fileReader->readDirectory($this->environment->getSourceDirectory());
        return $this->compile($files, $this->environment->getTargetDirectory());
    }

    /**
     * @param array|string $files filenames or single filename
     * @param string $outputDirectory
     * @return int status code
     */
    public function compile($files, $outputDirectory)
    {
        $resultCode = 0;

        // if $files a single string, convert it to an array
        if (!is_array($files)) {
            $files = array(
                $files => basename($files)
            );
        }

        foreach($files as $filename => $resource)
        {
            // if array is given, resource is a directory
            if (is_array($resource)) {

                $fullSubPath = $outputDirectory . DIRECTORY_SEPARATOR . $filename;

                // create the directory if it is not existing
                if (!file_exists($fullSubPath)) {
                    mkdir($fullSubPath);
                }

                $resultCode += $this->compile($resource, $fullSubPath);
            } else {
                $this->parse(
                    $resource,
                    $outputDirectory . DIRECTORY_SEPARATOR . $filename
                );
            }
        }

        return 0;
    }

    /**
     * Will parse a given file, and will write it to output directory
     *
     * @param string $resource filename of source file
     * @param string $output directory of destination
     * @throws \Exception
     */
    public function parse($resource, $output)
    {
        printf('file %s' . PHP_EOL, $resource);

        $pathinfo = pathinfo($resource);
        $extension = $pathinfo['extension'];

        $this->environment->setSourceFile($resource);

        $parser = $this->configuration->getParserForFileExtension($extension);

        if (!$parser instanceof ParserInterface) {
            throw new \Exception('No parser found. Have you initialized any plugins?');
        }

        if ($parser instanceof HasEnvironmentInterface) {
            $parser->setEnvironment($this->environment);
        }

        $content = $parser->parse($resource);
        $output  = $parser->getOutputFilename($output);
        file_put_contents($output, $content);
    }

}
