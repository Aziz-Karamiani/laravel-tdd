<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_insert_post()
    {
        $post = Post::factory()->create();

        $this->assertDatabaseHas('posts', $post->toArray());
    }


    /**
     * Post belongs to only one user.
     */
    public function test_post_belongs_to_one_user()
    {
        $post = Post::factory()->for(User::factory())->create();

        $this->assertTrue($post->user instanceof User);
        $this->assertEquals($post->user_id, $post->user->id);
    }

    /**
     * Posts belongs to many Tags.
     *
     * @return void
     */
    public function test_posts_belongs_to_many_tags()
    {
        $count = rand(1, 10);

        $post = Post::factory()->hasTags($count)->create();

        $this->assertInstanceOf(Tag::class, $post->tags->first());
        $this->assertCount($count, $post->tags);
    }

    /**
     * Posts has many Comments.
     *
     * @return void
     */
    public function test_post_has_many_comments()
    {
        $count = rand(1, 10);

        $post = Post::factory()->hasComments($count)->create();

        $this->assertInstanceOf(Comment::class, $post->comments->first());
        $this->assertCount($count, $post->comments);
    }
}
