<?php

namespace App\Http\Controllers;

use App\Events\StatementUpdated;
use App\Http\Requests\EmployeeDecideStatementRequest;
use App\Http\Requests\ExpertDecideStatementRequest;
use App\Http\Requests\RegisterStatementRequest;
use App\Http\Requests\StoreStatementRequest;
use App\Http\Requests\UpdateStatementRequest;
use App\Models\Message;
use App\Models\MoonshineUser;
use App\Models\Procedure;
use App\Models\Statement;
use App\Models\StatementFileType;
use App\Models\StatementStatus;
use App\Services\StatementService\Factories\DtoFactory;
use App\Services\StatementService\StatementService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class StatementController extends Controller
{
    public function __construct(
        private StatementService $statementService,
        private DtoFactory       $dtoFactory,
    )
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $statuses = StatementStatus::all(['name', 'code']);
        $isStatusesClear = !request()->has('pick-status');
        // Сохраняем выбранные значения фильтров в сессии
        session()->put(
            'pick-status',
            request()->input('pick-status') ?? array_column($statuses->toArray(), 'code')
        );

        $user = auth('moonshine')->user();
        $query = Statement::forUser($user);

        // Применяем фильтр по pick-status, если он есть
        if (session()->has('pick-status')) {
            Statement::filterByStatus($query, session('pick-status'));
        }

        if (request()->has('sort')) {
            session()->put('sort', request()->input('sort'));
        }

        // Применяем сортировку, если она есть
        if (session()->has('sort')) {
            Statement::sortBy($query, session('sort'));
        }

        $statements = $query->paginate(20);

        $filters = [
            'sort'        => session('sort') ?? '',
            'pick-status' => $isStatusesClear ? [] : session('pick-status')
        ];

        return view(
            'profile.statements.list',
            compact('statements', 'statuses', 'filters')
        );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $procedures = Procedure::all();
        return view('profile.statements.create', compact('procedures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStatementRequest $request
     * @return RedirectResponse
     */
    public function store(StoreStatementRequest $request): RedirectResponse
    {
        $this->statementService->create(
            $this->dtoFactory->statementCreateDto($request->validated()),
            auth('moonshine')->user()->id
        );

        return redirect()->route('statements.list');
    }

    /**
     * Display the specified resource.
     *
     * @param Statement $statement
     * @return Application|Factory|View
     */
    public function show(Statement $statement): View|Factory|Application
    {
        $statement->load(['expertOpinions.moonshineUser', 'files.type', 'messages', 'history.status']);
        return view('profile.statements.show', compact('statement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Statement $statement
     * @return Application|Factory|View
     */
    public function edit(Statement $statement): View|Factory|Application
    {
        $procedures = Procedure::all(['id', 'name', 'code']);
        $experts = MoonshineUser::getUsersWithRole('participant');
        return view(
            'profile.statements.edit',
            compact('statement', 'procedures', 'experts'),
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStatementRequest $request
     * @param Statement $statement
     * @return RedirectResponse
     */
    public function update(UpdateStatementRequest $request, Statement $statement): RedirectResponse
    {
//        TODO переписать легасный метод
        $statement->updateFromRequest($request);
//        TODO : тут чуть-чуть начал, дописать и потом вынести в сервис
        $user = auth('moonshine')->user();
        $statusId = match ($user->moonshineUserRole->id) {
            MoonshineUser::ROLE_ID_APPLICANT => StatementStatus::CHANGED_BY_APPLICANT,
            MoonshineUser::ROLE_ID_EMPLOYEE => StatementStatus::CHANGED_BY_EMPLOYEE,
            default => $statement->statement_status_id,
        };
        $statement->update([
            'name'                     => $request->name != null ? $request->name : '',
            'current_procedure_id'     => $request->current_procedure_id,
            'statement_status_id'      => $statusId,
            'moonshine_user_update_id' => $user->id,
        ]);
        collect($request->file)->each(function (UploadedFile $file) use ($statement) {
            $statement->files()->create([
                'file'                   => $file->storeAs('public/statement_files', $statement->id . '_' . $file->getClientOriginalName()),
                'name'                   => $file->getClientOriginalName() . '_' . $statement->id,
                'statement_file_type_id' => StatementFileType::firstWhere('code', StatementFileType::DEFAULT)->id
            ]);
        });
        event(new StatementUpdated($statement, auth('moonshine')->id()));
        return redirect()->route('statements.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Statement $statement
     * @return RedirectResponse
     */
    public function destroy(Statement $statement): RedirectResponse
    {
        $statement->experts()->detach();
        $statement->delete();

        return redirect()->route('statements.list');
    }

    public function register(RegisterStatementRequest $request, Statement $statement): RedirectResponse
    {
        $this->statementService->register(
            $statement,
            auth('moonshine')->id(),
            $this->dtoFactory->statementRegisterDto($request->validated())
        );

        return redirect()->route('statements.list');
    }

    public function complete(Statement $statement): RedirectResponse
    {
        $this->statementService->complete(
            $statement,
            auth('moonshine')->id()
        );

        return redirect()->route('statements.list');
    }

    public function decide(EmployeeDecideStatementRequest $request, Statement $statement): RedirectResponse
    {
        $this->statementService->decide(
            $statement,
            auth('moonshine')->id(),
            $request->file
        );

        return redirect()->route('statements.list');
    }

    public function decideExpert(ExpertDecideStatementRequest $request, Statement $statement): RedirectResponse
    {
        $this->statementService->decideExpert(
            $statement,
            auth('moonshine')->user()->id,
            $this->dtoFactory->statementDecideExpertDto($request->validated()),
        );

        return redirect()->route('statements.list');
    }

    public function addMessage(Request $request, Statement $statement): RedirectResponse
    {
        Message::addMessage($request->get('message'), $statement);
        return redirect()->route('statements.show', ['statement' => $statement]);
    }
}
