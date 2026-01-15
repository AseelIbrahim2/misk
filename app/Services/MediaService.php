<?php
namespace App\Services;

use App\Repositories\MediaRepository;
use App\Core\Validator;
use Exception;

class MediaService
{
    private MediaRepository $repo;

    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    private int $maxSize = 2 * 1024 * 1024; // 2MB

    public function __construct()
    {
        $this->repo = new MediaRepository();
    }

    public function list(): array
    {
        return $this->repo->all();
    }

    public function upload(array $file): void
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $uniqueName = uniqid('media_', true) . '.' . $extension;

        /**
         * Resolve public path safely
         * If DOCUMENT_ROOT already points to /public, don't add it again
         */
        $documentRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

        if (str_ends_with($documentRoot, '/public')) {
            $publicPath = $documentRoot;
        } else {
            $publicPath = $documentRoot . '/public';
        }

        $storagePath = 'uploads/media/';
        $fullPath = $publicPath . '/' . $storagePath;

        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0777, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $fullPath . $uniqueName)) {
            throw new Exception('Failed to save file');
        }

        /* type mapping (ENUM safe) */
        $mime = $file['type'];

        if (str_starts_with($mime, 'image/')) {
            $type = 'image';
        } elseif ($mime === 'application/pdf') {
            $type = 'pdf';
        } else {
            $type = 'other';
        }

        $id = $this->repo->create([
            'name' => $uniqueName,
            'path' => $storagePath . $uniqueName, // DB always relative
            'type' => $type,
            'created' => date('Y-m-d H:i:s'),
            'updated' => date('Y-m-d H:i:s'),
            'is_deleted' => 0
        ]);

        if (!$id) {
            throw new Exception('Failed to insert media into DB');
        }


    }

    public function delete(int $id): void
    {
        $media = $this->repo->find($id);
        if (!$media) throw new Exception('Media not found');

        $filePath = $_SERVER['DOCUMENT_ROOT'] . $media['path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $this->repo->softDelete($id);
    }
}
