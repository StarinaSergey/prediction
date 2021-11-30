<?php

namespace Database\Seeders;

use App\Models\Language;
use Database\Factories\LanguageFactory;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::factory()->create([
            'lang_tag' => 'ua',
            'name' => 'Українська'
            ]);
        Language::factory()->create([
            'lang_tag' => 'ru',
            'name' => 'Русский'
        ]);
        Language::factory()->create([
            'lang_tag' => 'us',
            'name' => 'English'
        ]);
    }
}
