<?php

declare(strict_types=1);

class Book
{
    private string $author;
    private string $title;

    public function __construct(string $titleIn, string $authorIn)
    {
        $this->author = $authorIn;
        $this->title = $titleIn;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthorAndTitle(): string
    {
        return $this->getTitle().' by '.$this->getAuthor();
    }
}

class BookTitleDecorator
{
    protected Book $book;
    protected string $title;

    public function __construct(Book $bookIn)
    {
        $this->book = $bookIn;
        $this->resetTitle();
    }

    //doing this so original object is not altered
    public function resetTitle(): void
    {
        $this->title = $this->book->getTitle();
    }

    public function showTitle(): string
    {
        return $this->title;
    }
}

class BookTitleExclaimDecorator extends BookTitleDecorator
{
    private BookTitleDecorator $btd;

    public function __construct(BookTitleDecorator $btdIn)
    {
        $this->btd = $btdIn;
    }

    public function exclaimTitle(): void
    {
        $this->btd->title = '!' . $this->btd->title . '!';
    }
}

class BookTitleStarDecorator extends BookTitleDecorator
{
    private BookTitleDecorator $btd;

    public function __construct(BookTitleDecorator $btdIn)
    {
        $this->btd = $btdIn;
    }

    public function starTitle(): void
    {
        $this->btd->title = Str_replace(' ','*',$this->btd->title);
    }
}

echo 'BEGIN TESTING DECORATOR PATTERN' . PHP_EOL;
echo PHP_EOL;

$patternBook = new Book('Gamma, Helm, Johnson, and Vlissides', 'Design Patterns');

$decorator = new BookTitleDecorator($patternBook);
$starDecorator = new BookTitleStarDecorator($decorator);
$exclaimDecorator = new BookTitleExclaimDecorator($decorator);

echo 'showing title : ' . PHP_EOL;
echo $decorator->showTitle(). PHP_EOL;
echo PHP_EOL;

echo 'showing title after two exclaims added : ' . PHP_EOL;
$exclaimDecorator->exclaimTitle();
$exclaimDecorator->exclaimTitle();
echo $decorator->showTitle(). PHP_EOL;
echo PHP_EOL;

echo 'showing title after star added : ' . PHP_EOL;
$starDecorator->starTitle();
echo $decorator->showTitle(). PHP_EOL;
echo PHP_EOL;

echo 'showing title after reset: ' . PHP_EOL;
echo $decorator->resetTitle();
echo $decorator->showTitle(). PHP_EOL;
echo PHP_EOL;

echo 'END TESTING DECORATOR PATTERN';