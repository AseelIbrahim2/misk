<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\SiteSettingService;
use App\Services\MediaService;
use App\Middleware\CsrfMiddleware;
use App\Middleware\AuthMiddleware;
use App\Config\Permissions;
use Exception;

class SiteSettingController extends Controller
{
    private SiteSettingService $service;
    private MediaService $mediaService;

    public function __construct()
    {
        AuthMiddleware::protectPermission(Permissions::MANAGE_SITE_SETTINGS);
        $this->service = new SiteSettingService();
        $this->mediaService = new MediaService();
    }

    public function index(): void
    {
        $setting = $this->service->get();
        $media   = $this->mediaService->list(); 
        $this->view('admin/site_settings/index', compact('setting', 'media'));
    }

    public function update(): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->update($_POST);
            $_SESSION['success'] = "Site settings updated successfully";
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true);
            $_SESSION['old'] = $_POST;
        }

        header('Location: /sitesetting');
        exit;
    }
}
