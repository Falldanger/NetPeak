<?php

namespace repositories\contracts;

interface CommentInterface
{
    public function all();

    public function create(array $data): void;

    public function update(array $data): void;

    public function delete(int $id): void;

    public function getRecordById(int $id);

    public function getCommentsByProductId(int $id);
}
