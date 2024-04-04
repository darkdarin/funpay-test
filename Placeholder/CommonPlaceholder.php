<?php

namespace FpDbTest\Placeholder;

class CommonPlaceholder implements PlaceholderInterface
{
    use ValueTypeModifier;

    public function getPlaceholder(): string
    {
        return '?';
    }

    public function getParameterValue(mixed $value): string
    {
        return $this->modifyValueByType($value);
    }
}