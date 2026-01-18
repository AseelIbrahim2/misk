<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\PartnerService;
use App\Services\MediaService;
use App\Middleware\CsrfMiddleware;
use App\Middleware\AuthMiddleware;
use App\Config\Permissions;
use Exception;

class PartnersController extends Controller
{
    private PartnerService $service;
    private MediaService $mediaService;

    public function __construct()
    {
        AuthMiddleware::protectPermission(Permissions::MANAGE_PARTNERS);
        $this->service = new PartnerService();
        $this->mediaService = new MediaService();
    }

    public function index(): void
    {
        $partners = $this->service->list();
        $this->view('admin/partners/index', compact('partners'));
    }

    public function create(): void
    {
        $media = $this->mediaService->list();
        $this->view('admin/partners/create', compact('media'));
    }

    public function store(): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->create($_POST);
            $_SESSION['success'] = "Partner created successfully";
            header('Location: /partners');
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true);
            $_SESSION['old'] = $_POST;
            header('Location: /partners/create');
            exit;
        }
    }

    public function edit(int $id): void
    {
        $partner = $this->service->getById($id);
        $media   = $this->mediaService->list();

        if (!$partner) {
            $_SESSION['errors'][] = ["Partner not found"];
            header('Location: /partners');
            exit;
        }

        $this->view('admin/partners/edit', compact('partner', 'media'));
    }

    public function update(int $id): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->update($id, $_POST);
            $_SESSION['success'] = "Partner updated successfully";
            header('Location: /partners');
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true);
            $_SESSION['old'] = $_POST;
            header("Location: /partners/edit/$id");
            exit;
        }
    }

    public function delete(int $id): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->delete($id);
            $_SESSION['success'] = "Partner deleted successfully";
        } catch (Exception $e) {
            $_SESSION['errors'][] = [$e->getMessage()];
        }

        header('Location: /partners');
        exit;
    }
}
