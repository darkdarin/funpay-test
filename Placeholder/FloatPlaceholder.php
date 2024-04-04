<?php

namespace FpDbTest\Placeholder;

class FloatPlaceholder implements PlaceholderInterface
{
    public function getPlaceholder(): string
    {
        return '?f';
    }

    public function getParameterValue(mixed $value): string
    {
        try {
            return (float) $value;
        } catch (\Throwable) {
            throw new \RuntimeException('Error while cast value to float');
        }
    }
}