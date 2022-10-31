<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Posts index method.
     *
     * @return void
     */
    public function test_posts_index_method()
    {
        Post::factory()->times(100)->create();

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertViewIs('posts.index')
            ->assertViewHas('posts', Post::latest()->paginate(15));
    }

    /**
     * Posts create method.
     *
     * @return void
     */
    public function test_posts_create_method()
    {
        Tag::factory()->count(20)->create();

        $this->get(route('posts.create'))
            ->assertOk()
            ->assertViewIs('posts.create')
            ->assertViewHas('tags', Tag::all());
    }

    /**
     * Posts edit method.
     *
     * @return void
     */
    public function test_posts_edit_method()
    {
        Tag::factory()->count(20)->create();
        $post = Post::factory()->create();

        $this->get(route('posts.edit', $post->id))
            ->assertOk()
            ->assertViewIs('posts.edit')
            ->assertViewHasAll([
                'tags' => Tag::all(),
                'post' => $post
            ]);
    }
}
