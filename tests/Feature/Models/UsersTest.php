<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase, ModelHelper;

    /**
     * @return Model
     */
    protected function model(): Model
    {
        return new User();
    }

    /**
     * User has many posts.
     *
     * @return void
     */
    public function test_user_has_many_posts()
    {
        $count = rand(1, 10);

        $user = User::factory()
            ->has(Post::factory($count), 'posts')
            ->create();

        $this->assertCount($count, $user->posts);
        $this->assertTrue($user->posts->first() instanceof Post);
    }
}
