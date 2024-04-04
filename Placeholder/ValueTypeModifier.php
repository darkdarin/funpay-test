<?php

namespace FpDbTest\Placeholder;

trait ValueTypeModifier
{
    private function modifyValueByType(mixed $value): string
    {
        if ($value === null) {
            return 'NULL';
        }

        if (is_string($value)) {
            return sprintf('\'%s\'', $value);
        }
        if (is_integer($value) || is_float($value)) {
            return $value;
        }
        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        throw new \RuntimeException('Value must be type of bool, integer, float, string or null');
    }
}