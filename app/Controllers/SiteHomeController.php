<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\SliderService;
use App\Services\StatisticService;
use App\Services\NewsService;
use App\Services\PartnerService;
use App\Services\MenuService;

class SiteHomeController extends Controller
{
    
    private SliderService $sliderService;
    private StatisticService $statService;
    private PartnerService $partnerService;
    private NewsService $newsService;
    private MenuService $menuService;

public function __construct()
{
    $this->menuService = new MenuService();
    $this->sliderService  = new SliderService();
    $this->statService    = new StatisticService();
    $this->partnerService = new PartnerService();
    $this->newsService    = new NewsService();
}

public function index(): void
{
    $sliders    = $this->sliderService->list();
    $statistics = $this->statService->list();
    $partners   = $this->partnerService->list();
    $news       = $this->newsService->list(); 
    $menus = $this->menuService->getMenuWithLinks(); 

    $this->view('site/pages/index', [
        'sliders'    => $sliders,
        'statistics' => $statistics,
        'partners'   => $partners,
        'news'       => $news, 
        'menus' => $menus,
    ]);
}

}
