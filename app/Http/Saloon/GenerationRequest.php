<?php

namespace App\Http\Saloon;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GenerationRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/generation';
    }
}
