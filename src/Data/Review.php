<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 22.06.2023
 * @license MIT
 */

namespace Data;

class Review extends Entity
{

    private string $reviewDate;

    private string $weekOfYear;

    private string $serviceRecommendations;

    public function __construct($description, $reviewDate, $weekOfYear, $status, $serviceRecommendations, $clientPhone)
    {
        $this->type = 'przegląd';
        $this->creationDate = date("Y-m-d H:i:s");
    }

    function jsonSerialize(): array
    {
        return [
            "opis" => $this->description,
            "typ" => $this->type,
            "data przeglądu" => $this->reviewDate,
            "tydzień w roku daty przeglądu" => $this->weekOfYear,
            "status" => $this->status,
            "zalecenia dalszej obsługi po przeglądzie" => $this->serviceRecommendations,
            "numer telefonu osoby do kontaktu po stronie klienta" => $this->clientPhone,
            "data utworzenia" => $this->creationDate
        ];
    }
}