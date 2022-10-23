<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tag;

class TagsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $tag = Tag::factory()->create();

        $this->assertDatabaseHas('tags', $tag->toArray());
    }


    /**
     * Tags belongs to many posts.
     *
     * @return void
     */
    public function test_tag_belongs_to_many_posts()
    {
        $count = rand(1, 10);

        $tag = Tag::factory()->hasPosts($count)->create();

        $this->assertInstanceOf(Post::class, $tag->posts->first());
        $this->assertCount($count, $tag->posts);
    }
}
