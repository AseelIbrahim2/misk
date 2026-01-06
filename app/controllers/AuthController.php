<?php

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(): void
    {
        // Prevent logged-in users from accessing login
        $this->middleware('guest');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usernameOrEmail = $_POST['usernameOrEmail'] ?? '';
            $password = $_POST['password'] ?? '';

            try {
                $this->authService->login($usernameOrEmail, $password);
                header('Location: /auth/dashboard');
                exit;
            } catch (Exception $e) {
                $this->view('auth/login', ['error' => $e->getMessage()]);
                return;
            }
        }

        $this->view('auth/login');
    }

    public function register(): void
    {
        // Prevent logged-in users from accessing register
        $this->middleware('guest');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            try {
                $this->authService->register($username, $email, $password);
                $this->authService->login($email, $password);
                header('Location: /auth/dashboard');
                exit;
            } catch (Exception $e) {
                $this->view('auth/register', ['error' => $e->getMessage()]);
                return;
            }
        }

        $this->view('auth/register');
    }

    public function logout(): void
    {
        // Only logged-in users can logout
        $this->middleware('auth');

        $this->authService->logout();
        header('Location: /auth/login');
        exit;
    }

    public function dashboard(): void
    {
        // Only logged-in users can access dashboard
        $this->middleware('auth');

        $username = $_SESSION['user']['username'] ?? '';
        $this->view('auth/dashboard', ['username' => $username]);
    }
}
