<?php


namespace App\Http\Services\Language;


use App\Http\Repositories\LanguageRepository;
use App\Http\Contracts\Language\GetLanguageService;

class LanguageService implements GetLanguageService
{
    private LanguageRepository $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function getList()
    {
        return $this->languageRepository->getList();
    }
}
