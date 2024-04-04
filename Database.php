<?php

namespace FpDbTest;

use Exception;
use FpDbTest\Placeholder\ArrayPlaceholder;
use FpDbTest\Placeholder\CommonPlaceholder;
use FpDbTest\Placeholder\FloatPlaceholder;
use FpDbTest\Placeholder\IdentifierPlaceholder;
use FpDbTest\Placeholder\IntegerPlaceholder;
use FpDbTest\Placeholder\PlaceholderInterface;
use mysqli;

class Database implements DatabaseInterface
{
    private mysqli $mysqli;
    /**
     * @var list<PlaceholderInterface>
     */
    private array $placeholders = [];

    public function __construct()
    {
        //$this->mysqli = $mysqli;
        $this->placeholders = [
            new ArrayPlaceholder(),
            new FloatPlaceholder(),
            new IdentifierPlaceholder(),
            new IntegerPlaceholder(),
            new CommonPlaceholder(),
        ];
    }

    public function buildQuery(string $query, array $args = []): string
    {
        $result = '';
        $placeHolderBuffer = '';
        $placeholder = null;
        $placeholderMode = false;

        for ($i = 0; $i < strlen($query); $i++) {
            if ($query[$i] === '?') {
                $placeholderMode = true;
            }

            if ($placeholderMode === true) {
                $placeHolderBuffer .= $query[$i];
                $tempPlaceholder = $this->matchPlaceholder($placeHolderBuffer);
                if ($tempPlaceholder !== null) {
                    $placeholder = $tempPlaceholder;
                } else {
                    $placeholderMode = false;
                    $placeHolderBuffer = '';
                    if ($placeholder !== null) {
                        $result .= $this->replacePlaceholder($placeholder, $args, $i);
                        $placeholder = null;
                    }
                    $result .= $query[$i];
                }
            } else {
                $result .= $query[$i];
            }
        }

        if ($placeholder !== null) {
            $result .= $this->replacePlaceholder($placeholder, $args, $i);
        }

        return $result;
    }

    private function replacePlaceholder(PlaceholderInterface $placeholder, array &$args, int $charIndex): string
    {
        if (count($args) === 0) {
            throw new \RuntimeException(sprintf('Not set value for argument on char :%s', $charIndex));
        }

        try {
            return $placeholder->getParameterValue(array_shift($args));
        } catch (\Throwable $e) {
            throw new \RuntimeException(sprintf('Error while replace placeholder on char :%s: %s', $charIndex, $e->getMessage()));
        }
    }

    private function matchPlaceholder(string $buffer): ?PlaceholderInterface
    {
        foreach ($this->placeholders as $placeholder) {
            if ($placeholder->getPlaceholder() === $buffer) {
                return $placeholder;
            }
        }

        return null;
    }

    public function skip()
    {
        throw new Exception();
    }
}
