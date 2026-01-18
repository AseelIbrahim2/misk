<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\SliderService;
use App\Services\StatisticService;

class SiteHomeController extends Controller
{
    private SliderService $sliderService;
    private StatisticService $statService;

    public function __construct()
    {
        $this->sliderService = new SliderService();
        $this->statService   = new StatisticService();
    }

    public function index(): void
    {
        $sliders = $this->sliderService->list();
        $statistics = $this->statService->list(); 

       
        $this->view('site/pages/index', [
            'sliders'    => $sliders,
            'statistics' => $statistics
        ]);
    }
}
