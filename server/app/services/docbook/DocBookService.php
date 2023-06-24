<?php

class DocBookService
{
    const DEFAULT_PARAGRAPH_PATH = ROOT_DIR . '/app/services/docbook/chapters';

    public static function createDocBookDocument(): string
    {
        $doc = new DOMDocument('1.0', 'UTF-8');

        $book = $doc->createElement('book');
        $doc->appendChild($book); // Corrected line

        $title = $doc->createElement('title', 'The documentation of BOO API');
        $book->appendChild($title);

        $introductionParagraphs = explode("\n\r\n\r\n", file_get_contents(self::DEFAULT_PARAGRAPH_PATH . '/Introduction.txt'));
        $chapter = self::createChapter($doc, 'Introduction', $introductionParagraphs);
        $book->appendChild($chapter);

        $environmentAndArchitectureParagraphs = explode("\n\r\n\r\n", file_get_contents(self::DEFAULT_PARAGRAPH_PATH . '/Environment&Architecture.txt'));
        $chapter = self::createChapter($doc, 'Environment and Architecture', $environmentAndArchitectureParagraphs);
        $book->appendChild($chapter);

        $databaseParagraphs = explode("\n\r\n\r\n", file_get_contents(self::DEFAULT_PARAGRAPH_PATH . '/Database.txt'));
        $chapter = self::createChapter($doc, 'Database', $databaseParagraphs);
        $book->appendChild($chapter);

        $controllersParagraphs = explode("\n\r\n\r\n", file_get_contents(self::DEFAULT_PARAGRAPH_PATH . '/Controllers.txt'));
        $chapter = self::createChapter($doc, 'Controllers', $controllersParagraphs);
        $book->appendChild($chapter);

        $servicesParagraphs = explode("\n\r\n\r\n", file_get_contents(self::DEFAULT_PARAGRAPH_PATH . '/Services.txt'));
        $chapter = self::createChapter($doc, 'Services', $servicesParagraphs);
        $book->appendChild($chapter);

        $repositoriesParagraphs = explode("\n\r\n\r\n", file_get_contents(self::DEFAULT_PARAGRAPH_PATH . '/Repositories.txt'));
        $chapter = self::createChapter($doc, 'Repositories', $repositoriesParagraphs);
        $book->appendChild($chapter);

        return $doc->saveXML();
    }

    private static function createChapter(DOMDocument $doc, string $title, array $paragraphs): DOMElement
    {
        $chapter = $doc->createElement('chapter');
        $chapterTitleElement = $doc->createElement('title', $title);
        $chapter->appendChild($chapterTitleElement);

        foreach ($paragraphs as $paragraph) {
            $paragraph = str_replace("\r", '', $paragraph); // Remove carriage return characters
            $paragraph = str_replace('&', '&amp;', $paragraph); // Encode ampersand
            $paragraphElement = $doc->createElement('para', $paragraph);
            $chapter->appendChild($paragraphElement);
        }

        return $chapter;
    }

}
