<?php

namespace App\Services;

use App\Repositories\ApplicationRepository;
use App\Middleware\AuthMiddleware;
use App\Config\Permissions;
use App\Core\Validator;
use Exception;

class ApplicationService
{
    private ApplicationRepository $repo;

    public function __construct()
    {
        $this->repo = new ApplicationRepository();
    }

    /* ================= ADMIN ================= */

    public function list(): array
    {
        AuthMiddleware::protectPermission(Permissions::VIEW_APPLICATIONS);
        return $this->repo->all();
    }

    public function updateStatus(int $id, array $data): void
    {
        AuthMiddleware::protectPermission(Permissions::EDIT_APPLICATIONS);

        $validator = new Validator();
        $status = $data['status'] ?? '';

        $validator->in('status', $status, ['pending', 'approved', 'rejected']);

        if ($validator->fails()) {
            throw new Exception(json_encode($validator->errors()));
        }

        $this->repo->update($id, [
            'status'  => $status,
            'updated' => date('Y-m-d H:i:s')
        ]);
    }

    public function delete(int $id): void
    {
        AuthMiddleware::protectPermission(Permissions::DELETE_APPLICATIONS);
        $this->repo->delete($id);
    }

    /* ================= FRONT (ADMISSIONS) ================= */

 public function store(array $data): void
{
    // 1️⃣ Auth check
    if (!AuthMiddleware::check()) {
        throw new Exception(json_encode([
            'auth' => ['You must be logged in to submit an application']
        ]));
    }

    $validator = new Validator();

    $full_name = $validator->sanitize($data['full_name'] ?? '');
    $email     = $validator->sanitize($data['email'] ?? '');
    $age       = (int)($data['age'] ?? 0);
    $message   = $validator->sanitize($data['message'] ?? '');

    // 2️⃣ Duplicate check (بعد تعريف email)
    if ($this->repo->emailExists($email)) {
        throw new Exception(json_encode([
            'email' => ['An application with this email already exists']
        ]));
    }

    // 3️⃣ Validation
    $validator->required('full_name', $full_name);
    $validator->required('email', $email);
    $validator->email('email', $email);

    $errors = [];

    if ($validator->fails()) {
        $errors = $validator->errors();
    }

    if ($age < 5 || $age > 18) {
        $errors['age'][] = 'Age must be between 5 and 18';
    }

    if (!empty($errors)) {
        throw new Exception(json_encode($errors));
    }

    // 4️⃣ Store
    $this->repo->create([
        'full_name' => $full_name,
        'email'     => $email,
        'age'       => $age,
        'message'   => $message,
        'submitted' => date('Y-m-d H:i:s')
    ]);
}


}
