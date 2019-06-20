<?php

declare(strict_types=1);

class SimpleBook
{
    private string $author;
    private string $title;

    public function __construct(string $authorIn, string $titleIn)
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
}

class BookAdapter
{
    private SimpleBook $book;

    public function __construct(SimpleBook $bookIn)
    {
        $this->book = $bookIn;
    }

    public function getAuthorAndTitle(): string
    {
        return $this->book->getTitle().' by '.$this->book->getAuthor();
    }
}

// client
echo 'BEGIN TESTING ADAPTER PATTERN' . PHP_EOL;
echo PHP_EOL;

$book = new SimpleBook("Gamma, Helm, Johnson, and Vlissides", "Design Patterns");
$bookAdapter = new BookAdapter($book);
echo 'Author and Title: '.$bookAdapter->getAuthorAndTitle() . PHP_EOL;
echo PHP_EOL;

echo 'END TESTING ADAPTER PATTERN';