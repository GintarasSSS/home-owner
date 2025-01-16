<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Persons extends Component
{
    public function __construct(public LengthAwarePaginator $persons)
    {
    }

    public function render(): View|Closure|string
    {
        return view('components.persons');
    }
}
