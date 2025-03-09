<?php

namespace App\Contracts;

interface WithDrawalServerInterface
{
    public function generateCode(): string;
}
