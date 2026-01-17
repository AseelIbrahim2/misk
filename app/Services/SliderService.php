<?php
namespace App\Services;

use App\Repositories\SliderRepository;
use App\Core\Validator;
use Exception;

class SliderService
{
    private SliderRepository $repo;

    public function __construct()
    {
        $this->repo = new SliderRepository();
    }

    public function list(): array
    {
        return $this->repo->all();
    }

    public function get(int $id): ?array
    {
        return $this->repo->find($id);
    }

    public function create(array $data): void
    {
        $validator = new Validator();

        $title       = $validator->sanitize($data['title'] ?? '');
        $description = $validator->sanitize($data['description'] ?? '');
        $media_id    = (int)($data['media_id'] ?? 0);
        $order       = (int)($data['order'] ?? 0);

        $validator->required('title', $title);
        $validator->required('media_id', $media_id);

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }

        $this->repo->create([
            'title'       => $title,
            'description' => $description,
            'media_id'    => $media_id,
            'order'       => $order,
            'created'     => date('Y-m-d H:i:s'),
            'updated'     => date('Y-m-d H:i:s'),
        ]);
    }

    public function update(int $id, array $data): void
    {
        $validator = new Validator();
        $updateData = [];

        if (isset($data['title'])) {
            $updateData['title'] = $validator->sanitize($data['title']);
        }

        if (isset($data['description'])) {
            $updateData['description'] = $validator->sanitize($data['description']);
        }

        if (isset($data['media_id'])) {
            $updateData['media_id'] = (int)$data['media_id'];
        }

        if (isset($data['order'])) {
            $updateData['order'] = (int)$data['order'];
        }

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }

        $updateData['updated'] = date('Y-m-d H:i:s');

        $this->repo->update($id, $updateData);
    }

    public function delete(int $id): void
    {
        $this->repo->delete($id);
    }
}
