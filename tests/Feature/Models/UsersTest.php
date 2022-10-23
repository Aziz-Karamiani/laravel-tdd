<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_insert_user()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', $user->toArray());
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
