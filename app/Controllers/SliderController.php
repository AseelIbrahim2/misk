<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\SliderService;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Config\Permissions;
use App\Services\MediaService;

use Exception;

class SliderController extends Controller
{
    private SliderService $service;
    private MediaService $mediaService;

    public function __construct()
    {
        AuthMiddleware::protectPermission(Permissions::MANAGE_SLIDERS);
        $this->service = new SliderService();
        $this->mediaService = new MediaService();
    }

    public function index(): void
    {
        $sliders = $this->service->list();
        $this->view('admin/sliders/index', compact('sliders'));
    }

    public function create(): void
    {
        $media = $this->mediaService->list();
        $this->view('admin/sliders/create', compact('media'));
    }

    public function edit(int $id): void
    {
        $slider = $this->service->get($id);
        $media  = $this->mediaService->list();

        $this->view('admin/sliders/edit', compact('slider', 'media'));
    }


    public function store(): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->create($_POST);
            header('Location: /slider/index');
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true);
            $_SESSION['old'] = $_POST;
            header('Location: /slider/create');
            exit;
        }
    }

 

    public function update(int $id): void
    {
        CsrfMiddleware::protect();

        try {
            $this->service->update($id, $_POST);
            header('Location: /slider/index');
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true);
            header("Location: /slider/edit/$id");
            exit;
        }
    }

    public function delete(int $id): void
    {
        CsrfMiddleware::protect();
        $this->service->delete($id);
        header('Location: /slider/index');
        exit;
    }
}
