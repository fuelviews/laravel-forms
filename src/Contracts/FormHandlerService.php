<?php

namespace App\Contracts;

interface FormHandlerService
{
    public function handle(array $data): array;
}

