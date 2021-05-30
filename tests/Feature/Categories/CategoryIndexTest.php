<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryIndexTest extends TestCase
{
    public function test_it_returns_a_collection_of_categories()
    {
        $category = factory(Category::class)->create();

        $this->json('GET', 'api/categories')
            ->assertJsonFragment([
                'slug' => $category->slug
            ]);
    }
}
