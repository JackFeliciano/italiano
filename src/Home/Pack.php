<?php

declare(strict_types=1);

namespace Italiano\Home;

/**
 * The pack. It orders its lessons, holds the references a learner can read a
 * gloss in, and reports what it carries. A pack with no lesson is not a pack.
 */
final class Pack
{
    /** @var list<Lesson> */
    private array $lessons = [];

    /** @var list<string> */
    private array $references = ['English', 'Russian'];

    public function __construct(public readonly string $language)
    {
    }

    public function add(Lesson $lesson): void
    {
        $this->lessons[] = $lesson;
        usort($this->lessons, static fn (Lesson $a, Lesson $b): int => $a->order <=> $b->order);
    }

    /** @return list<Lesson> */
    public function lessons(): array
    {
        return $this->lessons;
    }

    /** @return list<string> */
    public function references(): array
    {
        return $this->references;
    }

    public function ready(): bool
    {
        return $this->lessons !== [] && $this->references !== [];
    }

    public function wordTotal(): int
    {
        $total = 0;
        foreach ($this->lessons as $lesson) {
            $total += count($lesson->words());
        }

        return $total;
    }

    public function lesson(string $id): ?Lesson
    {
        foreach ($this->lessons as $lesson) {
            if ($lesson->id === $id) {
                return $lesson;
            }
        }

        return null;
    }

    /**
     * The gloss in the reference language, falling back to the first reference
     * the lesson carries when the reader asks for one that is not there.
     */
    public function meaning(string $lessonId, string $word, string $reference): ?string
    {
        $lesson = $this->lesson($lessonId);
        if ($lesson === null) {
            return null;
        }
        $found = $lesson->glossFor($word, $reference);
        if ($found !== null) {
            return $found;
        }
        foreach ($this->references as $fallback) {
            $found = $lesson->glossFor($word, $fallback);
            if ($found !== null) {
                return $found;
            }
        }

        return null;
    }
}
