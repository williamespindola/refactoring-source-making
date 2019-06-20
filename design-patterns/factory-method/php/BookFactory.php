<?php

declare(strict_types=1);

abstract class AbstractFactoryMethod
{
    abstract public function makePHPBook(string $param): AbstractPHPBook;
}

class OReillyFactoryMethod extends AbstractFactoryMethod
{
    private string $context = 'OReilly';

    public function makePHPBook(string $param): AbstractPHPBook
    {
        switch ($param) {
            case 'us':
                $book = new OReillyPHPBook;
                break;
            case 'other':
                $book = new SamsPHPBook;
                break;
            default:
                $book = new OReillyPHPBook;
                break;
        }

        return $book;
    }
}

class SamsFactoryMethod extends AbstractFactoryMethod
{
    private string $context = 'Sams';

    public function makePHPBook(string $param): AbstractPHPBook
    {
        switch ($param) {
            case 'us':
                $book = new SamsPHPBook;
                break;
            case 'other':
                $book = new OReillyPHPBook;
                break;
            case "otherother":
                $book = new VisualQuickstartPHPBook;
                break;
            default:
                $book = new SamsPHPBook;
                break;
        }

        return $book;
    }
}

abstract class AbstractBook
{
    abstract public function getAuthor(): string;
    abstract public function getTitle(): string;
}

abstract class AbstractPHPBook
{
    private string $subject = 'PHP';
}

class OReillyPHPBook extends AbstractPHPBook
{
    private string $author;
    private string $title;
    private static string $oddOrEven = 'odd';

    public function __construct()
    {
        //alternate between 2 books
        if ('odd' != self::$oddOrEven) {
            $this->author = 'David Sklar and Adam Trachtenberg';
            $this->title  = 'PHP Cookbook';
            self::$oddOrEven = 'odd';
        }

        $this->author = 'Rasmus Lerdorf and Kevin Tatroe';
        $this->title = 'Programming PHP';
        self::$oddOrEven = 'even';
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

class SamsPHPBook extends AbstractPHPBook
{
    private static $author;
    private static $title;

    public function __construct()
    {
        //alternate randomly between 2 books
        mt_srand((int)microtime()*10000000);
        $randNum = mt_rand(0,1);

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

class VisualQuickstartPHPBook extends AbstractPHPBook
{
    private string $author;
    private string $title;

    public function __construct()
    {
        $this->author = 'Larry Ullman';
        $this->title  = 'PHP for the World Wide Web';
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

echo 'START TESTING FACTORY METHOD PATTERN' . PHP_EOL . PHP_EOL;

echo 'testing OReillyFactoryMethod' . PHP_EOL;
$factoryMethodInstance = new OReillyFactoryMethod;
testFactoryMethod($factoryMethodInstance);
echo PHP_EOL;

echo 'testing SamsFactoryMethod' . PHP_EOL;
$factoryMethodInstance = new SamsFactoryMethod;
testFactoryMethod($factoryMethodInstance);
echo PHP_EOL;

echo 'END TESTING FACTORY METHOD PATTERN' . PHP_EOL . PHP_EOL;

function testFactoryMethod(AbstractFactoryMethod $factoryMethodInstance)
{
    $phpUs = $factoryMethodInstance->makePHPBook("us");
    echo 'us php Author: '.$phpUs->getAuthor() . PHP_EOL;
    echo 'us php Title: '.$phpUs->getTitle() . PHP_EOL;

    $phpUs = $factoryMethodInstance->makePHPBook("other");
    echo 'other php Author: '.$phpUs->getAuthor() . PHP_EOL;
    echo 'other php Title: '.$phpUs->getTitle() . PHP_EOL;

    $phpUs = $factoryMethodInstance->makePHPBook("otherother");
    echo 'otherother php Author: '.$phpUs->getAuthor() . PHP_EOL;
    echo 'otherother php Title: '.$phpUs->getTitle() . PHP_EOL;
}