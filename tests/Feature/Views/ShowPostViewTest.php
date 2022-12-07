<?php

namespace Tests\Feature\Views;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowPostViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_post_show_view_authenticated_user_can_comment_on_post()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();
        $user = User::factory()->create();
        $comments = Comment::factory()->times(5)->create();

        $view = (string) $this->actingAs($user)
            ->view('posts.show', compact('post', 'comments'));

        $dom = new \DOMDocument('1.0', 'UTF-8');
        @$dom->loadHTML($view);

        $dom = new \DOMXPath($dom);
        $action = route('posts.show', $post->id);

        $this->assertCount(1, $dom->query("//form[@method='POST'][@action='$action']/textarea[@name='text']"));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_post_show_view_authenticated_user_can_not_comment_on_post()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();
        $comments = Comment::factory()->times(5)->create();

        $view = (string) $this->view('posts.show', compact('post', 'comments'));

        $dom = new \DOMDocument('1.0', 'UTF-8');
        @$dom->loadHTML($view);

        $dom = new \DOMXPath($dom);
        $action = route('posts.show', $post->id);

        $this->assertCount(0, $dom->query("//form[@method='POST'][@action='$action']/textarea[@name='text']"));
    }
}
