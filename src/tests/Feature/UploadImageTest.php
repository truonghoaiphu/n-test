<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class UploadImageTest extends TestCase
{
    use RefreshDatabase;

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_uploads_image_successfully()
    {
        // Create a fake item
        $item = Item::factory()->create();

        // Mock Cloudinary upload
        $mockCloudinaryResponse = Mockery::mock();
        $mockCloudinaryResponse->shouldReceive('getSecurePath')
            ->once()
            ->andReturn('https://fake-url.com/image.jpg');

        Cloudinary::shouldReceive('upload')
            ->once()
            ->andReturn($mockCloudinaryResponse);

        // Fake the file upload
        Storage::fake('images');
        $file = UploadedFile::fake()->image('photo.png', 600, 600);

        // Call the PATCH API endpoint with Basic Auth using 'post()' for file upload
        $response = $this->withHeaders([
            'Authorization' => 'Basic ' . base64_encode('admin:password')
        ])->post("/api/items/{$item->id}/upload-image", [
            'image' => $file,
        ]);

        // Assert response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Image uploaded successfully',
            'imgUrl' => 'https://fake-url.com/image.jpg',
        ]);

        // Ensure the image URL is updated in the database
        $item->refresh();  // Ensure the item instance is updated
        $this->assertEquals('https://fake-url.com/image.jpg', $item->imgUrl);
    }

    /** @test */
    public function it_returns_404_if_item_not_found()
    {
        // Call the API with a non-existing item ID and Basic Auth
        $response = $this->withHeaders([
            'Authorization' => 'Basic ' . base64_encode('admin:password')
        ])->postJson('/api/items/999/upload-image', [
            'image' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        // Assert response
        $response->assertStatus(404);
        $response->assertJson(['error' => 'Item not found']);
    }

    /** @test */
public function it_returns_400_if_invalid_image()
{
    // Create a fake item
    $item = Item::factory()->create();

    // Call the API with an invalid file
    $response = $this->withHeaders([
        'Authorization' => 'Basic ' . base64_encode('admin:password')
    ])->postJson("/api/items/{$item->id}/upload-image", [
        'image' => 'invalid-file',
    ]);

    // Assert response
    $response->assertStatus(400);
    $response->assertJson(['error' => 'Invalid image file']);
}

    /** @test */
    public function it_handles_exception_during_upload()
    {
        // Create a fake item
        $item = Item::factory()->create();

        // Mock Cloudinary to throw an exception
        Cloudinary::shouldReceive('upload')
            ->once()
            ->andThrow(new \Exception('Cloudinary error'));

        // Fake the file upload
        Storage::fake('images');
        $file = UploadedFile::fake()->image('photo.jpg', 600, 600);  // Set dimensions


        // Call the API with Basic Auth
        $response = $this->withHeaders([
            'Authorization' => 'Basic ' . base64_encode('admin:password')
        ])->postJson("/api/items/{$item->id}/upload-image", [
            'image' => $file,
        ]);

        // Assert response
        $response->assertStatus(500);
        $response->assertJson([
            'error' => 'Failed to upload image',
            'details' => 'Cloudinary error',
        ]);
    }
}
