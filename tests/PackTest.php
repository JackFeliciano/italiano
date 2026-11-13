<?php

declare(strict_types=1);

namespace Italiano\Tests;

use Italiano\Home\Lesson;
use Italiano\Home\Pack;
use Italiano\Home\Sample;

return [
    ['the pack orders its lessons', static function (): void {
        $pack = Sample::pack();
        Assert::same('I-01', $pack->lessons()[0]->id);
        Assert::same('I-03', $pack->lessons()[2]->id);
    }],
    ['a lesson added out of order sorts into place', static function (): void {
        $pack = new Pack('Italiano');
        $pack->add(new Lesson('I-02', 'second', 2));
        $pack->add(new Lesson('I-01', 'first', 1));
        Assert::same('I-01', $pack->lessons()[0]->id);
    }],
    ['a gloss answers in the reference asked for', static function (): void {
        $pack = Sample::pack();
        Assert::same('good morning', $pack->meaning('I-01', 'buongiorno', 'English'));
        Assert::same('доброе утро', $pack->meaning('I-01', 'buongiorno', 'Russian'));
    }],
    ['a missing reference falls back to one the lesson carries', static function (): void {
        $pack = Sample::pack();
        Assert::same('the bill', $pack->meaning('I-03', 'il conto', 'Japanese'));
    }],
    ['a word nobody glossed returns nothing', static function (): void {
        Assert::true(Sample::pack()->meaning('I-01', 'banana', 'English') === null);
    }],
    ['a lesson that does not exist returns nothing', static function (): void {
        Assert::true(Sample::pack()->meaning('I-99', 'grazie', 'English') === null);
    }],
    ['the pack counts every word in it', static function (): void {
        Assert::same(9, Sample::pack()->wordTotal());
    }],
    ['a pack with no lesson is not ready', static function (): void {
        Assert::false((new Pack('Italiano'))->ready());
        Assert::true(Sample::pack()->ready());
    }],
    ['the sample carries two references', static function (): void {
        Assert::count(2, Sample::pack()->references());
    }],
    ['a lesson is found by its identifier', static function (): void {
        Assert::same('The thing liked as subject', Sample::pack()->lesson('I-02')?->title);
    }],
];
