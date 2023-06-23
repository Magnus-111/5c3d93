<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 17.06.2023
 * @license MIT
 */

namespace Main;

use Data\EntityFactory;
use Helpers\AnalyseHelper;
use Helpers\FileHelpers;

/**
 * @todo: Description
 */
class Parser
{
    private array $data;

    private array $reviews;

    private array $crashReports;

    private array $unrecognized;

    private EntityFactory $entityFactory;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->reviews = [];
        $this->crashReports = [];
        $this->unrecognized = [];
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
     * @return void
     * @throws \Exception
     * @todo: Description
     */
    public function analyseData(): void {
        $uniqueEntries = [];
        foreach ($this->data as $row) {
            $description = strtolower($row["description"]);
            $uuid = sha1(strtolower($description));

            if (!in_array($uuid, $uniqueEntries)) {

                $uniqueEntries[] = $uuid;

                if (AnalyseHelper::define($description, '/(.*)przegląd(.*)/')) {
                    $this->reviews[] = $this->entityFactory->factory("review", $row);
                    echo "Numer {$row['number']} określono jako przegląd.".PHP_EOL;
                    continue;
                }

                if (AnalyseHelper::define($description,'/(.*)awari(.*)/')) {
                    $this->crashReports[] = $this->entityFactory->factory("crashRaport", $row);
                    echo "Numer {$row['number']} określono jako zgłoszenie awarii.".PHP_EOL;
                    continue;
                }

                $this->unrecognized[] = $row;
                echo "Numer {$row['number']} nie został określony.".PHP_EOL;

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
        return $this->sizeData() - $this->countReviews() - $this->countCrashReports();
    }
}