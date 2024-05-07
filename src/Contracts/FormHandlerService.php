<?php

namespace Fuelviews\LaravelForm\Contracts;

interface FormHandlerService
{
    public function handle(array $data): array;
}
