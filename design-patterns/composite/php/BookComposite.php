<?php

declare(strict_types=1);

abstract class OnTheBookShelf
{
    abstract public function getBookInfo(int $previousBook): string;
    abstract public function getBookCount(): int;
    abstract public function setBookCount(int $newCount): void;
    abstract public function addBook(OnTheBookShelf $oneBook): int;
    abstract public function removeBook(OnTheBookShelf $oneBook): int;
}

class OneBook extends OnTheBookShelf
{
    private string $title;
    private string $author;

    public function __construct(string $title, string $author)
    {
        $this->title = $title;
        $this->author = $author;
    }

    public function getBookInfo(int $bookToGet): string
    {
        if (1 == $bookToGet) {
            return $this->title." by ".$this->author;
        }
    }

    public function getBookCount(): int
    {
        return 1;
    }

    public function setBookCount($newCount): void 
    {
    }

    public function addBook(OnTheBookShelf $oneBook): int
    {
        return 0;
    }

    public function removeBook(OnTheBookShelf $oneBook): int
    {
        return 0;
    }
}

class SeveralBooks extends OnTheBookShelf
{
    private array $oneBooks = [];

    private int $bookCount;

    public function __construct()
    {
        $this->setBookCount(0);
    }

    public function getBookCount(): int
    {
        return $this->bookCount;
    }

    public function setBookCount(int $newCount): void
    {
        $this->bookCount = $newCount;
    }

    public function getBookInfo(int $bookToGet): string
    {
        if ($bookToGet <= $this->bookCount) {
            return $this->oneBooks[$bookToGet]->getBookInfo(1);
        }
    }

    public function addBook(OnTheBookShelf $oneBook): int
    {
        $this->setBookCount($this->getBookCount() + 1);
        $this->oneBooks[$this->getBookCount()] = $oneBook;

        return $this->getBookCount();
    }

    public function removeBook(OnTheBookShelf $oneBook): int
    {
        $counter = 0;
        while (++$counter <= $this->getBookCount()) {
            if ($oneBook->getBookInfo(1) ==
                $this->oneBooks[$counter]->getBookInfo(1)) {
                for ($x = $counter; $x < $this->getBookCount(); $x++) {
                    $this->oneBooks[$x] = $this->oneBooks[$x + 1];
                }
                $this->setBookCount($this->getBookCount() - 1);
            }
        }

        return $this->getBookCount();
    }
}

echo 'BEGIN TESTING COMPOSITE PATTERN' . PHP_EOL;
echo PHP_EOL;

$firstBook = new OneBook('Core PHP Programming, Third Edition', 'Atkinson and Suraski');
echo '(after creating first book) oneBook info: ' . PHP_EOL;
echo $firstBook->getBookInfo(1) . PHP_EOL;
echo PHP_EOL;

$secondBook = new OneBook('PHP Bible', 'Converse and Park');
echo '(after creating second book) oneBook info: ' . PHP_EOL;
echo $secondBook->getBookInfo(1) . PHP_EOL;
echo PHP_EOL;

$thirdBook = new OneBook('Design Patterns', 'Gamma, Helm, Johnson, and Vlissides');
echo '(after creating third book) oneBook info: ' . PHP_EOL;
echo $thirdBook->getBookInfo(1) . PHP_EOL;
echo PHP_EOL;

$books = new SeveralBooks();

$booksCount = $books->addBook($firstBook);
echo '(after adding firstBook to books) SeveralBooks info : ' . PHP_EOL;
echo $books->getBookInfo($booksCount) . PHP_EOL;
echo PHP_EOL;

$booksCount = $books->addBook($secondBook);
echo '(after adding secondBook to books) SeveralBooks info : ' . PHP_EOL;
echo $books->getBookInfo($booksCount) . PHP_EOL;
echo PHP_EOL;

$booksCount = $books->addBook($thirdBook);
echo '(after adding thirdBook to books) SeveralBooks info : ' . PHP_EOL;
echo $books->getBookInfo($booksCount) . PHP_EOL;
echo PHP_EOL;

$booksCount = $books->removeBook($firstBook);
echo '(after removing firstBook from books) SeveralBooks count : ' . PHP_EOL;
echo $books->getBookCount() . PHP_EOL;
echo PHP_EOL;

echo '(after removing firstBook from books) SeveralBooks info 1 : ' . PHP_EOL;
echo $books->getBookInfo(1) . PHP_EOL;
echo PHP_EOL;

echo '(after removing firstBook from books) SeveralBooks info 2 : ' . PHP_EOL;
echo $books->getBookInfo(2) . PHP_EOL;
echo PHP_EOL;

echo 'END TESTING COMPOSITE PATTERN';
