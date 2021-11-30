<?php

namespace Tests\Feature;

use Tests\TestCase;


class LanguageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_rout_get_list()
    {
        $response = $this->getJson('/api/language/get-list');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }
}
