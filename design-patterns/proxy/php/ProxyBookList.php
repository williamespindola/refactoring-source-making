<?php

class ProxyBookList
{
    private ?BookList $bookList = null;

    public function getBookCount(): int
    {
        if (NULL === $this->bookList) {
            $this->makeBookList();
        }

        return $this->bookList->getBookCount();
    }

    public function addBook(Book $book): int
    {
        if (NULL === $this->bookList) {
            $this->makeBookList();
        }

        return $this->bookList->addBook($book);
    }

    public function getBook($bookNum): Book
    {
        if (NULL === $this->bookList) {
            $this->makeBookList();
        }

        return $this->bookList->getBook($bookNum);
    }

    public function removeBook($book): int
    {
        if (NULL === $this->bookList) {
            $this->makeBookList();
        }

        return $this->bookList->removeBook($book);
    }

    //Create
    public function makeBookList(): void
    {
        $this->bookList = new BookList();
    }
}

class BookList
{
    private array $books = [];

    private int $bookCount = 0;

    public function getBookCount(): int
    {
        return $this->bookCount;
    }

    private function setBookCount($newCount): void
    {
        $this->bookCount = $newCount;
    }

    public function getBook(int $bookNumberToGet): ?Book
    {
        if ((is_numeric($bookNumberToGet))
            && ($bookNumberToGet <= $this->getBookCount())
        ) {
            return $this->books[$bookNumberToGet];
        }

        return NULL;
    }

    public function addBook(Book $bookIn): int
    {
        $this->setBookCount($this->getBookCount() + 1);
        $this->books[$this->getBookCount()] = $bookIn;
        return $this->getBookCount();
    }

    public function removeBook(Book $bookIn): int
    {
        $counter = 0;

        while (++$counter <= $this->getBookCount()) {
            if ($bookIn->getAuthorAndTitle() == $this->books[$counter]->getAuthorAndTitle()) {
                for ($x = $counter; $x < $this->getBookCount(); $x++) {
                    $this->books[$x] = $this->books[$x + 1];
                }
                $this->setBookCount($this->getBookCount() - 1);
            }
        }

        return $this->getBookCount();
    }
}

final class Book
{
    private string $author;

    private string $title;

    function __construct(string $titleIn, string $authorIn)
    {
        $this->author = $authorIn;
        $this->title  = $titleIn;
    }

    function getAuthor(): string
    {
        return $this->author;
    }

    function getTitle(): string
    {
        return $this->title;
    }

    function getAuthorAndTitle(): string
    {
        return $this->getTitle().' by '.$this->getAuthor();
    }
}

echo 'BEGIN TESTING PROXY PATTERN' . PHP_EOL;
echo PHP_EOL;

$proxyBookList = new ProxyBookList();
$inBook = new Book('PHP for Cats', 'Larry Truett');
$proxyBookList->addBook($inBook);

echo 'test 1 - show the book count after a book is added' . PHP_EOL;
echo $proxyBookList->getBookCount() . PHP_EOL;
echo PHP_EOL;

echo 'test 2 - show the book' . PHP_EOL;
$outBook = $proxyBookList->getBook(1);
echo $outBook->getAuthorAndTitle() . PHP_EOL;
echo PHP_EOL;

$proxyBookList->removeBook($outBook);

echo 'test 3 - show the book count after a book is removed' . PHP_EOL;
echo $proxyBookList->getBookCount() . PHP_EOL;
echo PHP_EOL;

echo 'END TESTING PROXY PATTERN' . PHP_EOL;
