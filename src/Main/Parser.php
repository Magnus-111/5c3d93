<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 17.06.2023
 * @license MIT
 */

namespace Main;

use Data\CrashReport;
use Data\EntityFactory;
use Data\Review;
use Helpers\AnalyseHelper;
use Helpers\FileHelpers;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * @todo: Description
 */
class Parser
{
    private array $data;

    private array $reviews;

    private array $crashReports;

    private array $unrecognized;

    private int $duplicates;

    private EntityFactory $entityFactory;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->reviews = [];
        $this->crashReports = [];
        $this->unrecognized = [];
        $this->duplicates = 0;
        $this->entityFactory = new EntityFactory();
    }

    /**
     * @todo: Description
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @todo: Description
     * @param array $data
     * @return void
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @todo: Description
     * @return array
     */
    public function getReviews(): array
    {
        return $this->reviews;
    }

    /**
     * @todo: Description
     * @return array
     */
    public function getCrashReports(): array
    {
        return $this->crashReports;
    }

    /**
     * @param OutputFormatterStyle $consoleStyler
     * @return void
     * @throws \Exception
     * @todo: Description
     */
    public function analyseData(OutputFormatterStyle $consoleStyler): void {
        $uniqueEntries = [];
        foreach ($this->data as $row) {
            $description = strtolower($row["description"]);
            $uuid = sha1(strtolower($description));

            if (!in_array($uuid, $uniqueEntries)) {

                $uniqueEntries[] = $uuid;

                $consoleStyler->setBackground("green");
                $consoleStyler->setForeground("black");

                $entity = $this->entityFactory->factory($row);
                if ($entity instanceof Review) {
                    $this->reviews[] = $entity;
                    echo $consoleStyler->apply("The number {$row['number']} define as \"przegląd\".".PHP_EOL);
                } else if ($entity instanceof CrashReport) {
                    $this->crashReports[] = $entity;
                    echo $consoleStyler->apply("The number {$row['number']} define as \"zgłoszenie awarii\"." . PHP_EOL);
                } else {
                    $this->unrecognized[] = $row;
                    echo $consoleStyler->apply("The number {$row['number']} did not have a match." . PHP_EOL);
                }

            } else {
                $consoleStyler->setBackground("bright-yellow");
                $consoleStyler->setForeground("black");
                $this->duplicates++;
                echo $consoleStyler->apply("The number {$row['number']} is duplicate. Same description.".PHP_EOL);
            }
        }

        FileHelpers::saveToFile(
            json_encode($this->reviews),
            __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."output/review_list.json"
        );

        FileHelpers::saveToFile(
            json_encode($this->crashReports),
            __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."output/crashRaport_list.json"
        );

        FileHelpers::saveToFile(
            json_encode($this->unrecognized),
            __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."output/unrecognized_list.json"
        );
    }

    /**
     * @todo: Description
     * @return int
     */
    public function countReviews(): int
    {
        return count($this->reviews);
    }

    /**
     * @todo: Description
     * @return int
     */
    public function countCrashReports(): int
    {
        return count($this->crashReports);
    }

    /**
     * @todo: Description
     * @return int
     */
    public function countDuplicates(): int
    {
        return $this->duplicates;
    }

    /**
     * @todo: Description
     * @return int
     */
    public function sizeData(): int
    {
        return count($this->data);
    }

    /**
     * @todo: Description
     * @return int
     */
    public function countUnrecognized(): int
    {
        return count($this->unrecognized);
    }
}