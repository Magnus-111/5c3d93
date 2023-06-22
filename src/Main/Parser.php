<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 17.06.2023
 * @license MIT
 */

namespace Main;

/**
 * @todo: Description
 */
class Parser
{
    private array $data;

    private array $reviews;

    private array $crashReports;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->reviews = [];
        $this->crashReports = [];
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
     * @todo: Description
     * @return void
     */
    public function analyseData(): void {
        $uniqueEntries = [];
        foreach ($this->data as $row) {
            $description = strtolower($row["description"]);
            $uuid = sha1(strtolower($description));

            if (!in_array($uuid, $uniqueEntries)) {

                $uniqueEntries[] = $uuid;

                if ($this->defineEntity($description, '/(.*)przegląd(.*)/')) {
                    $this->reviews[] = $row;
                    echo "Numer {$row['number']} określono jako przegląd.".PHP_EOL;
                    continue;
                }

                if ($this->defineEntity($description,'/(.*)awari(.*)/' )) {
                    $this->crashReports = $row;
                    echo "Numer {$row['number']} określono jako zgłoszenie awarii.".PHP_EOL;
                    continue;
                }

                echo "Numer {$row['number']} nie został określony.".PHP_EOL;

            }
        }
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

    /**
     * @param $description
     * @param $pattern
     * @return bool
     */
    private function defineEntity($description, $pattern): bool
    {
        preg_match_all($pattern, $description, $matches, PREG_SET_ORDER);

        return count($matches) > 0;
    }

    private function defineStatus($date)
    {
        
    }

    private function definePriority()
    {

    }

    private function createReview($data) {
        return [

        ];
    }

    private function createCrash($data) {
        return [

        ];
    }
}