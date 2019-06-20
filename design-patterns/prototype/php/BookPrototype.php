<?php

declare(strict_types=1);

abstract class BookPrototype
{
    protected string $title;
    protected string $topic;

    abstract function __clone();

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $titleIn): void
    {
        $this->title = $titleIn;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }
}

class PHPBookPrototype extends BookPrototype
{
    public function __construct()
    {
        $this->topic = 'PHP';
    }

    public function __clone()
    {
    }
}

class SQLBookPrototype extends BookPrototype
{
    public function __construct()
    {
        $this->topic = 'SQL';
    }

    public function __clone()
    {
    }
}

echo 'BEGIN TESTING PROTOTYPE PATTERN' . PHP_EOL . PHP_EOL;

$phpProto = new PHPBookPrototype();
$sqlProto = new SQLBookPrototype();

$book1 = clone $sqlProto;
$book1->setTitle('SQL For Cats');
echo 'Book 1 topic: ' . $book1->getTopic();
echo 'Book 1 title: ' . $book1->getTitle();
echo PHP_EOL;

$book2 = clone $phpProto;
$book2->setTitle('OReilly Learning PHP 5');
echo 'Book 2 topic: ' . $book2->getTopic();
echo 'Book 2 title: ' . $book2->getTitle();
echo PHP_EOL;

$book3 = clone $sqlProto;
$book3->setTitle('OReilly Learning SQL');
echo 'Book 3 topic: ' . $book3->getTopic();
echo 'Book 3 title: ' . $book3->getTitle();
echo PHP_EOL;

echo 'END TESTING PROTOTYPE PATTERN';