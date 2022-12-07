<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadPostImageTest extends TestCase
{
    use RefreshDatabase;

    protected array $middleware = ['web', 'admin'];

    /**
     * Upload post image.
     *
     * @return void
     */
    public function test_upload_post_image()
    {
        $image = UploadedFile::fake()->image('post.jpg');
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->postJson('/upload', [
            'image' => $image,
        ]);

        $response
            ->assertOk()
            ->assertJson(['url' => public_path("storage/upload/posts/{$image->hashName()}")]);

        $this->assertFileExists(public_path("storage/upload/posts/{$image->hashName()}"));
        $this->assertEquals($this->middleware, request()->route()->middleware());
    }

    /**
     * Upload post image validation must be image.
     *
     * @return void
     */
    public function test_upload_post_image_must_be_image_validation()
    {
        $image = UploadedFile::fake()->create('image.txt');
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->postJson('/upload', ['image' => $image]);

        $response->assertJsonValidationErrors(['image' => 'The image must be an image.']);

        $this->assertFileDoesNotExist(public_path("storage/upload/posts/{$image->hashName()}"));
    }

    /**
     * Upload post image validation max file size is 350kb.
     *
     * @return void
     */
    public function test_upload_post_image_size_less_than_250kb_validation()
    {
        $image = UploadedFile::fake()->create('image.txt', 251);
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->postJson('/upload', ['image' => $image]);

        $response->assertJsonValidationErrors(['image' => 'The image must not be greater than 250 kilobytes.']);

        $this->assertFileDoesNotExist(public_path("storage/upload/posts/{$image->hashName()}"));
    }

    /**
     * Upload post image validation dimensions:min_width=100,min_height=200.
     *
     * @return void
     */
    public function test_upload_post_image_dimension_validation()
    {
        $image = UploadedFile::fake()->image('image.txt', 101, 201)->size(200);
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->postJson('/upload', ['image' => $image]);

        $response->assertJsonValidationErrors(['image' => 'The image has invalid image dimensions.']);

        $this->assertFileDoesNotExist(public_path("storage/upload/posts/{$image->hashName()}"));
    }
}
