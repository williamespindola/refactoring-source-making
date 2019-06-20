<?php

declare(strict_types=1);

abstract class AbstractPageBuilder
{
    abstract public function getPage(): HTMLPage;
}

abstract class AbstractPageDirector
{
    abstract public function __construct(AbstractPageBuilder $builderIn);
    abstract public function buildPage(): void;
    abstract public function getPage(): HTMLPage;
}

class HTMLPage
{
    private string $page;
    private string $pageTitle;
    private string $pageHeading;
    private string $pageText;

    public function showPage(): string
    {
        return $this->page;
    }

    public function setTitle(string $titleIn): void
    {
        $this->pageTitle = $titleIn;
    }

    public function setHeading(string $headingIn): void
    {
        $this->pageHeading = $headingIn;
    }

    public function setText(string $textIn): void
    {
        $this->pageText .= $textIn;
    }

    public function formatPage(): void
    {
        $this->page = '<html>'
            . '<head><title>' . $this->pageTitle . '</title></head>'
            . '<body>'
            . '<h1>' . $this->pageHeading . '</h1>'
            . $this->pageText
            . '</body>'
            . '</html>';
    }
}

class HTMLPageBuilder extends AbstractPageBuilder
{
    private HTMLPage $page;

    public function __construct()
    {
        $this->page = new HTMLPage();
    }

    public function setTitle(string $titleIn): void
    {
        $this->page->setTitle($titleIn);
    }

    public function setHeading(string $headingIn): void
    {
        $this->page->setHeading($headingIn);
    }

    public function setText(string $textIn): void
    {
        $this->page->setText($textIn);
    }

    public function formatPage(): void
    {
        $this->page->formatPage();
    }

    public function getPage(): HTMLPage
    {
        return $this->page;
    }
}

class HTMLPageDirector extends AbstractPageDirector
{
    private AbstractPageBuilder $builder;

    public function __construct(AbstractPageBuilder $builderIn)
    {
        $this->builder = $builderIn;
    }

    public function buildPage(): void
    {
        $this->builder->setTitle('Testing the HTMLPage');
        $this->builder->setHeading('Testing the HTMLPage');
        $this->builder->setText('Testing, testing, testing!');
        $this->builder->setText('Testing, testing, testing, or!');
        $this->builder->setText('Testing, testing, testing, more!');
        $this->builder->formatPage();
    }

    public function getPage(): HTMLPage
    {
        return $this->builder->getPage();
    }
}

echo 'BEGIN TESTING BUILDER PATTERN' . PHP_EOL . PHP_EOL;

$pageBuilder = new HTMLPageBuilder();
$pageDirector = new HTMLPageDirector($pageBuilder);
$pageDirector->buildPage();
$page = $pageDirector->getPage();
echo $page->showPage();

echo PHP_EOL . PHP_EOL;

echo 'END TESTING BUILDER PATTERN';
