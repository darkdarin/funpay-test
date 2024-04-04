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
        if (array_is_list($value)) {
            $values = array_map($this->modifyValueByType(...), $value);
        } else {
            foreach ($value as $identifier => $arrayValue) {
                $values[] = sprintf('`%s` = %s', $identifier, $this->modifyValueByType($arrayValue));
            }
        }

        return implode(', ', $values);
    }
}