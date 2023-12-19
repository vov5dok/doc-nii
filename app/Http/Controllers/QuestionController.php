<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\SeoSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $questions = Question::all();
        SeoSetting::generateStaticPageSeo('faq');
        return view('faq.list', ['questions' => $questions]);
    }
}
