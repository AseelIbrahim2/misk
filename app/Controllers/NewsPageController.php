<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\NewsService;
use App\Services\MenuService;

class NewsPageController extends Controller
{
    private NewsService $newsService;
    private MenuService $menuService;

    public function __construct()
    {
        $this->newsService = new NewsService();
        $this->menuService = new MenuService();
    }

    public function show(int $id): void
    {

        $newsById = $this->newsService->findPublishedById($id);
      
        $menus = $this->menuService->getMenuWithLinks();

        $news = $this->newsService->latestForHome(5);

        if (!$newsById) {
            $this->view('site/404', compact('menus'));
            return;
        }

        $this->view('site/pages/NodePage', compact(
            'newsById',
            'news',
            'menus'
        ));
    }
}


