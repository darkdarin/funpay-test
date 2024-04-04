<?php

namespace FpDbTest\Placeholder;

class IdentifierPlaceholder implements PlaceholderInterface
{
    public function getPlaceholder(): string
    {
        return '?#';
    }

    public function getParameterValue(mixed $value): string
    {
        if (is_array($value)) {
            return implode(', ', array_map($this->escapeIdentifier(...), $value));
        }

        return $this->escapeIdentifier($value);
    }

    private function escapeIdentifier(mixed $value): string
    {
        if (!is_string($value)) {
            throw new \RuntimeException('Identifier must be string');
        }

        return sprintf('`%s`', $value);
    }
}