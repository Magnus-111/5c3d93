<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 22.06.2023
 * @license MIT
 */

namespace Data;

use Helpers\AnalyseHelper;
use Helpers\ValidationHelper;
use JetBrains\PhpStorm\ArrayShape;

class CrashReport extends Entity
{
    private string $priority;
    private ?string $dateServiceVisit;

    private string $commentService;

    public function __construct($description, $dateServiceVisit, $clientPhone)
    {
        $this->description = $description;
        $this->dateServiceVisit = ValidationHelper::isValidDate($dateServiceVisit) ? $dateServiceVisit : null;
        $this->priority = $this->definePriority($description);
        $this->clientPhone = $clientPhone;
        $this->type = "zgłoszenie awarii";
        $this->status = $this->defineStatus($dateServiceVisit);
        $this->commentService = "";
        $this->creationDate = date("Y-m-d H:i:s");
    }

    /**
     * @param $description
     * @return string
     */
    private function definePriority($description): string
    {
        if (AnalyseHelper::define($description, '/(.*)bardzo piln(.*)/')) {
            return "krytyczny";
        }

        if (AnalyseHelper::define($description, '/(.*)piln(.*)/')) {
            return "wysoki";
        }

        return "normalny";
    }

    /**
     * @return array
     */
    #[ArrayShape(["opis" => "string", "typ" => "string", "priorytet" => "string", "termin wizyty serwisu" => "string", "status" => "string", "uwagi serwisu" => "string", "numer telefonu osoby do kontaktu po stronie klienta" => "string", "data utworzenia" => "string"])]
    public function jsonSerialize(): array
    {
        return [
            "opis" => $this->description,
            "typ" => $this->type,
            "priorytet" => $this->priority,
            "termin wizyty serwisu" => $this->dateServiceVisit,
            "status" => $this->status,
            "uwagi serwisu" => $this->commentService,
            "numer telefonu osoby do kontaktu po stronie klienta" => $this->clientPhone,
            "data utworzenia" => $this->creationDate
        ];
    }

    /**
     * @param string|null $dueDate
     * @return string|null
     */
    protected function defineStatus(?string $dueDate): ?string
    {
        if (ValidationHelper::isValidDate($dueDate)) {
            return "termin";
        }

        return "nowy";
    }
}