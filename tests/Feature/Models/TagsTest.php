<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagsTest extends TestCase
{
    use RefreshDatabase, ModelHelper;

    /**
     * @return Model
     */
    protected function model(): Model
    {
        return new Tag();
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
