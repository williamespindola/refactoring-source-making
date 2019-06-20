<?php

declare(strict_types=1);

/**
 * Singleton classes
 */
class BookSingleton
{
    private string $author = 'Gamma, Helm, Johnson, and Vlissides';
    private string $title = 'Design Patterns';
    private static ?BookSingleton $book = null;
    private static bool $isLoanedOut = FALSE;

    private function __construct()
    {
    }

    public static function borrowBook(): ?BookSingleton
    {
        if (TRUE == self::$isLoanedOut) {
            return NULL;
        }

        if (NULL == self::$book) {
            self::$book = new BookSingleton();
        }
        self::$isLoanedOut = TRUE;
        return self::$book;
    }

    public function returnBook(BookSingleton $bookReturned): void
    {
        self::$isLoanedOut = FALSE;
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
        return $this->getTitle() . ' by ' . $this->getAuthor();
    }
}

class BookBorrower
{
    private ?BookSingleton $borrowedBook = null;
    private bool $haveBook = FALSE;

    public function __construct()
    {
    }

    public function getAuthorAndTitle(): string
    {
        if (TRUE == $this->haveBook) {
            return $this->borrowedBook->getAuthorAndTitle();
        }

        return "I don't have the book";
    }

    public function borrowBook(): void
    {
        $this->borrowedBook = BookSingleton::borrowBook();
        $this->haveBook = TRUE;

        if ($this->borrowedBook == NULL) {
            $this->haveBook = FALSE;
        }
    }

    public function returnBook(): void
    {
        $this->borrowedBook->returnBook($this->borrowedBook);
    }
}

/**
 * Initialization
 */
echo 'BEGIN TESTING SINGLETON PATTERN' . PHP_EOL . PHP_EOL;

$bookBorrower1 = new BookBorrower();
$bookBorrower2 = new BookBorrower();

$bookBorrower1->borrowBook();
echo 'BookBorrower1 asked to borrow the book' . PHP_EOL;
echo 'BookBorrower1 Author and Title: ' . PHP_EOL;
echo $bookBorrower1->getAuthorAndTitle() . PHP_EOL;
echo PHP_EOL;

$bookBorrower2->borrowBook();
echo 'BookBorrower2 asked to borrow the book' . PHP_EOL;
echo 'BookBorrower2 Author and Title: ' . PHP_EOL;
echo $bookBorrower2->getAuthorAndTitle() . PHP_EOL;
echo PHP_EOL;

$bookBorrower1->returnBook();
echo 'BookBorrower1 returned the book';
echo PHP_EOL. PHP_EOL;

$bookBorrower2->borrowBook();
echo 'BookBorrower2 Author and Title: ' . PHP_EOL;
echo $bookBorrower1->getAuthorAndTitle() . PHP_EOL;
echo PHP_EOL;

echo 'END TESTING SINGLETON PATTERN';