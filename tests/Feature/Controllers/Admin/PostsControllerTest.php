<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $middleware = ['web', 'admin'];

    /**
     * Posts index method.
     *
     * @return void
     */
    public function test_posts_index_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        Post::factory()->times(100)->create();

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertViewIs('posts.index')
            ->assertViewHas('posts', Post::latest()->paginate(15));

        $this->assertEquals($this->middleware, request()->route()->middleware());
    }

    /**
     * Posts create method.
     *
     * @return void
     */
    public function test_posts_create_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        Tag::factory()->count(20)->create();

        $this->get(route('posts.create'))
            ->assertOk()
            ->assertViewIs('posts.create')
            ->assertViewHas('tags', Tag::all());

        $this->assertEquals($this->middleware, request()->route()->middleware());
    }

    /**
     * Posts edit method.
     *
     * @return void
     */
    public function test_posts_edit_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        Tag::factory()->count(20)->create();
        $post = Post::factory()->create();

        $this->get(route('posts.edit', $post->id))
            ->assertOk()
            ->assertViewIs('posts.edit')
            ->assertViewHasAll([
                'tags' => Tag::all(),
                'post' => $post
            ]);

        $this->assertEquals($this->middleware, request()->route()->middleware());
    }


    /**
     * Posts store method.
     *
     * @return void
     */
    public function test_posts_store_method()
    {
        $user = User::factory()->admin()->create();
        $tags = Tag::factory()->count(rand(1, 5))->create();

        $data = Post::factory()
            ->state(['user_id' => $user->id])
            ->make()
            ->toArray();

        $this->actingAs($user)
            ->post(route('posts.store'), array_merge(
                ['tags' => $tags->pluck('id')->toArray()], $data))
            ->assertRedirect()
            ->assertSessionHas('message', 'Post created successfully.');


        $this->assertDatabaseHas('posts', $data)
            ->assertEquals($tags->pluck('id')->toArray(), Post::where($data)->first()->tags()->pluck('id')->toArray());

        $this->assertEquals($this->middleware, request()->route()->middleware());
    }
}
