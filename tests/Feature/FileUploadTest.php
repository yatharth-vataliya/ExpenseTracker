<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

arch('Upload controller should have method index and uploadData', function () {
    expect(\App\Http\Controllers\UploadDataController::class)->toHaveMethod('index');
    expect(\App\Http\Controllers\UploadDataController::class)->toHaveMethod('uploadData');
});

test('File upload page can render successfully', function () {

    $this->actingAs(User::factory()->create());

    $response = $this->get('/upload-index');

    $response->assertStatus(200);

    $response->assertSessionHasNoErrors();

    $response->assertSeeText('Select Files');

    $this->get('/upload-index')->assertViewIs('upload.upload-index');
});

test('file storing process', function () {
    $this->actingAs(User::factory()->create());

    $fileName = 'image.jpg';

    $response = $this->post('/upload-data', [
        'fileData' => UploadedFile::fake()->image($fileName),
        'fileName' => $fileName,
        'isFirstCall' => 'true',
    ]);
    $response->assertStatus(200);

    $response->assertJson([
        'uploadedFileName' => $fileName,
    ]);

    Storage::disk('public')->assertExists($fileName);

    $response = $this->post('/upload-data', [
        'fileData' => UploadedFile::fake()->image($fileName),
        'fileName' => $fileName,
        'isFirstCall' => 'false',
    ]);
    $response->assertStatus(200);

    $response->assertJson([
        'uploadedFileName' => $fileName,
    ]);

    Storage::disk('public')->delete($fileName);

    Storage::disk('public')->assertMissing($fileName);
});

test('giving same file for two times check code behaves correctly', function () {

    $this->actingAs(User::factory()->create());

    $fileName = 'image.jpg';

    $response = $this->post('/upload-data', [
        'fileData' => UploadedFile::fake()->image($fileName),
        'fileName' => $fileName,
        'isFirstCall' => 'true',
    ]);
    $response->assertStatus(200);

    $response->assertJson([
        'uploadedFileName' => $fileName,
    ]);

    Storage::disk('public')->assertExists($fileName);

    $response = $this->post('/upload-data', [
        'fileData' => UploadedFile::fake()->image($fileName),
        'fileName' => $fileName,
        'isFirstCall' => 'true',
    ]);
    $response->assertStatus(200);

    $response->assertJson([
        'uploadedFileName' => $fileName,
    ]);

    Storage::disk('public')->delete($fileName);

    Storage::disk('public')->assertMissing($fileName);
});

test('wrong parameter for file upload', function () {
    $this->actingAs(User::factory()->create());

    $fileName = 'image.jpg';

    $data = [
        'fileData' => UploadedFile::fake()->image($fileName),
        'fileName' => null,
        'isFirstCall' => 'true',
    ];

    $response = $this->post('/upload-data', $data);

    $response->assertStatus(400)->assertJsonStructure(['errors']);

    $response->assertJsonValidationErrors('fileName');

    Storage::disk('public')->assertMissing($fileName);
});
