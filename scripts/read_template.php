<?php
require __DIR__ . '/../vendor/autoload.php';
use PhpOffice\PhpWord\IOFactory;

$templatePath = __DIR__ . '/../IndaNovikepriani_2422019.docx';

if (!file_exists($templatePath)) {
    die("Template file not found!\n");
}

echo "=== READING TEMPLATE STRUCTURE ===\n\n";
echo "File: " . $templatePath . "\n";
echo "Size: " . round(filesize($templatePath) / 1024, 2) . " KB\n\n";

$template = IOFactory::load($templatePath);

$count = 0;
$styles = [];

foreach ($template->getSections() as $i => $section) {
    $count++;
    echo "=== SECTION " . ($i+1) . " ===\n";
    $elmCount = 0;
    foreach ($section->getElements() as $j => $element) {
        $elmCount++;
        $className = get_class($element);
        $shortName = substr($className, strrpos($className, '\\') + 1);
        
        $text = '';
        
        try {
            if ($shortName === 'Text') {
                $text = $element->getText();
            } elseif ($shortName === 'TextRun' || $shortName === 'Paragraph' || $shortName === 'ListItem') {
                $texts = [];
                foreach ($element->getElements() as $el) {
                    if (method_exists($el, 'getText')) {
                        $texts[] = substr($el->getText(), 0, 60);
                    }
                }
                $text = implode(' | ', $texts);
            } elseif ($shortName === 'Title') {
                $text = $element->getText();
            } elseif ($shortName === 'Image') {
                $text = '[IMAGE: ' . basename($element->getSource()) . ']';
            }
        } catch (\Exception $e) {
            $text = '[error: ' . $e->getMessage() . ']';
        }
        
        $truncated = mb_strlen($text) > 80 ? mb_substr($text, 0, 80) . '...' : $text;
        echo "  $elmCount. $shortName: \"$truncated\"\n";
        
        if ($elmCount >= 80) {
            echo "  ...(more elements)...\n";
            break;
        }
    }
    echo "\n";
    if ($count >= 10) {
        echo "...(more sections)...\n";
        break;
    }
}

echo "\nDONE. Total sections scanned: $count\n";
