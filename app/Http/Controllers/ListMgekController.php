<?php

namespace App\Http\Controllers;

use App\Models\ListMgek;
use App\Models\SeoSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListMgekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $documentsMgek = ListMgek::all()
            ->sortBy([['sort', 'asc'], ['id', 'desc']]);
        SeoSetting::generateStaticPageSeo('committee');
        return view(
            'committee.index',
            ['valid_list' => $documentsMgek->first(), 'archive' => $documentsMgek->slice(1)]
        );
    }
}
