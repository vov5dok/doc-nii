<?php

namespace App\Http\Controllers;

use App\Models\LegalManual;
use App\Models\Post;
use App\Models\SeoSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class LegalManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $legals = LegalManual::all('name', 'slug', 'sort')
            ->sortBy('sort');
        SeoSetting::generateStaticPageSeo('legal');
        return view('legal.list', ['legals' => $legals]);
    }

    /**
     *
     * @param string $slug
     * @return Application|Factory|View
     */
    public function show(string $slug)
    {
        $legalMenu = LegalManual::all('name', 'slug');

        $legalInfo = LegalManual::where('slug', $slug)
            ->first();

        if (!empty($legalInfo->seoSetting)) {
            SeoSetting::generateSEO($legalInfo->seoSetting, $legalInfo->name);
        }

        return view('legal.item', ['legal' => $legalInfo, 'menu' => $legalMenu]);
    }
}
