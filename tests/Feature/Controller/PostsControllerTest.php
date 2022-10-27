<?php

namespace Tests\Feature\Controller;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
//        $this->withoutExceptionHandling();
        $post = Post::factory()->hasComments(Comment::factory())->create();

        $response = $this->get(route('posts.show', $post->id));

        $response->assertStatus(200);
        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertViewHasAll([
            'post' => $post,
            'comments' => $post->comments()->latest()->paginate(10)
        ]);
    }
}
