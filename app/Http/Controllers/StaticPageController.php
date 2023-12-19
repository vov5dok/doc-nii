<?php

namespace App\Http\Controllers;

use App\Models\SeoSetting;

class StaticPageController extends Controller
{
    public function contacts()
    {
        SeoSetting::generateStaticPageSeo('contacts');
        return view('static.contacts');
    }
}
