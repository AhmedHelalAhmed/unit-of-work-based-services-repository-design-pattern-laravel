<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\CreatesApplication;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use DatabaseMigrations;
    use CreatesApplication;

    /**
     * @test
     */
    public function it_does_not_store_tag_but_links()
    {
        $faker = Factory::create();
        $response = $this->postJson(route('v1.tags.store'), [
            'title' => $faker->words(30, true),
            'links' => [
                [
                    'title' => 'github',
                    'url' => 'https://github.com/AhmedHelalAhmed'
                ],
                [
                    'title' => 'gist',
                    'url' => 'https://gist.github.com/AhmedHelalAhmed'
                ]
            ]
        ]);

        $response->assertOk();
        $this->assertDatabaseCount('tags', 0);
        $this->assertDatabaseCount('links', 2);
    }


    /**
     * @test
     */
    public function it_does_not_store_tag_nor_links()
    {
        $faker = Factory::create();
        $this->postJson(route('v2.tags.store'), [
            'title' => $faker->words(30, true),
            'links' => [
                [
                    'title' => 'github',
                    'url' => 'https://github.com/AhmedHelalAhmed'
                ],
                [
                    'title' => 'gist',
                    'url' => 'https://gist.github.com/AhmedHelalAhmed'
                ]
            ]
        ]);

        $this->assertDatabaseCount('tags', 0);
        $this->assertDatabaseCount('links', 0);
    }

    /**
     * @test
     */
    public function it_store_tag_nor_links()
    {
        $response = $this->postJson(route('v2.tags.store'), [
            'title' => 'ahmed',
            'links' => [
                [
                    'title' => 'github',
                    'url' => 'https://github.com/AhmedHelalAhmed'
                ],
                [
                    'title' => 'gist',
                    'url' => 'https://gist.github.com/AhmedHelalAhmed'
                ]
            ]
        ]);

        $response->assertOk();

        $this->assertDatabaseCount('tags', 1);
        $this->assertDatabaseCount('links', 2);
    }
}
