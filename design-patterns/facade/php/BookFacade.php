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

class CaseReverseFacade
{
    public static function reverseStringCase(string $stringIn): string
    {
        $arrayFromString = ArrayStringFunctions::stringToArray($stringIn);
        $reversedCaseArray = ArrayCaseReverse::reverseCase($arrayFromString);
        $reversedCaseString = ArrayStringFunctions::arrayToString($reversedCaseArray);

        return $reversedCaseString;
    }
}

class ArrayCaseReverse
{
    private static array $uppercase_array =
            ['A', 'B', 'C', 'D', 'E', 'F',
            'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'Q', 'R',
            'S', 'T', 'U', 'V', 'W', 'X',
            'Y', 'Z'];

    private static array $lowercase_array =
            ['a', 'b', 'c', 'd', 'e', 'f',
            'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'o', 'p', 'q', 'r',
            's', 't', 'u', 'v', 'w', 'x',
            'y', 'z'];

    public static function reverseCase(array $arrayIn): array
    {
        $array_out = array();
        for ($x = 0; $x < count($arrayIn); $x++) {
            if (in_array($arrayIn[$x], self::$uppercase_array)) {
                $key = array_search($arrayIn[$x], self::$uppercase_array);
                $array_out[$x] = self::$lowercase_array[$key];
            } elseif (in_array($arrayIn[$x], self::$lowercase_array)) {
                $key = array_search($arrayIn[$x], self::$lowercase_array);
                $array_out[$x] = self::$uppercase_array[$key];
            } else {
                $array_out[$x] = $arrayIn[$x];
            }
        }
        return $array_out;
    }
}

class ArrayStringFunctions
{
    public static function arrayToString(array $arrayIn): string
    {
        $string_out = NULL;
        foreach ($arrayIn as $oneChar) {
            $string_out .= $oneChar;
        }
        return $string_out;
    }

    public static function stringToArray(string $stringIn): array
    {
        return str_split($stringIn);
    }
}


echo 'BEGIN TESTING FACADE PATTERN' . PHP_EOL;
echo PHP_EOL;

$book = new Book('Design Patterns', 'Gamma, Helm, Johnson, and Vlissides');

echo 'Original book title: '.$book->getTitle() . PHP_EOL;
echo PHP_EOL;

$bookTitleReversed = CaseReverseFacade::reverseStringCase($book->getTitle());

echo 'Reversed book title: ' . $bookTitleReversed . PHP_EOL;
echo PHP_EOL;

echo 'END TESTING FACADE PATTERN';