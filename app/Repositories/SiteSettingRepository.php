<?php

namespace App\Repositories;

use App\Models\SiteSetting;

class SiteSettingRepository
{
    private SiteSetting $model;

    public function __construct()
    {
        $this->model = new SiteSetting();
    }

    public function get(): array
    {
        return $this->model->get();
    }

    public function update(array $data): bool
    {
        return $this->model->updateSettings($data);
    }
}
