<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Services\MediaService;
use App\Config\Permissions;
use Exception;

class MediaController extends Controller
{
    private MediaService $service;

    public function __construct()
    {
        $this->service = new MediaService();
        AuthMiddleware::protect();
    }

    public function index(): void
    {
        AuthMiddleware::protectPermission(Permissions::MEDIA_VIEW);
        $media = $this->service->list();
        $this->view('media/index', compact('media'));
    }

    public function upload(): void
    {
        AuthMiddleware::protectPermission(Permissions::MEDIA_CREATE);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->service->upload($_FILES['file']);
                header('Location: /media');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }

        $this->view('media/upload');
    }

    public function delete(int $id): void
    {
        AuthMiddleware::protectPermission(Permissions::MEDIA_DELETE);

        try {
            $this->service->delete($id);
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /media');
        exit;
    }
            public function forceDelete(int $id): void
        {
            AuthMiddleware::protectPermission(Permissions::MEDIA_DELETE);

            $this->service->forceDelete($id);

            header('Location: /media');
            exit;
        }
        public function restore(int $id): void
{
    AuthMiddleware::protectPermission(Permissions::MEDIA_DELETE);

    try {
        $this->service->restore($id);
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    header('Location: /media');
    exit;
}


}
