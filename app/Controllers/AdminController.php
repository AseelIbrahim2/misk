<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\UserService;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;

use App\Config\Permissions;

use Exception;

class AdminController extends Controller
{
    protected UserService $users;
    

    public function __construct()
    {
        $this->users = new UserService();
        
    }

    public function dashboard(): void
    {
        AuthMiddleware::protectRole('admin');
        $username = $_SESSION['user']['username'];
        $this->view('admin/dashboard', compact('username'));
    }

    public function users(): void
    {
        AuthMiddleware::protectPermission(Permissions::MANAGE_USERS);
        $users = $this->users->getAllUsers();
        $this->view('admin/users/index', compact('users'));
    }

   public function createUser(): void
{
    AuthMiddleware::protectPermission(Permissions::MANAGE_USERS);

    $roles = $this->users->getAllRoles();
    $this->view('admin/users/create', compact('roles'));
}



    public function storeUser(): void
    {
        CsrfMiddleware::protect();
        AuthMiddleware::protectPermission(Permissions::MANAGE_USERS);
        try {
            $this->users->createUser($_POST);
            header('Location: /admin/users');
            exit;
        } catch (Exception $e) {

            $_SESSION['errors'] = json_decode($e->getMessage(), true);
            $_SESSION['old'] = $_POST;
            header("Location: /admin/createUser");
            exit;
        }
    }




    public function updateUser(int $id): void
    {
        CsrfMiddleware::protect();
        AuthMiddleware::protectPermission(Permissions::MANAGE_USERS);
        try {
            $this->users->updateUser($id, $_POST);
            header('Location: /admin/users');
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true);
            $_SESSION['old'] = $_POST;
            header("Location: /admin/editUser/$id");
            exit;
        }
    }
    public function editUser(int $id): void
{
    AuthMiddleware::protectPermission(Permissions::MANAGE_USERS);

    $user = $this->users->getUser($id);
    $roles = $this->users->getAllRoles();
    $userRoleId = $this->users->getUserRoleId($id);

    $this->view('admin/users/edit', compact('user', 'roles', 'userRoleId'));
}



    public function deleteUser(int $id): void
    {
        CsrfMiddleware::protect();
        AuthMiddleware::protectPermission(Permissions::MANAGE_USERS);
        $this->users->deleteUser($id);
        header('Location: /admin/users');
        exit;
    }
    
    
}
