<?php



class AdminController extends Controller
{
    public function dashboard(): void
    {
        // Only admin users
        AuthMiddleware::protectRole('admin');

        $username = $_SESSION['user']['username'];
        $this->view('admin/dashboard', compact('username'));
    }
}
