<?php

namespace App\View\Components;

use App\Models\Statement;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatementMessages extends Component
{

    public Statement $statement;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure
    {
        $messages = $this->statement
            ->messages()
            ->orderBy('date', 'asc')
            ->get();

        return view('components.statement-messages', compact('messages'));
    }
}
