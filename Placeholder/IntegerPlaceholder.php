<?php

namespace FpDbTest\Placeholder;

class IntegerPlaceholder implements PlaceholderInterface
{
    public function getPlaceholder(): string
    {
        return '?d';
    }

    public function getParameterValue(mixed $value): string
    {
        try {
            return (string)(int) $value;
        } catch (\Throwable) {
            throw new \RuntimeException('Error while cast value to integer');
        }
    }
}