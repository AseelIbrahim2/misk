<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\ApplicationService;
use App\Middleware\CsrfMiddleware;
use App\Services\MenuService;
use App\Services\SiteSettingService;
use Exception;

class AdmissionsPageController extends Controller
{
    private MenuService $menuService;
    private SiteSettingService $siteSettingsService;
    private ApplicationService $service;

    public function __construct()
    {
        $this->service = new ApplicationService();
        $this->menuService = new MenuService();
        $this->siteSettingsService = new SiteSettingService();
    }

    public function index(): void
    {
        $menus = $this->menuService->getMenuWithLinks();
        $siteSettings = $this->siteSettingsService->get();

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
            $this->service->store($_POST);
            $_SESSION['success'] = 'Application submitted successfully';
            unset($_SESSION['old']);
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true);
        }

        header('Location: /AdmissionsPage#apply-form');
        exit;
    }
}
