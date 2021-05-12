<?php

namespace App\Filter;


final class AccountChannelFilter extends AbstractFilter implements FilterInterface
{
    // fields
    const FIELD_IS_DEFAULT = 'default';
    const FIELD_NAME = 'name';

    // types
    const TYPE_MAPPER = [
        self::FIELD_IS_DEFAULT => self::TYPE_BOOLEAN,
        self::FIELD_NAME => self::TYPE_PHRASE,
    ];

    // allowed fields in search
    const ALLOWED_SEARCH_FIELDS = [
        self::FIELD_NAME,
        self::FIELD_IS_DEFAULT,
    ];

    // allowed fields in sort
    const ALLOWED_SORT_FIELDS = self::ALLOWED_SEARCH_FIELDS;

    public function isAllowedField(string $field): bool
    {
        return in_array($field, self::ALLOWED_SEARCH_FIELDS);
    }

    public function isAllowedSort(string $sort): bool
    {
        return in_array($sort, self::ALLOWED_SORT_FIELDS);
    }

    public function getTypeMapper(): array
    {
        return self::TYPE_MAPPER;
    }
}

