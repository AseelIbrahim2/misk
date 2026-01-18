<?php
namespace App\Services;

use App\Repositories\NewsRepository;
use App\Core\Validator;
use App\Middleware\AuthMiddleware;
use App\Config\Permissions;
use Exception;

class NewsService
{
    private NewsRepository $repo;

    public function __construct()
    {
        $this->repo = new NewsRepository();
    }

    public function list(): array
    {
        return $this->repo->all();
    }

    public function findById(int $id): ?array
    {
        return $this->repo->find($id);
    }

    public function create(array $data): void
    {
        AuthMiddleware::protectPermission(Permissions::CREATE_NEWS);

        $validator = new Validator();

        $clean = [
            'title'       => $validator->sanitize($data['title'] ?? ''),
            'description' => $validator->sanitize($data['description'] ?? ''),
            'content'     => $validator->sanitize($data['content'] ?? ''),
            'status'      => (int)($data['status'] ?? 0),
            'is_deleted'  => (int)($data['is_deleted'] ?? 0),
            'user_id'     => $_SESSION['user']['id'],
            'media_id'    => !empty($data['media_id']) ? (int)$data['media_id'] : null,
            'created'     => date('Y-m-d H:i:s'),
            'updated'     => date('Y-m-d H:i:s'),
        ];

        $validator->required('title', $clean['title']);
        $validator->max('title', $clean['title'], 255);

        $validator->required('description', $clean['description']);
        $validator->max('description', $clean['description'], 500);

        $validator->required('content', $clean['content']);
        $validator->in('status', $clean['status'], [0,1,2]);
        $validator->in('is_deleted', $clean['is_deleted'], [0,1]);

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }

        $this->repo->create($clean);
    }

    public function update(int $id, array $data): void
    {
        AuthMiddleware::protectPermission(Permissions::EDIT_NEWS);

        $news = $this->repo->find($id);
        if (!$news) throw new Exception('News not found');

        $validator = new Validator();

        $clean = [
            'title'       => $validator->sanitize($data['title'] ?? $news['title']),
            'description' => $validator->sanitize($data['description'] ?? $news['description']),
            'content'     => $validator->sanitize($data['content'] ?? $news['content']),
            'status'      => (int)($data['status'] ?? $news['status']),
            'is_deleted'  => (int)($data['is_deleted'] ?? $news['is_deleted']),
            'media_id'    => !empty($data['media_id']) ? (int)$data['media_id'] : null,
            'updated'     => date('Y-m-d H:i:s'),
        ];

        $validator->required('title', $clean['title']);
        $validator->max('title', $clean['title'], 255);
        $validator->required('description', $clean['description']);
        $validator->max('description', $clean['description'], 500);
        $validator->required('content', $clean['content']);
        $validator->in('status', $clean['status'], [0,1,2]);
        $validator->in('is_deleted', $clean['is_deleted'], [0,1]);

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }

        $this->repo->update($id, $clean);
    }

    public function delete(int $id): void
    {
        AuthMiddleware::protectPermission(Permissions::DELETE_NEWS);
        $this->repo->delete($id);
    }
}
