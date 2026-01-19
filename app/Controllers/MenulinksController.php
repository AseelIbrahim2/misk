<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\MenuLinkService;
use App\Services\MenuService;
use App\Middleware\CsrfMiddleware;
use App\Middleware\AuthMiddleware;
use Exception;

class MenuLinksController extends Controller
{
    private MenuLinkService $service;
    private MenuService $menuService;

    public function __construct()
    {
        AuthMiddleware::protectPermission('manage_menus'); 
        $this->service = new MenuLinkService();
        $this->menuService = new MenuService();
    }


    public function index(int $menuId): void
    {
        $menu = $this->menuService->getById($menuId);
        if (!$menu) {
            $_SESSION['errors'][] = ['Menu not found'];
            header('Location: /menus');
            exit;
        }

        $links = $this->service->getByMenu($menuId);
        $this->view('admin/menu_links/index', compact('menu', 'links'));
    }

  
    public function create(int $menuId): void
    {
        $menu = $this->menuService->getById($menuId);
        $parents = $this->service->getByMenu($menuId); 
        $this->view('admin/menu_links/create', compact('menu', 'parents'));
    }

 
    public function store(int $menuId): void
    {
        CsrfMiddleware::protect();
        try {
            $_POST['menu_id'] = $menuId;
            $this->service->create($_POST);
            $_SESSION['success'] = "Link created successfully";
            header("Location: /menu-links/index/$menuId");
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'][] = [$e->getMessage()];
            $_SESSION['old'] = $_POST;
            header("Location: /menu-links/create/$menuId");
            exit;
        }
    }

    public function edit(int $id): void
    {
        $link = $this->service->getById($id);
        if (!$link) {
            $_SESSION['errors'][] = ['Link not found'];
            header('Location: /menus');
            exit;
        }
        $menu = $this->menuService->getById($link['menu_id']);
        $parents = $this->service->getByMenu($link['menu_id']); // للـ parent dropdown
        $this->view('admin/menu_links/edit', compact('menu', 'link', 'parents'));
    }

    public function update(int $id): void
    {
        CsrfMiddleware::protect();
        try {
            $link = $this->service->getById($id);
            $_POST['menu_id'] = $link['menu_id'];
            $this->service->update($id, $_POST);
            $_SESSION['success'] = "Link updated successfully";
            header("Location: /menu-links/index/{$link['menu_id']}");
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'][] = [$e->getMessage()];
            $_SESSION['old'] = $_POST;
            header("Location: /menu-links/edit/$id");
            exit;
        }
    }

    public function delete(int $id): void
    {
        CsrfMiddleware::protect();
        $link = $this->service->getById($id);
        if ($link) {
            $this->service->delete($id);
            $_SESSION['success'] = "Link deleted successfully";
            header("Location: /menu-links/index/{$link['menu_id']}");
            exit;
        }
        $_SESSION['errors'][] = ['Link not found'];
        header('Location: /menus');
        exit;
    }
}
