<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase, ModelHelper;

    /**
     * @return Model
     */
    protected function model(): Model
    {
        return new Comment();
    }

    public function test_comment_belongs_to_post()
    {
        $comment = Comment::factory()->for(User::factory())->create();

        $this->assertTrue($comment->user instanceof User);
        $this->assertEquals($comment->user_id, $comment->user->id);
    }
}
