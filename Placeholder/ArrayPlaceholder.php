<?php

namespace FpDbTest\Placeholder;

class ArrayPlaceholder implements PlaceholderInterface
{
    use ValueTypeModifier;

    public function getPlaceholder(): string
    {
        return '?a';
    }

    public function getParameterValue(mixed $value): string
    {
        if (!is_array($value)) {
            throw new \RuntimeException('Expects array for value');
        }

        $values = [];
        foreach ($value as $identifier => $arrayValue) {
            if (is_int($identifier)) {
                $values[] = $this->modifyValueByType($arrayValue);
            } else {
                $values[] = sprintf('`%s` = %s', $identifier, $this->modifyValueByType($arrayValue));
            }
        }

        return implode(', ', $values);
    }
}