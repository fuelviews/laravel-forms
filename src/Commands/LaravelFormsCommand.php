<?php

namespace Fuelviews\LaravelForms\Commands;

use Illuminate\Console\Command;

class LaravelFormsCommand extends Command
{
    public $signature = 'laravel-forms';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
