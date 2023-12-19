<?php

namespace App\Http\Controllers;

use App\Models\SeoSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Kharchenkomo\LaravelNiiozNews\Models\NiiNews;

class NiiNewsController extends Controller
{
    public function index(): Factory|View|Application
    {
        $news = NiiNews::query()
            ->orderBy('id', 'desc')
            ->paginate(20);
        SeoSetting::generateStaticPageSeo('news');
        return view('nii_news.index', ['news' => $news]);
    }

    public function show(NiiNews $news): Factory|View|Application
    {
//        if (!empty($post->seoSetting)) {
//            SeoSetting::generateSEO($post->seoSetting, $post->name);
//        }

        return view('nii_news.show', [
            'news' => $news,
        ]);
    }
}
