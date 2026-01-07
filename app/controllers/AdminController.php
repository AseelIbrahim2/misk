<?php

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

    // -------------------------
    // Users CRUD
    // -------------------------
    public function users(): void
    {
        AuthMiddleware::protectPermission('manage_users');
        $users = $this->users->getAllUsers();
        $this->view('admin/users/index', compact('users'));
    }

    public function createUser(): void
    {
        AuthMiddleware::protectPermission('manage_users');
        $this->view('admin/users/create');
    }

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

    public function editUser(int $id): void
    {
        AuthMiddleware::protectPermission('manage_users');
        $user = $this->users->getUser($id);
        $this->view('admin/users/edit', compact('user'));
    }

    public function updateUser(int $id): void
    {
        AuthMiddleware::protectPermission('manage_users');
        $this->users->updateUser($id, $_POST);
        header('Location: /admin/users');
        exit;
    }

    public function deleteUser(int $id): void
    {
        AuthMiddleware::protectPermission('manage_users');
        $this->users->deleteUser($id);
        header('Location: /admin/users');
        exit;
    }
}
