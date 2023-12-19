<?php

namespace App\View\Components;

use App\Models\Statement;
use App\Models\StatementFileType;
use App\Models\StatementFile;
use Illuminate\View\Component;

class StatementOrderExpertDecision extends Component
{

    private Statement $statement;

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
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $files = $this->statement
            ->files()
            ->whereHas('type', function ($query) {
                $query->where('code', '=', StatementFileType::DECIDE_EXPERT);
            })
            ->get();
        return view(
            'components.statement-order-expert-decision',
            [
                'statement' => $this->statement,
                'files' => $files
            ]
        );
    }
}
