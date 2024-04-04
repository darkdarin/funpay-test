<?php

namespace FpDbTest\Placeholder;

interface PlaceholderInterface
{
    public function getPlaceholder(): string;

    public function getParameterValue(mixed $value): string;
}