<?php

namespace App\Core\FieldMapper;

use App\Core\AccessControl\AccessChecker;
use App\Core\FieldMapper\Exception\UnknownFieldException;
use App\Core\FieldMapper\Exception\RestrictedFieldException;

/**
 * Class BaseFieldMapper
 *
 * @package App\Core\FieldMapper
 */
abstract class BaseFieldMapper
{
    /** @var AccessChecker */
    protected $accessChecker;
    /** @var string[] */
    protected $fieldList = [];

    /**
     * BaseFieldMapper constructor.
     *
     * @param AccessChecker $accessChecker
     * @param string[] $fieldList
     *
     * @throws RestrictedFieldException
     * @throws UnknownFieldException
     */
    public function __construct(AccessChecker $accessChecker, array $fieldList = [])
    {
        $this->accessChecker = $accessChecker;

        if ($fieldList !== []) {
            $allFieldList = $this->getAllFieldList();
            foreach ($fieldList as $field) {
                if (!\in_array($field, $allFieldList, true)) {
                    throw UnknownFieldException::withField($field);
                }
                if (!$this->hasAccess($field)) {
                    throw RestrictedFieldException::withField($field);
                }
            }
            $this->fieldList = $fieldList;
        } else {
            $this->fieldList = $this->getAllowedFields();
        }
    }

    /**
     * @return string[]
     */
    abstract protected function getAllFieldList(): array;

    /**
     * @param string $field
     *
     * @return bool
     */
    abstract protected function hasAccess(string $field): bool;

    /**
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        $list = [];

        foreach ($this->getAllFieldList() as $field) {
            if ($this->hasAccess($field)) {
                $list[] = $field;
            }
        }

        return $list;
    }
}
