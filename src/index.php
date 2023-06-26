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

    echo $consoleStyler->apply("\t> Start work.".PHP_EOL);

    // @todo: Dodać skrypt pytający, skąd ma pobrać plik źródłowy: katalog/wpisanie ścieżki przez użytkownika.

    // $fileHelper = new FileHelpers(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."resource/data/");
    // $data = $fileHelper->loadFiles("json");

    $file = readline("Type file with JSON: ");
    $fileHelper = new FileHelpers(
        // __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."resource/data/recruitment-task-source.json"
        $file
    );
    $data = $fileHelper->loadFromJsonFile();

    $parser = new Parser($data);
    $parser->analyseData($consoleStyler);

    $consoleStyler->setBackground("cyan");
    $consoleStyler->setForeground("black");
    echo "Results: ".PHP_EOL;
    echo $consoleStyler->apply("Count - \"zgłoszenie awarii\": ".$parser->countCrashReports().PHP_EOL);
    echo $consoleStyler->apply("Count - \"przegląd\": ".$parser->countReviews().PHP_EOL);
    echo $consoleStyler->apply("Count - unrecognized: ".$parser->countUnrecognized().PHP_EOL);
    echo $consoleStyler->apply("Count - duplicates: ".$parser->countDuplicates().PHP_EOL);
    $consoleStyler->setBackground("blue");
    $consoleStyler->setForeground("black");
    echo $consoleStyler->apply("Results files are in `output` directory.".PHP_EOL);

} catch (Exception $e) {
    $consoleStyler = new OutputFormatterStyle();
    $consoleStyler->setBackground("red");
    $consoleStyler->setForeground("black");
    echo $consoleStyler->apply("\t! Error: ".$e->getMessage().PHP_EOL);
}

