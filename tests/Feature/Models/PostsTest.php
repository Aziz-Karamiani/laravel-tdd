<?php

namespace Tests\Feature\Models;

use App\Models\Post;
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


    public function test_post_belongs_to_one_user()
    {
        $post = Post::factory()->for(User::factory())->create();

        $this->assertTrue($post->user instanceof User);
        $this->assertEquals($post->user_id, $post->user->id);
    }
}
