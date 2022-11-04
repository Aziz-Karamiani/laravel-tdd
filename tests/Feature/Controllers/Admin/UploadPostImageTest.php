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

    /**
     * Upload post image.
     *
     * @return void
     */
    public function test_upload_post_image()
    {
        $image = UploadedFile::fake()->image('post.jpg');
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->post('/upload', [
            'image' => $image,
        ]);

        $response
            ->assertOk()
            ->assertJson(['image' => 'post image uploaded successfully']);

        $this->assertFileExists(storage_path("app/public/upload/posts/{$image->hashName()}"));
    }
}
