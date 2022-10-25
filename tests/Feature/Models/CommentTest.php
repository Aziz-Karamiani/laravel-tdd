<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_insert_comment()
    {
        $comment = Comment::factory()->create();

        $this->assertDatabaseHas('comments', $comment->toArray());
    }

    public function test_comment_belongs_to_post()
    {
        $comment = Comment::factory()->for(User::factory())->create();

        $this->assertTrue($comment->user instanceof User);
        $this->assertEquals($comment->user_id, $comment->user->id);
    }
}
