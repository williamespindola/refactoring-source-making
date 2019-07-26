<?php

declare(strict_types=1);

final class FlyweightBook
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

final class FlyweightFactory
{
    private array $books = [];

    public function __construct()
    {
        $this->books[1] = NULL;
        $this->books[2] = NULL;
        $this->books[3] = NULL;
    }

    public function getBook(int $bookKey): FlyweightBook
    {
        if (NULL === $this->books[$bookKey]) {
            $makeFunction = 'makeBook' . $bookKey;
            $this->books[$bookKey] = $this->$makeFunction(); 
        }

        return $this->books[$bookKey];
    }

    /**
     * Sort of an long way to do this, but hopefully easy to follow.
     * How you really want to make flyweights would depend on what
     * your application needs.  This, while a little clumsy looking,
     * does work well.
     */
    public function makeBook1(): FlyweightBook
    {
        $book = new FlyweightBook('Larry Truett', 'PHP For Cats');

        return $book;
    }

    public function makeBook2(): FlyweightBook
    {
        $book = new FlyweightBook('Larry Truett', 'PHP For Dogs');

        return $book;
    }

    public function makeBook3(): FlyweightBook
    {
        $book = new FlyweightBook('Larry Truett', 'PHP For Parakeets');

        return $book;
    }
}

class FlyweightBookShelf
{
    private array $books = [];

    public function addBook(FlyweightBook $book): void
    {
        $this->books[] = $book;
    }

    public function showBooks(): string
    {
        $return_string = NULL;

        foreach ($this->books as $book) {
            $return_string .= 'title: "'
                . $book->getAuthor()
                . ' author: '
                . $book->getTitle()
                . '"'
                . PHP_EOL;
        };

        return $return_string;
    }
}

echo 'BEGIN TESTING FLYWEIGHT PATTERN' . PHP_EOL;
echo PHP_EOL;

$flyweightFactory = new FlyweightFactory();
$flyweightBookShelf1 = new FlyweightBookShelf();
$flyweightBook1 = $flyweightFactory->getBook(1);
$flyweightBookShelf1->addBook($flyweightBook1);
$flyweightBook2 = $flyweightFactory->getBook(1);
$flyweightBookShelf1->addBook($flyweightBook2);

echo 'test 1 - show the two books are the same book' . PHP_EOL;

if ($flyweightBook1 === $flyweightBook2) {
    echo '1 and 2 are the same' . PHP_EOL;
} else {
    echo '1 and 2 are not the same' . PHP_EOL;
}
echo PHP_EOL;

echo 'test 2 - with one book on one self twice' . PHP_EOL;
echo $flyweightBookShelf1->showBooks() . PHP_EOL;
echo PHP_EOL;

$flyweightBookShelf2 = new FlyweightBookShelf();
$flyweightBook1 = $flyweightFactory->getBook(2);
$flyweightBookShelf2->addBook($flyweightBook1);
$flyweightBookShelf1->addBook($flyweightBook1);

echo 'test 3 - book shelf one' . PHP_EOL;
echo $flyweightBookShelf1->showBooks() . PHP_EOL;
echo PHP_EOL;

echo 'test 3 - book shelf two' . PHP_EOL;
echo $flyweightBookShelf2->showBooks() . PHP_EOL;
echo PHP_EOL;

echo 'END TESTING FLYWEIGHT PATTERN' . PHP_EOL;
