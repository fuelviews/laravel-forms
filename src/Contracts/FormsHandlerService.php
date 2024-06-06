<?php

namespace Fuelviews\Forms\Contracts;

interface FormsHandlerService
{
    public function handle(array $data): array;
}
