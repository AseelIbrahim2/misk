<?php
namespace App\Services;

use App\Repositories\MediaRepository;
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
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Upload failed');
        }

        if (!in_array($file['type'], $this->allowedTypes, true)) {
            throw new Exception('Invalid file type');
        }

        if ($file['size'] > $this->maxSize) {
            throw new Exception('File too large');
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $uniqueName = uniqid('media_', true) . '.' . $extension;

    
        $documentRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
        $storagePath = 'uploads/media/'; 
        $fullPath = $documentRoot . '/' . $storagePath;

        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0777, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $fullPath . $uniqueName)) {
            throw new Exception('Failed to save file');
        }

      
        $mime = $file['type'];
        $type = str_starts_with($mime, 'image/') ? 'image' : ($mime === 'application/pdf' ? 'pdf' : 'other');

        $id = $this->repo->create([
            'name' => $uniqueName,
            'path' => $storagePath . $uniqueName,
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

       
        $filePath = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/' . ltrim($media['path'], '/');
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $deleted = $this->repo->softDelete($id);
        if (!$deleted) {
            throw new Exception('Failed to mark media as deleted in DB');
        }
    }
            public function forceDelete(int $id): void
        {
            $media = $this->repo->find($id);
            if (!$media) {
                throw new Exception('Media not found');
            }

            // delete file if exists
            $filePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $media['path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // HARD DELETE
            $this->repo->delete($id);
        }
            public function restore(int $id): void
            {
                $media = $this->repo->find($id);
                if (!$media) {
                    throw new Exception('Media not found');
                }

                if ($media['is_deleted'] == 0) {
                    throw new Exception('Media is not deleted');
                }

                $restored = $this->repo->restore($id);
                if (!$restored) {
                    throw new Exception('Failed to restore media');
                }
            }

}
