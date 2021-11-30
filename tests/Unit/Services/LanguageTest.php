<?php

namespace Tests\Unit\Services;

use App\Http\Repositories\LanguageRepository;
use App\Http\Services\Language\LanguageService;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_language_service_get_list()
    {
        $lanRep = new LanguageRepository();
        $service = new LanguageService($lanRep);
        $result = $service->getList();
        $count = count($result);

        $this->assertTrue( $count === 3);
    }
}
