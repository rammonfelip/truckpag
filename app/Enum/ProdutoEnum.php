<?php

namespace App\Enum;

class ProdutoEnum
{
    const STATUS_DRAFT = 'draft';
    const STATUS_TRASH = 'trash';
    const STATUS_PUBLISHED = 'published';

    protected $casts = [
        'status' => 'string',
    ];

    public static function getStatus()
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_TRASH,
            self::STATUS_PUBLISHED,
        ];
    }
}
