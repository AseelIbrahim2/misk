<?php
namespace App\Services;

use App\Repositories\StatisticRepository;
use App\Core\Validator;
use Exception;

class StatisticService
{
    private StatisticRepository $repo;

    public function __construct()
    {
        $this->repo = new StatisticRepository();
    }

    /**
     * Get all statistics
     */
    public function list(): array
    {
        return $this->repo->all();
    }

    /**
     * Get single statistic by ID
     */
    public function get(int $id): array
    {
        $stat = $this->repo->find($id);
        if (!$stat) {
            throw new Exception("Statistic not found");
        }
        return $stat;
    }

    /**
     * Create new statistic
     */
    public function create(array $data): int
    {
        $validator = new Validator();

        $key   = $validator->sanitize($data['key'] ?? '');
        $label = $validator->sanitize($data['label'] ?? '');
        $value = (int)($data['value'] ?? 0);
        $suffix = $validator->sanitize($data['suffix'] ?? '');
        $order  = (int)($data['order'] ?? 0);
        $is_active = !empty($data['is_active']) ? 1 : 0;

        $validator->required('key', $key);
        $validator->required('label', $label);

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }

  
        if ($this->repo->exists('key', $key)) {
            throw new Exception(json_encode(['key' => ['This key already exists.']]));
        }

        return $this->repo->create([
            'key'       => $key,
            'label'     => $label,
            'value'     => $value,
            'suffix'    => $suffix,
            'order'     => $order,
            'is_active' => $is_active,
            'created'   => date('Y-m-d H:i:s'),
            'updated'   => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Update existing statistic
     */
    public function update(int $id, array $data): bool
    {
        $validator = new Validator();

        $key   = $validator->sanitize($data['key'] ?? '');
        $label = $validator->sanitize($data['label'] ?? '');
        $value = (int)($data['value'] ?? 0);
        $suffix = $validator->sanitize($data['suffix'] ?? '');
        $order  = (int)($data['order'] ?? 0);
        $is_active = !empty($data['is_active']) ? 1 : 0;

        $validator->required('key', $key);
        $validator->required('label', $label);

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }


        $existing = $this->repo->findBy('key', $key);
        if ($existing && $existing['id'] != $id) {
            throw new Exception(json_encode(['key' => ['This key already exists.']]));
        }

        return $this->repo->update($id, [
            'key'       => $key,
            'label'     => $label,
            'value'     => $value,
            'suffix'    => $suffix,
            'order'     => $order,
            'is_active' => $is_active,
            'updated'   => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Delete statistic
     */
    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }
}
