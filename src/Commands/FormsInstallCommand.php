<?php

namespace Fuelviews\Forms\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class FormsInstallCommand extends Command
{
    protected $signature = 'forms:install {--force : Force the publishing of config files}';

    protected $description = 'Install packages and dependencies';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $packages = [
            'livewire/livewire' => '^3.5',
            'fuelviews/laravel-parameter-tagging' => '^0.0',
            'spatie/laravel-googletagmanager' => '^2.7',
            'fuelviews/laravel-layout-wrapper' => '^0.0',
        ];

        $requireCommand = 'composer require';
        foreach ($packages as $package => $version) {
            $requireCommand .= " {$package}:{$version}";
        }

        $this->info('Installing packages...');
        $this->runShellCommand($requireCommand);

        $publishCommand = "php artisan vendor:publish --provider='Spatie\GoogleTagManager\GoogleTagManagerServiceProvider' --tag='config'";
        if ($this->option('force')) {
            $publishCommand .= ' --force';
        }

        $this->runShellCommand($publishCommand);

        $this->info('Packages installed successfully.');
    }

    private function runShellCommand($command)
    {
        $process = Process::fromShellCommandline($command);

        $process->setTty(Process::isTtySupported());

        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
