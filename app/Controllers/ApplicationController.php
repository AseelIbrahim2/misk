<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\ApplicationService;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use Exception;

class ApplicationController extends Controller
{
    private ApplicationService $service;

    public function __construct()
    {
        AuthMiddleware::protect(); 
        $this->service = new ApplicationService();
    }


    public function index(): void
    {
        $applications = $this->service->list();
        $this->view('admin/applications/index', compact('applications'));
    }


    public function update(int $id): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->updateStatus($id, $_POST);
            $_SESSION['success'] = 'Application updated successfully';
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true);
        }

        header('Location: /application');
        exit;
    }


    public function delete(int $id): void
    {
        CsrfMiddleware::protect();
        $this->service->delete($id);

        $_SESSION['success'] = 'Application deleted successfully';
        header('Location: /application');
        exit;
    }
}
