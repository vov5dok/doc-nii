<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\MeetingSchedule;
use App\Models\SeoSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ActionsPageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $meetingsInfo = MeetingSchedule::getActionPageInfo();
        SeoSetting::generateStaticPageSeo('actions');
        $data = [
            'documents' => Document::all(),
            'meetings' => $meetingsInfo
        ];
        return view('actions.page', $data);
    }
}
