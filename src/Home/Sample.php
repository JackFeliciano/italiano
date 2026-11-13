<?php

declare(strict_types=1);

namespace Italiano\Home;

final class Sample
{
    public static function pack(): Pack
    {
        $pack = new Pack('Italiano');

        $one = new Lesson('I-01', 'Greeting somebody', 1);
        $one->addWord('buongiorno');
        $one->addWord('grazie');
        $one->addWord('arrivederci');
        $one->gloss('buongiorno', 'English', 'good morning');
        $one->gloss('buongiorno', 'Russian', 'доброе утро');
        $one->gloss('grazie', 'English', 'thank you');
        $one->gloss('grazie', 'Russian', 'спасибо');
        $one->gloss('arrivederci', 'English', 'see you later');
        $pack->add($one);

        $two = new Lesson('I-02', 'The thing liked as subject', 2);
        $two->addWord('mi piace');
        $two->addWord('mi piacciono');
        $two->addWord('il caffè');
        $two->gloss('mi piace', 'English', 'I like it, the thing liked is singular');
        $two->gloss('mi piace', 'Russian', 'мне нравится');
        $two->gloss('mi piacciono', 'English', 'I like them, the things liked are plural');
        $two->gloss('mi piacciono', 'Russian', 'мне нравятся');
        $two->gloss('il caffè', 'English', 'the coffee');
        $pack->add($two);

        $three = new Lesson('I-03', 'At the counter', 3);
        $three->addWord('quanto costa');
        $three->addWord('il conto');
        $three->addWord('vorrei');
        $three->gloss('quanto costa', 'English', 'how much does it cost');
        $three->gloss('quanto costa', 'Russian', 'сколько стоит');
        $three->gloss('il conto', 'English', 'the bill');
        $three->gloss('vorrei', 'English', 'I would like');
        $pack->add($three);

        return $pack;
    }
}
