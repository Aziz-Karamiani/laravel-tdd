<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $comment = Comment::factory()->create();

        $this->assertDatabaseHas('comments', $comment->toArray());
    }
}
