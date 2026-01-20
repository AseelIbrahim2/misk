<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\MenuService;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Config\Permissions;
use Exception;

class MenusController extends Controller
{
    private MenuService $service;

    public function __construct()
    {
         AuthMiddleware::protectPermission(Permissions::MANAGE_MENUS);
        $this->service = new MenuService();
    }

    public function index(): void
    {
        $menus = $this->service->list();
        $this->view('admin/menus/index', compact('menus'));
    }

    public function create(): void
    {
        $this->view('admin/menus/create');
    }

    public function store(): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->create($_POST);
            $_SESSION['success'] = "Menu created successfully";
            header('Location: /menus');
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'][] = [$e->getMessage()];
            $_SESSION['old'] = $_POST;
            header('Location: /menus/create');
            exit;
        }
    }

    public function edit(int $id): void
    {
        $menu = $this->service->getById($id);
        if (!$menu) {
            $_SESSION['errors'][] = ['Menu not found'];
            header('Location: /menus');
            exit;
        }
        $this->view('admin/menus/edit', compact('menu'));
    }

    public function update(int $id): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->update($id, $_POST);
            $_SESSION['success'] = "Menu updated successfully";
            header('Location: /menus');
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'][] = [$e->getMessage()];
            $_SESSION['old'] = $_POST;
            header("Location: /menus/edit/{$id}");
            exit;
        }
    }

    public function delete(int $id): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->delete($id);
            $_SESSION['success'] = "Menu deleted successfully";
        } catch (Exception $e) {
            $_SESSION['errors'][] = [$e->getMessage()];
        }

        header('Location: /menus');
        exit;
    }
}
