<?php

declare(strict_types=1);

namespace App\Http\Controllers\Definitions;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

final readonly class SubmitNewDefinitionController
{
    public function create(): Renderable
    {
        return view('definitions.create', [
            'regions' => Region::query()->pluck('name', 'id')
        ]);
    }
}
