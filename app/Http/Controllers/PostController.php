<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SeoSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $posts = Post::where('active', 1)
            ->orderBy('id', 'desc')
            ->paginate(20);
        SeoSetting::generateStaticPageSeo('news');
        return view('news.list', ['posts' => $posts]);
    }

    /**
     * Показать новость.
     *
     * @param string $slug
     * @return Application|Factory|View
     */
    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->first();

        event('postHasViewed', $post);

        if (!empty($post->seoSetting)) {
            SeoSetting::generateSEO($post->seoSetting, $post->name);
        }
        return view('news.item', ['post' => $post]);
    }


    public function apiIndex(): JsonResponse
    {
        $posts = Post::where('active', 1)
            ->orderBy('id', 'desc')
            ->cursorPaginate(5, ['*'], 'page', 2);

        return response()->json($posts);
    }


}
