<?php

namespace Tests\Feature\Controllers;

use App\Helpers\TextReadingDuration;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
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
    public function test_show_single_post_page()
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

    /**
     * A basic feature test for authenticated user can comment on post.
     */
    public function test_authenticated_user_can_comment_on_post()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $data = Comment::factory()
            ->state([
                'user_id' => $user->id,
                'commentable_id' => $post->id
            ])
            ->make()
            ->toArray();

        $this->actingAs($user);

        $response = $this->postJson(route('posts.comments.store', ['post' => $post->id]), ['text' => $data['text']]);

        $response->assertJson(['created' => true]);
        $this->assertDatabaseHas('comments', $data);
    }


    /**
     * A basic feature test for noun authenticated user can't comment on post.
     */
    public function test_noun_authenticated_user_can_not_comment_on_post()
    {
        $post = Post::factory()->create();

        $data = Comment::factory()
            ->state([
                'commentable_id' => $post->id
            ])
            ->make()
            ->toArray();

        $response = $this->postJson(route('posts.comments.store', ['post' => $post->id]), ['text' => $data['text']]);

        $response->assertUnauthorized();
        $this->assertDatabaseMissing('comments', $data);
    }

    /**
     * Comment text validation.
     */
    public function test_authenticated_user_can_comment_on_post_validation()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $data = Comment::factory()
            ->state([
                'user_id' => $user->id,
                'commentable_id' => $post->id,
                'text' => ''
            ])
            ->make()
            ->toArray();

        $this->actingAs($user);

        $response = $this->postJson(route('posts.comments.store', ['post' => $post->id]), ['text' => $data['text']]);

        $response->assertJsonValidationErrors(['text' => 'The text field is required.']);
    }


    /**
     * Post Reading Duration.
     */
    public function test_post_reading_duration()
    {
        $post = Post::factory()->create();
        $duration = new TextReadingDuration();
        $duration->setText($post->description);

        $this->assertEquals($duration->getTextReadingDurationPerSeconds(), $post->readingDuration);
        $this->assertEquals($duration->getTextReadingDurationPerMinutes(), $post->readingDuration / 60);
    }
}
