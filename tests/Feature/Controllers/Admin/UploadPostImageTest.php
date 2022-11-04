<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        $response = $this->postJson('/upload', ['image' => $image,]);

        $response->assertJsonValidationErrors(['image' => 'The image must be an image.']);

        $this->assertFileDoesNotExist(public_path("storage/upload/posts/{$image->hashName()}"));
    }
}
