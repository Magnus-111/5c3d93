<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 17.06.2023
 * @license MIT
 */

require_once(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."vendor/autoload.php");

use Helpers\FileHelpers;
use Main\Parser;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

try {
    $consoleStyler = new OutputFormatterStyle();
    $consoleStyler->setBackground("cyan");
    $consoleStyler->setForeground("black");

    echo $consoleStyler->apply("\t> Rozpoczynam prace.".PHP_EOL);

    // @todo: Dodać skrypt pytający, skąd ma pobrać plik źródłowy: katalog/wpisanie ścieżki przez użytkownika.
    $fileHelper = new FileHelpers(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."resource/data/");

    $data = $fileHelper->loadFiles("json");

    $parser = new Parser($data);
    $parser->analyseData();
    echo "Liczba zgłoszeń awarii: ".$parser->countCrashReports().PHP_EOL;
    echo "Liczba przeglądów: ".$parser->countReviews().PHP_EOL;
    echo "Liczba nieprzetworzonych: ".$parser->countUnrecognized().PHP_EOL;

} catch (Exception $e) {
    $consoleStyler = new OutputFormatterStyle();
    $consoleStyler->setBackground("red");
    $consoleStyler->setForeground("white");
    echo $consoleStyler->apply("\t! Error: ".$e->getMessage().PHP_EOL);
}

