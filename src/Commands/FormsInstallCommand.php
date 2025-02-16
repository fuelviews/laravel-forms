<?php

namespace Fuelviews\Forms\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

class FormsInstallCommand extends Command
{
    protected $signature = 'forms:install';

    protected $description = 'Install required packages and dependencies';

    public function handle(): int
    {
        $packages = [
            'livewire/livewire' => '>=3.5',
            'fuelviews/laravel-sabhero-wrapper' => '>=0.0',
        ];

        $requireCommand = 'composer require';
        foreach ($packages as $package => $version) {
            $requireCommand .= " {$package}:\"{$version}\"";

        }

        $this->info('Installing required packages...');

        try {
            $this->runShellCommand($requireCommand);
            $this->info('✅ Packages installed successfully.');
        } catch (ProcessFailedException $e) {
            $this->error('❌ Failed to install packages: ' . $e->getMessage());
            return self::FAILURE;
        }

        $this->call('vendor:publish', ['--tag' => 'forms-config']);
        $this->info('✅ Forms package setup complete.');

        return self::SUCCESS;
    }

    private function runShellCommand($command): void
    {
        $process = Process::fromShellCommandline($command);

        if (Process::isTtySupported() && $this->getOutput()) {
            $process->setTty(true);
        }

        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
