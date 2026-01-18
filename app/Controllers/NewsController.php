<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\NewsService;
use App\Services\MediaService;
use App\Middleware\AuthMiddleware;
use App\Config\Permissions;
use Exception;

class NewsController extends Controller
{
    private NewsService $service;
    private MediaService $mediaService;

    public function __construct()
    {
        $this->service = new NewsService();
        $this->mediaService = new MediaService();
        AuthMiddleware::protect();
    }

    public function index(): void
    {
        $news = $this->service->list();
        $this->view('admin/news/index', compact('news'));
    }

    public function create(): void
    {
        AuthMiddleware::protectPermission(Permissions::CREATE_NEWS);
        $media = $this->mediaService->list();
        $this->view('admin/news/create', compact('media'));
    }

    public function store(): void
    {
        try {
            $this->service->create($_POST);
            $_SESSION['success'] = "News created successfully!";
            header('Location: /news');
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true);
            $_SESSION['old'] = $_POST;
            header('Location: /news/create');
            exit;
        }
    }

    public function edit(int $id): void
    {
        AuthMiddleware::protectPermission(Permissions::EDIT_NEWS);
        $news = $this->service->findById($id);
        $media = $this->mediaService->list();

        if (!$news) {
            $_SESSION['error'] = "News not found!";
            header('Location: /news');
            exit;
        }

        $this->view('admin/news/edit', compact('news','media'));
    }

    public function update(int $id): void
    {
        try {
            $this->service->update($id, $_POST);
            $_SESSION['success'] = "News updated successfully!";
            header('Location: /news');
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true);
            $_SESSION['old'] = $_POST;
            header("Location: /news/edit/$id");
            exit;
        }
    }

    public function delete(int $id): void
    {
        try {
            $this->service->delete($id);
            $_SESSION['success'] = "News deleted successfully!";
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /news');
        exit;
    }
}
