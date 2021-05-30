<?php

namespace Tests\Unit\Models\Categories;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_many_children()
    {
        $category = factory(Category::class)->create();

        $category->childrens()->save(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $category->childrens->first());
    }

    public function test_it_can_fetch_only_parents()
    {
        $category = factory(Category::class)->create();

        $category->childrens()->save(
            factory(Category::class)->create()
        );

        $this->assertEquals(1, Category::parents()->count());
    }
}
