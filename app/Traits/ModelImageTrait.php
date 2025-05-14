<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ModelImageTrait
{
    public function getImage($request, $model): string
    {
        $photoPath = $this->uploadPhoto($request, 'photos', $model);
        $photoUrl = Storage::url($photoPath);

        return $photoUrl;
    }

    public function uploadPhoto(UploadedFile $file, string $folder, $model): string
    {
        $folderPath = $this->getFolderPath($model);

        if (!Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath);
        }

        $extension = $file->getClientOriginalExtension();
        $newFileName = $this->getNewFileName($model, $extension);

        $uploadedFile = $file->storeAs("public/{$folderPath}", $newFileName);
        return $uploadedFile;
    }

    private function getFolderPath($model): string
    {
        $modelName = $this->sanitizeFileName(strtolower(str_replace(' ', '-', $model->title ?? $model->name)));
        return "images/{$modelName}-{$model->id}";
    }

    private function getNewFileName($model, $extension): string
    {
        $baseName = $this->sanitizeFileName(strtolower(str_replace(' ', '-', $model->title ?? $model->name)));
        return time() . "{$baseName}.{$extension}";
    }

    private function sanitizeFileName($fileName): string
    {
        // Remove any characters that are not alphanumeric, hyphens, or underscores
        return preg_replace('/[^A-Za-z0-9\-_]/', '', $fileName);
    }
}
