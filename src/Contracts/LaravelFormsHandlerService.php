<?php

namespace Fuelviews\LaravelForms\Contracts;

interface LaravelFormsHandlerService
{
    public function handle(array $data): array;
}

