<?php

declare(strict_types=1);

namespace Italiano\App;

use Italiano\Home\Lesson;
use Italiano\Home\Pack;

final class Views
{
    public function __construct(private readonly string $base)
    {
    }

    private function h(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    public function header(string $title): string
    {
        $base = $this->h($this->base);

        return <<<HTML
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{$this->h($title)}</title>
<base href="{$base}">
<link rel="stylesheet" href="assets/site.css">
</head>
<body>
<main>
HTML;
    }

    public function footer(): string
    {
        return "</main>\n</body>\n</html>\n";
    }

    public function notFound(string $path): string
    {
        return $this->header('Not found')
            . '<h1>Not found</h1>' . "\n"
            . '<p class="stage">' . $this->h($path) . ' is not a route here.</p>' . "\n"
            . $this->footer();
    }

    public function front(Pack $pack, string $today): string
    {
        $out = $this->header('Smart Italiano');
        $out .= '<h1>Smart Italiano. Lessons, word bank and glosses in Italian</h1>' . "\n";
        $out .= '<p class="lede">Smart Italiano holds lessons, a word bank, exercises and conversation prompts. Every piece runs in Italian.</p>' . "\n";
        $out .= '<p class="stage">' . count($pack->lessons()) . ' lessons, ' . $pack->wordTotal() . ' words, as of ' . $this->h($today) . '.</p>' . "\n";

        $out .= '<h2>References</h2>' . "\n";
        $out .= '<dl>';
        foreach ($pack->references() as $reference) {
            $out .= '<dt>' . $this->h($reference) . '</dt><dd>gloss available</dd>';
        }
        $out .= '<dt>Ready</dt><dd>' . ($pack->ready() ? 'yes' : 'no') . '</dd>';
        $out .= '</dl>' . "\n";

        $out .= '<h2>Lessons</h2>' . "\n";
        $out .= '<table class="tiers">' . "\n";
        $out .= '<thead><tr><th>Order</th><th>Lesson</th><th>Words</th><th>First word</th><th>English gloss</th></tr></thead>' . "\n";
        $out .= '<tbody>' . "\n";
        foreach ($pack->lessons() as $lesson) {
            $out .= $this->row($pack, $lesson);
        }
        $out .= '</tbody>' . "\n" . '</table>' . "\n";

        $out .= '<h2>Word bank</h2>' . "\n";
        $out .= '<div class="cards">' . "\n";
        foreach ($pack->lessons() as $lesson) {
            $out .= $this->card($lesson);
        }
        $out .= '</div>' . "\n";
        $out .= $this->footer();

        return $out;
    }

    private function row(Pack $pack, Lesson $lesson): string
    {
        $words = $lesson->words();
        $first = $words[0] ?? '';
        $gloss = $pack->meaning($lesson->id, $first, 'English') ?? '';

        return '<tr><td>' . $lesson->order . '</td>'
            . '<td><strong>' . $this->h($lesson->title) . '</strong><br><span class="stage">' . $this->h($lesson->id) . '</span></td>'
            . '<td>' . count($words) . '</td>'
            . '<td>' . $this->h($first) . '</td>'
            . '<td>' . $this->h($gloss) . '</td></tr>' . "\n";
    }

    private function card(Lesson $lesson): string
    {
        $out = '<article class="card">' . "\n";
        $out .= '<h3>' . $this->h($lesson->title) . '</h3>' . "\n";
        $out .= '<dl>';
        foreach ($lesson->words() as $word) {
            $out .= '<dt>' . $this->h($word) . '</dt><dd>' . $this->h($lesson->glossFor($word, 'English') ?? '') . '</dd>';
        }
        $out .= '</dl>' . "\n";
        $out .= '</article>' . "\n";

        return $out;
    }
}
