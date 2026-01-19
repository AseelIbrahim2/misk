<?php

namespace App\Services;

use App\Repositories\SiteSettingRepository;
use App\Core\Validator;
use App\Middleware\AuthMiddleware;
use App\Config\Permissions;
use Exception;

class SiteSettingService
{
    private SiteSettingRepository $repo;
    private Validator $validator;

    public function __construct()
    {
        $this->repo = new SiteSettingRepository();
        $this->validator = new Validator();
    }

    public function get(): array
    {
        AuthMiddleware::protectPermission(Permissions::MANAGE_SITE_SETTINGS);
        return $this->repo->get();
    }

    public function update(array $data): bool
    {
        AuthMiddleware::protectPermission(Permissions::MANAGE_SITE_SETTINGS);

        unset($data['csrf_token']);

        $data['site_name'] = $this->validator->sanitize($data['site_name'] ?? '');
        $data['slogan']    = $this->validator->sanitize($data['slogan'] ?? '');
        $data['email']     = $this->validator->sanitize($data['email'] ?? '');
        $data['logo_m_id'] = $data['logo_m_id'] ?? null;

        $this->validator->required('site_name', $data['site_name']);
        $this->validator->required('email', $data['email']);

        if ($this->validator->fails()) {
            throw new Exception(json_encode($this->validator->errors()));
        }

        return $this->repo->update($data);
    }
}
