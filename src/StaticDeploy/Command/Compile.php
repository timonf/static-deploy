<?php

/*
 * This file is part of StaticDeploy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StaticDeploy\Command;

use StaticDeploy\Compiler\Environment;
use StaticDeploy\Compiler\Compiler;
use StaticDeploy\Configuration\Core;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Interface for all parsers
 *
 * @author Timon <dev@timonf.de>
 */
class Compile extends Command
{
    /**
     * @var string
     */
    protected $baseDir = null;

    /**
     * @internal param string $basedir base directory of project
     */
    public function __construct($baseDir = null)
    {
        $this->baseDir = $baseDir;
        parent::__construct();
    }

    /**
     * @param  string $relativeDirectory
     * @return string
     */
    protected function getBaseDir($relativeDirectory)
    {
        if (null !== $this->baseDir) {
            return $this->baseDir . DIRECTORY_SEPARATOR . $relativeDirectory;
        }

        return $relativeDirectory;
    }

    /**
     * @inherit()
     */
    protected function configure()
    {
        $this
            ->setName('compile')
            ->setDescription('Compiles the source directory')
            ->addArgument(
                'source',
                InputArgument::OPTIONAL,
                'Source directory of source code.',
                $this->getBaseDir('src')
            )
            ->addArgument(
                'destination',
                InputArgument::OPTIONAL,
                'Target directory for parsed and compiled files.',
                $this->getBaseDir('output')
            );
    }

    /**
     * @inherit()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $compilerInput  = realpath($input->getArgument('source'));
        $compilerOutput = realpath($input->getArgument('destination'));

        $output->writeln(sprintf('input:  %s', $compilerInput));
        $output->writeln(sprintf('output  %s', $compilerOutput));

        $output->writeln('');

        $environment = new Environment();
        $environment->setSourceDirectory($compilerInput);
        $environment->setTargetDirectory($compilerOutput);

        // @todo: it would be better, to have a configurable class here...
        $configuration = new Core();
        $configuration->initializePlugins();

        $compiler = new Compiler($environment, $configuration);
        $compiler->run();

        $output->writeln('');
        $output->writeln('');
    }
}