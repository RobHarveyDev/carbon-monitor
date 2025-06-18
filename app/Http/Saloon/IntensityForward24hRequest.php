<?php

namespace App\Http\Saloon;

use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class IntensityForward24hRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public Carbon $from) {}

    public function resolveEndpoint(): string
    {
        return '/intensity/' . $this->from->format('Y-m-d\TH:iZ') . '/fw24h';
    }
}

