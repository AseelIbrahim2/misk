<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\NewsService;
use App\Services\MenuService;
use App\Services\SiteSettingService;

class NewsPageController extends Controller
{
    private NewsService $newsService;
    private MenuService $menuService;
    private SiteSettingService $siteSettingsService ;

    public function __construct()
    {
        $this->newsService = new NewsService();
        $this->menuService = new MenuService();
        $this->siteSettingsService  = new SiteSettingService();
    }

    public function show(int $id): void
    {

        $newsById = $this->newsService->findPublishedById($id);
      
        $menus = $this->menuService->getMenuWithLinks();

        $news = $this->newsService->latestForHome(5);
        $siteSettings =  $this->siteSettingsService->get(); 

        if (!$newsById) {
            $this->view('site/404', compact('menus'));
            return;
        }

        $this->view('site/pages/NodePage', compact(
            'newsById',
            'siteSettings',
            'news',
            'menus'
        ));
    }
}


