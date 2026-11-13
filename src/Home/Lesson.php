<?php

declare(strict_types=1);

namespace Italiano\Home;

/**
 * One lesson of the pack. It carries its sentences, its word bank and the
 * reference language each gloss sits in. The pack holds no engine code, so a
 * lesson is data and nothing else.
 */
final class Lesson
{
    /** @var list<string> */
    private array $words = [];

    /** @var array<string, string> */
    private array $glosses = [];

    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly int $order,
    ) {
    }

    public function addWord(string $word): void
    {
        $this->words[] = $word;
    }

    public function gloss(string $word, string $reference, string $meaning): void
    {
        $this->glosses[$word . '@' . $reference] = $meaning;
    }

    /** @return list<string> */
    public function words(): array
    {
        return $this->words;
    }

    /** @return array<string, string> */
    public function glosses(): array
    {
        return $this->glosses;
    }

    public function glossFor(string $word, string $reference): ?string
    {
        return $this->glosses[$word . '@' . $reference] ?? null;
    }
}
