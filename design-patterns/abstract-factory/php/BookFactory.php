<?php

declare(strict_types=1);

/**
 * BookFactory classes
 */
abstract class AbstractBookFactory
{
    abstract public function makePHPBook(): AbstractPHPBook;
    abstract public function makeMySQLBook(): AbstractMySQLBook;
}

class OReillyBookFactory extends AbstractBookFactory
{
    private string $context = 'OReilly';

    public function makePHPBook(): AbstractPHPBook
    {
        return new OReillyPHPBook;
    }

    public function makeMySQLBook(): AbstractMySQLBook
    {
        return new OReillyMySQLBook;
    }
}

class SamsBookFactory extends AbstractBookFactory
{
    private string $context = 'Sams';

    public function makePHPBook(): AbstractPHPBook
    {
        return new SamsPHPBook;
    }

    public function makeMySQLBook(): AbstractMySQLBook
    {
        return new SamsMySQLBook;
    }
}

/**
 *  Book classes
 */
abstract class AbstractBook
{
    abstract public function getAuthor(): string;
    abstract public function getTitle(): string;
}

abstract class AbstractMySQLBook extends AbstractBook
{
    private string $subject = 'MySQL';
}

class OReillyMySQLBook extends AbstractMySQLBook
{
    private string $author;

    private string $title;

    public function  __construct()
    {
        $this->author = 'George Reese, Randy Jay Yarger, and Tim King';
        $this->title = 'Managing and Using MySQL';
    }

    public function  getAuthor(): string
    {
        return $this->author;
    }

    public function  getTitle(): string
    {
        return $this->title;
    }
}

class SamsMySQLBook extends AbstractMySQLBook
{
    private string $author;

    private string $title;

    public function  __construct()
    {
        $this->author = 'Paul Dubois';
        $this->title = 'MySQL, 3rd Edition';
    }

    public function  getAuthor(): string
    {
        return $this->author;
    }

    public function  getTitle(): string
    {
        return $this->title;
    }
}

abstract class AbstractPHPBook extends AbstractBook
{
    private string $subject = "PHP";
}

class OReillyPHPBook extends AbstractPHPBook
{
    private string $author;

    private string $title;

    private static string $oddOrEven = 'odd';

    public function  __construct()
    {
        //alternate between 2 books
        if ('odd' != self::$oddOrEven) {
            $this->author = 'David Sklar and Adam Trachtenberg';
            $this->title = 'PHP Cookbook';
            self::$oddOrEven = 'odd';
        }

        $this->author = 'Rasmus Lerdorf and Kevin Tatroe';
        $this->title = 'Programming PHP';
        self::$oddOrEven = 'even';
    }

    public function  getAuthor(): string
    {
        return $this->author;
    }

    public function  getTitle(): string
    {
        return $this->title;
    }
}

class SamsPHPBook extends AbstractPHPBook
{
    private string $author;

    private string $title;

    public function __construct()
    {
        //alternate randomly between 2 books
        mt_srand((int)microtime() * 10000000);
        $randNum = mt_rand(0, 1);

        if (1 < $randNum) {
            $this->author = 'Christian Wenz';
            $this->title = 'PHP Phrasebook';
        }

        $this->author = 'George Schlossnagle';
        $this->title = 'Advanced PHP Programming';
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

/**
 * Initialization
 */
echo 'BEGIN TESTING ABSTRACT FACTORY PATTERN' . PHP_EOL . PHP_EOL;

echo 'testing OReillyBookFactory' . PHP_EOL;
$bookFactoryInstance = new OReillyBookFactory;
testConcreteFactory($bookFactoryInstance);

echo PHP_EOL;

echo 'testing SamsBookFactory' . PHP_EOL;
$bookFactoryInstance = new SamsBookFactory;
testConcreteFactory($bookFactoryInstance);

echo 'END TESTING ABSTRACT FACTORY PATTERN' . PHP_EOL . PHP_EOL;

function testConcreteFactory(AbstractBookFactory $bookFactoryInstance): void
{
    $phpBookOne = $bookFactoryInstance->makePHPBook();
    echo 'first php Author: ' . $phpBookOne->getAuthor() . PHP_EOL;
    echo 'first php Title: ' . $phpBookOne->getTitle() . PHP_EOL;

    $phpBookTwo = $bookFactoryInstance->makePHPBook();
    echo 'second php Author: ' . $phpBookTwo->getAuthor() . PHP_EOL;
    echo 'second php Title: ' . $phpBookTwo->getTitle() . PHP_EOL;

    $mySqlBook = $bookFactoryInstance->makeMySQLBook();
    echo 'MySQL Author: ' . $mySqlBook->getAuthor() . PHP_EOL;
    echo 'MySQL Title: ' . $mySqlBook->getTitle() . PHP_EOL;
}
