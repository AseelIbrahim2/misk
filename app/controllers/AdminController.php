<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\UserService;
use App\Middleware\AuthMiddleware;
use Exception;


class AdminController extends Controller
{
    // Service handling user management
    protected UserService $users;

    public function __construct()
    {
        $this->users = new UserService();
    }

    // Admin dashboard page
    public function dashboard(): void
    {
        AuthMiddleware::protectRole('admin'); // Only admins
        $username = $_SESSION['user']['username'];
        $this->view('admin/dashboard', compact('username'));
    }

    // -------------------------
    // Users CRUD
    // -------------------------

    // List all users
    public function users(): void
    {
        AuthMiddleware::protectPermission('manage_users'); // Permission check
        $users = $this->users->getAllUsers();
        $this->view('admin/users/index', compact('users'));
    }

    // Show create user form
    public function createUser(): void
    {
        AuthMiddleware::protectPermission('manage_users');
        $this->view('admin/users/create');
    }

    // Store new user
    public function storeUser(): void
    {
        AuthMiddleware::protectPermission('manage_users');
        try {
            $this->users->createUser($_POST);
            header('Location: /admin/users');
            exit;
        } catch (Exception $e) {
            $this->view('admin/users/create', ['error' => $e->getMessage()]);
        }
    }

    // Show edit form for a user
    public function editUser(int $id): void
    {
        AuthMiddleware::protectPermission('manage_users');
        $user = $this->users->getUser($id);
        $this->view('admin/users/edit', compact('user'));
    }

    // Update existing user
    public function updateUser(int $id): void
    {
        AuthMiddleware::protectPermission('manage_users');
        $this->users->updateUser($id, $_POST);
        header('Location: /admin/users');
        exit;
    }

    // Delete a user
    public function deleteUser(int $id): void
    {
        AuthMiddleware::protectPermission('manage_users');
        $this->users->deleteUser($id);
        header('Location: /admin/users');
        exit;
    }
}
