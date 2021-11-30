<?php

namespace App\Http\Controllers;

use App\Http\Contracts\Language\GetLanguageService;

class LanguageController extends Controller
{
    private GetLanguageService $languageService;

    public function __construct(GetLanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function getList()
    {
        return $this->languageService->getList();
    }

}
