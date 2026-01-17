<?php

namespace App\Repositories;

use App\Models\Slider;


class SliderRepository
{
    private Slider $slider;

    public function __construct()
    {
        $this->slider = new Slider();
    }

    public function all(): array
    {
        return $this->slider->getAllWithMedia();
    }

    public function find(int $id): ?array
    {
        return $this->slider->findWithMedia($id);
    }

    public function create(array $data): int
    {
        return $this->slider->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->slider->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->slider->delete($id);
    }
}
