<?php

namespace repositories\contracts;

interface ProductInterface
{
    public function all();

    public function create(array $data): void;

    public function update(array $data): void;

    public function delete(int $id): void;

    public function getProductById(int $id);
}
