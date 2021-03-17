<?php

namespace repositories\contracts;

interface ProductInterface
{
    const PRODUCT_NAME_COLUMN = 'product_name';
    const IMAGE_COLUMN = 'image';
    const AVG_PRICE_COLUMN = 'avg_price';
    const CREATOR_NAME_COLUMN = 'creator_name';
    const CREATED_AT_COLUMN = 'created_at';
    const COMMENTS_AMOUNT_COLUMN = 'comments_amount';
    const PRODUCT_ID_COLUMN = 'id';

    const PRODUCT_TABLE_COLUMNS = [
        self::PRODUCT_NAME_COLUMN,
        //self::IMAGE_COLUMN,
        self::AVG_PRICE_COLUMN,
        self::CREATOR_NAME_COLUMN,
        self::CREATED_AT_COLUMN,
        self::COMMENTS_AMOUNT_COLUMN,
        self::PRODUCT_ID_COLUMN,
    ];

    public function all();

    public function create(array $data): void;

    public function update(array $data): void;

    public function delete(int $id): void;

    public function getProductById(int $id);

    public function sortByColumn(string $column, $sortRule);
}
