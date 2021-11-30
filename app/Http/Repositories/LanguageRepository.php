<?php


namespace App\Http\Repositories;


use App\Models\Language;

class LanguageRepository
{
    public function getList()
    {
        return Language::all();
    }
}
