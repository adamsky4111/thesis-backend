<?php

namespace App\Filter;


final class SettingsFilter extends AbstractFilter implements FilterInterface
{
    // fields
    const FIELD_IS_DEFAULT = 'isDefault';
    const FIELD_NAME = 'name';
    const FIELD_AGE = 'ageAllowed';

    // types
    const TYPE_MAPPER = [
        self::FIELD_AGE => self::TYPE_FROM_TO,
        self::FIELD_IS_DEFAULT => self::TYPE_BOOLEAN,
        self::FIELD_NAME => self::TYPE_PHRASE,
    ];

    // allowed fields in search
    const ALLOWED_SEARCH_FIELDS = [
        self::FIELD_NAME,
        self::FIELD_IS_DEFAULT,
        self::FIELD_AGE,
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

