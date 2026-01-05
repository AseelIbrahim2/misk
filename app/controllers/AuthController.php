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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            try {
                // إنشاء المستخدم
                $user = $this->authService->register($username, $email, $password);

                // تسجيل الدخول تلقائي بعد التسجيل
                $this->authService->login($email, $password);

                // إعادة التوجيه للداشبورد
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
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    header('Location: /auth/login');
    exit;
}


    public function dashboard(): void
{
    if (!$this->authService->check()) {
        header('Location: /auth/login');
        exit;
    }

    $username = $_SESSION['username'] ?? '';
    $this->view('auth/dashboard', ['username' => $username]);
}

}
