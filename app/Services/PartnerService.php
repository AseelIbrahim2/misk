<?php
namespace App\Services;

use App\Repositories\PartnerRepository;
use App\Core\Validator;
use Exception;

class PartnerService
{
    private PartnerRepository $repo;
    private Validator $validator;

    public function __construct()
    {
        $this->repo = new PartnerRepository();
        $this->validator = new Validator();
    }


        public function list(): array
        {
            return $this->repo->all();
        }

        public function getById(int $id): ?array
        {
            return $this->repo->find($id);
        }

    public function create(array $data): int
    {
        unset($data['csrf_token']);
        $data['name'] = $this->validator->sanitize($data['name'] ?? '');
        $data['link'] = $this->validator->sanitize($data['link'] ?? '');
        $data['media_id'] = $data['media_id'] ?? null;
        $data['order'] = (int)($data['order'] ?? 0);

        // Validation
        $this->validator->required('name', $data['name']);
        if ($this->validator->fails()) {
            throw new Exception(json_encode($this->validator->errors()));
        }

        return $this->repo->create($data);
    }


    public function update(int $id, array $data): bool
    {
        unset($data['csrf_token']);
        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception("Partner not found");
        }

        $data['name'] = $this->validator->sanitize($data['name'] ?? $existing['name']);
        $data['link'] = $this->validator->sanitize($data['link'] ?? $existing['link']);
        $data['media_id'] = $data['media_id'] ?? $existing['media_id'];
        $data['order'] = (int)($data['order'] ?? $existing['order']);

        $this->validator->required('name', $data['name']);
        if ($this->validator->fails()) {
            throw new Exception(json_encode($this->validator->errors()));
        }

        return $this->repo->update($id, $data);
    }


    public function delete(int $id): bool
    {
        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception("Partner not found");
        }

        return $this->repo->delete($id);
    }
}
