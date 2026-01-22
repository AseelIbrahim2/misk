<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\ApplicationService;
use App\Middleware\CsrfMiddleware;
use App\Services\MenuService;
use App\Services\SiteSettingService;
use Exception;

class AdmissionsPageController  extends Controller
{

    private MenuService $menuService;
    private SiteSettingService $siteSettingsService ;
    private ApplicationService $service;

    public function __construct()
    {
        $this->service = new ApplicationService();
        $this->menuService = new MenuService();
        $this->siteSettingsService  = new SiteSettingService();
    }

    public function index(): void
    {
        $menus = $this->menuService->getMenuWithLinks();
        $siteSettings =  $this->siteSettingsService->get(); 

        $this->view('site/pages/admissions', compact(
            'siteSettings',
            'menus'
        ));
    }
    public function store(): void
{
    CsrfMiddleware::protect(); 

    $_SESSION['old'] = $_POST;

    try {

        $full_name = trim($_POST['full_name'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $age       = intval($_POST['age'] ?? 0);
        $message   = trim($_POST['message'] ?? '');

        $errors = [];

        if ($full_name === '') $errors['full_name'][] = 'Full Name is required';
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'][] = 'Valid Email is required';
        if ($age < 5 || $age > 18) $errors['age'][] = 'Age must be between 5 and 18';

        if (!empty($errors)) {
            throw new Exception(json_encode($errors));
        }

        $this->service->create([
            'full_name' => $full_name,
            'email'     => $email,
            'age'       => $age,
            'message'   => $message,
            'submitted' => date('Y-m-d H:i:s')
        ]);

        $_SESSION['success'] = 'Application submitted successfully';
        unset($_SESSION['old']); 

    } catch (Exception $e) {
        $_SESSION['errors'] = json_decode($e->getMessage(), true);
    }

  
    header('Location:    /AdmissionsPage' );
    exit;
}

}







       
    


