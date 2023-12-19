<?php

namespace App\Http\Controllers;

class CaptchaMgekController extends Controller
{
    /**
     * @param string $config
     * @return string
     */
    public function getCaptcha(string $config = 'default'): string
    {
        return captcha_src($config);
    }
}
