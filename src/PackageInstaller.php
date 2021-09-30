<?php

namespace DavidPeach\Manuscript;

use DavidPeach\Manuscript\Playground\Playground;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PackageInstaller
{
    public static function install(Package $package, Playground $playground): void
    {
        ComposerFileManager::add(
            $playground->getPath() . '/composer.json',
            ['repositories' => [
                [
                    'type' => 'path',
                    'url'  =>  realpath($package->getPath()),
                    'options' => [
                        'symlink' => true,
                    ],
                ]
            ]]
        );

        $process = Process::fromShellCommandline(
            'cd ' . $playground->getPath() . ' && composer require ' . $package->getName()
        );

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
