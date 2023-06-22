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
        foreach ($this->data as $row) {
            if (str_contains($row["description"], "przegląd")) {
                $this->reviews[] = $row;
            } else {
                $this->crashReports = $row;
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
}