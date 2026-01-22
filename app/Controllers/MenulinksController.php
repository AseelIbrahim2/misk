<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\MenuLinkService;
use App\Services\MenuService;
use App\Middleware\CsrfMiddleware;
use App\Middleware\AuthMiddleware;
use App\Config\Permissions;
use Exception;

class MenulinksController extends Controller
{
    private MenuLinkService $service;
    private MenuService $menuService;

    public function __construct()
    {
        AuthMiddleware::protectPermission(Permissions::MANAGE_MENU_LINKS);
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
            if (!$menu) {
                $_SESSION['errors'][] = ['Menu not found'];
                header('Location: /menus');
                exit;
            }

            $links = $this->service->getByMenu($menuId);

            $this->view('admin/menu_links/index', compact('menu', 'links'));
        }


    public function store(int $menuId): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->create($menuId, $_POST);
            $_SESSION['success'] = "Link created successfully";
            header("Location: /Menulinks/index/$menuId");
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'][] = [$e->getMessage()];
            $_SESSION['old'] = $_POST;
            header("Location: /Menulinks/index/$menuId");
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

          
            $links = $this->service->getByMenu($link['menu_id']);

            $this->view('admin/menu_links/index', compact('link', 'links'));
        }
        
    public function update(int $id): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->update($id, $_POST);
            $_SESSION['success'] = "Link updated successfully";
            header("Location: /Menulinks/index/" . $_POST['menu_id']);
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'][] = [$e->getMessage()];
            $_SESSION['old'] = $_POST;
            header("Location: /Menulinks/index/$id");
            exit;
        }
    }

    public function delete(int $id): void
    {
        CsrfMiddleware::protect();

        try {
            $menuId = $this->service->delete($id);
            $_SESSION['success'] = "Link deleted successfully";
        } catch (Exception $e) {
            $_SESSION['errors'][] = [$e->getMessage()];
            $menuId = $_POST['menu_id'] ?? 0;
        }

        header("Location: /Menulinks/index/$menuId");
        exit;
    }
}
