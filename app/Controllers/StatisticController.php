<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\StatisticService;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Config\Permissions;
use Exception;

class StatisticController extends Controller
{
    private StatisticService $service;

    public function __construct()
    {
        $this->service = new StatisticService();
        AuthMiddleware::protectPermission(Permissions::MANAGE_STATISTICS);
    }

    public function index(): void
    {
        $statistics = $this->service->list(); 
        $this->view('admin/statistics/index', compact('statistics'));
    }


    public function create(): void
    {
        $this->view('admin/statistics/create');
    }

    public function store(): void
    {
        CsrfMiddleware::protect();
        try {
            $this->service->create($_POST);
            header('Location: /statistic');
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true) ?: [$e->getMessage()];
            $_SESSION['old'] = $_POST;
            header('Location: /statistic/create');
            exit;
        }
    }

    public function edit(int $id): void
    {
        $stat = $this->service->get($id);
        $this->view('admin/statistics/edit', compact('stat'));
    }

    public function update(int $id): void
    {
        CsrfMiddleware::protect();
        try {
            $this->service->update($id, $_POST);
            header('Location: /statistic');
            exit;
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true) ?: [$e->getMessage()];
            $_SESSION['old'] = $_POST;
            header("Location: /statistic/edit/$id");
            exit;
        }
    }

    public function delete(int $id): void
    {
        CsrfMiddleware::protect();
        $this->service->delete($id);
        header('Location: /statistic');
        exit;
    }
}
