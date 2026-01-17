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
        $permissions = $_SESSION['user']['permissions'] ?? [];

        if (in_array(Permissions::VIEW_ALL_NEWS, $permissions, true)) {
            return $this->repo->all();
        }

        if (!in_array(Permissions::VIEW_NEWS, $permissions, true)) {
            throw new Exception('Access denied');
        }

        return $this->repo->getByUser($_SESSION['user']['id']);
    }

    public function findById(int $id): ?array
    {
        $news = $this->repo->find($id);

        if (!$news || (int)$news['is_deleted'] === 1) {
            return null;
        }

        return $news;
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
        'media_id'    => $data['media_id'] ?? null,
        'created'     => date('Y-m-d H:i:s'),
        'updated'     => date('Y-m-d H:i:s'),
    ];



        // Title rules
        $validator->required('title', $clean['title']);           
        $validator->max('title', $clean['title'], 255);     

        // Description rules
        $validator->required('description', $clean['description']); 
        $validator->max('description', $clean['description'], 500); 

 

        // Content rules
        $validator->required('content', $clean['content']);  


        // Status & Deleted rules
        $validator->in('status', $clean['status'], [0, 1, 2]);       
        $validator->in('is_deleted', $clean['is_deleted'], [0, 1]);  


     
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

        if (
            !in_array(Permissions::VIEW_ALL_NEWS, $_SESSION['user']['permissions']) &&
            $news['user_id'] !== $_SESSION['user']['id']
        ) {
            throw new Exception('Unauthorized');
        }

        $validator = new Validator();

        $clean = [
            'title'       => $validator->sanitize($data['title'] ?? ''),
            'description' => $validator->sanitize($data['description'] ?? ''),
            'content'     => $validator->sanitize($data['content'] ?? ''),
            'status'      => (int)($data['status'] ?? 0),
            'is_deleted'  => (int)($data['is_deleted'] ?? 0),
            'updated'     => date('Y-m-d H:i:s'),
        ];

    
        // Title rules
        $validator->required('title', $clean['title']);           
        $validator->max('title', $clean['title'], 255);     

        // Description rules
        $validator->required('description', $clean['description']); 
        $validator->max('description', $clean['description'], 500); 

 

        // Content rules
        $validator->required('content', $clean['content']);  


        // Status & Deleted rules
        $validator->in('status', $clean['status'], [0, 1, 2]);       
        $validator->in('is_deleted', $clean['is_deleted'], [0, 1]);  



        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }

        $this->repo->update($id, $clean);
    }

    public function delete(int $id): void
    {
        AuthMiddleware::protectPermission(Permissions::DELETE_NEWS);

        $news = $this->repo->find($id);
        if (!$news) throw new Exception('News not found');

        if (
            !in_array(Permissions::VIEW_ALL_NEWS, $_SESSION['user']['permissions']) &&
            $news['user_id'] !== $_SESSION['user']['id']
        ) {
            throw new Exception('Unauthorized');
        }

        $this->repo->delete($id);
    }


}
