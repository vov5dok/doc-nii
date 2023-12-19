<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\SeoSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Kharchenkomo\LaravelNiiozNews\Models\NiiNews;

class MainpageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory|Application
    {
        SeoSetting::generateStaticPageSeo('mainpage');
        $mainPageInfo = [
            'post' => [
                'info'  => NiiNews::latest('pub_date')->first(),
                'count' => NiiNews::count(),
            ],
            'documents' => [
                'info' => Document::all('name'),
            ],
        ];
        $newsInfo = collect([
            'last_post' => NiiNews::latest('pub_date')->first(),
            'count'     => NiiNews::count(),
        ]);

        return view('index', [
            'pageInfo' => $mainPageInfo,
            'newsInfo' => $newsInfo,
        ]);
    }
}
