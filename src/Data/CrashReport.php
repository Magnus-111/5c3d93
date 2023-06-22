<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 22.06.2023
 * @license MIT
 */

namespace Data;

class CrashReport extends Entity
{
    private string $priority;
    private string $dateServiceVisit;

    private string $commentService;

    public function __construct($description, $priority, $dateServiceVisit, $status, $commentService, $clientPhone)
    {
        $this->type = "zgłoszenie awarii";
        $this->creationDate = date("Y-m-d H:i:s");
    }

    function jsonSerialize(): array
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
}