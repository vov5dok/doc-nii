<?php

namespace App\View\Components;

use App\Models\MoonshineUser;
use App\Models\Statement;
use App\Models\StatementExpert;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class StatementOrderRegistration extends Component
{
    private Statement $statement;
    private Collection $statementExperts;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
        $this->statementExperts = MoonshineUser::whereHas('moonshineUserRole', function ($query) {
            $query->where('code', '=', 'participant');
        })->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view(
            'components.statement-order-registration',
            [
                'statement' => $this->statement,
                'statementExperts' => $this->statementExperts
            ]);
    }
}
