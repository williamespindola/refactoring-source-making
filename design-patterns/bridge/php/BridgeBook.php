<?php

declare(strict_types=1);

abstract class BridgeBook
{
    private string $bbAuthor;
    private string $bbTitle;
    private BridgeBookImp $bbImp;

    public function __construct(string $authorIn, string $titleIn, string $choiceIn)
    {
        $this->bbAuthor = $authorIn;
        $this->bbTitle = $titleIn;

        if ('STARS' == $choiceIn) {
            $this->bbImp = new BridgeBookStarsImp();
        } else {
            $this->bbImp = new BridgeBookCapsImp();
        }
    }

    public function showAuthor(): string
    {
        return $this->bbImp->showAuthor($this->bbAuthor);
    }

    public function showTitle():string
    {
        return $this->bbImp->showTitle($this->bbTitle);
    }
}

class BridgeBookAuthorTitle extends BridgeBook
{
    public function showAuthorTitle(): string
    {
        return $this->showAuthor() . "'s " . $this->showTitle();
    }
}

class BridgeBookTitleAuthor extends BridgeBook
{
    public function showTitleAuthor(): string
    {
        return $this->showTitle() . ' by ' . $this->showAuthor();
    }
}

abstract class BridgeBookImp
{
    abstract public function showAuthor(string $author);
    abstract public function showTitle(string $title);
}

class BridgeBookCapsImp extends BridgeBookImp
{
    public function showAuthor(string $authorIn): string 
    {
        return strtoupper($authorIn);
    }

    public function showTitle(string $titleIn):string
    {
        return strtoupper($titleIn);
    }
}

class BridgeBookStarsImp extends BridgeBookImp
{
    public function showAuthor(string $authorIn): string
    {
        return Str_replace(' ','*',$authorIn);
    }

    public function showTitle(string $titleIn): string
    {
        return Str_replace(' ','*',$titleIn);
    }
}

echo 'BEGIN TESTING BRIDGE PATTERN' . PHP_EOL;
echo PHP_EOL;

echo 'test 1 - author title with caps' . PHP_EOL;
$book = new BridgeBookAuthorTitle('Larry Truett','PHP for Cats','CAPS');
echo $book->showAuthorTitle() . PHP_EOL;
echo PHP_EOL;

echo 'test 2 - author title with stars'. PHP_EOL;
$book = new BridgeBookAuthorTitle('Larry Truett','PHP for Cats','STARS');
echo $book->showAuthorTitle() . PHP_EOL;
echo PHP_EOL;

echo 'test 3 - title author with caps' . PHP_EOL;
$book = new BridgeBookTitleAuthor('Larry Truett','PHP for Cats','CAPS');
echo $book->showTitleAuthor() . PHP_EOL;
echo PHP_EOL;

echo 'test 4 - title author with stars' . PHP_EOL;
$book = new BridgeBookTitleAuthor('Larry Truett','PHP for Cats','STARS');
echo $book->showTitleAuthor() . PHP_EOL;
echo PHP_EOL;

echo 'END TESTING BRIDGE PATTERN';