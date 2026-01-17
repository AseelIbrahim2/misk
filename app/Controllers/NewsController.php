<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\NewsService;
use App\Middleware\AuthMiddleware;
use App\Config\Permissions;

class NewsController extends Controller
{
    private NewsService $service;

    public function __construct()
    {
        $this->service = new NewsService();
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
        $this->view('admin/news/create');
    }

    public function store(): void
    {
        try {
            $this->service->create($_POST);
            $_SESSION['success'] = "News created successfully!";
            header('Location: /news');
            exit;
        } catch (\Exception $e) {
            // Decode JSON errors from Validator
            $errors = json_decode($e->getMessage(), true);
            $_SESSION['errors'] = $errors ?: ['general' => [$e->getMessage()]];
            $_SESSION['old'] = $_POST;
            header('Location: /news/create');
            exit;
        }
    }

    public function edit(int $id): void
    {
        AuthMiddleware::protectPermission(Permissions::EDIT_NEWS);

        $news = $this->service->findById($id);

        if (!$news) {
            $_SESSION['error'] = "News not found!";
            header('Location: admin/news/edit');
            exit;
        }

        $this->view('admin/news/edit', compact('news'));
    }

    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /news/index');
            exit;
        }

        try {
            $this->service->update($id, $_POST);
            $_SESSION['success'] = "News updated successfully!";
            header('Location: /news');
            exit;
        } catch (\Exception $e) {
            $errors = json_decode($e->getMessage(), true);
            $_SESSION['errors'] = $errors ?: ['general' => [$e->getMessage()]];
            $_SESSION['old'] = $_POST;
            header("Location: /news/edit/$id");
            exit;
        }
    }

    public function delete(int $id): void
    {
        AuthMiddleware::protectPermission(Permissions::DELETE_NEWS);

        try {
            $this->service->delete($id);
            $_SESSION['success'] = "News deleted successfully!";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /news');
        exit;
    }
}
