<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 22.06.2023
 * @license MIT
 */

namespace Data;

use JetBrains\PhpStorm\ArrayShape;

class Review extends Entity
{

    private string $reviewDate;

    private string $weekOfYear;

    private string $serviceRecommendations;

    public function __construct($description, $reviewDate, $clientPhone)
    {
        $this->description = $description;
        $this->reviewDate = $reviewDate;
        $this->weekOfYear = date("W",  strtotime($reviewDate));
        $this->clientPhone = $clientPhone;
        $this->type = 'przegląd';
        $this->status = $this->defineStatus($reviewDate);
        $this->serviceRecommendations = "";
        $this->creationDate = date("Y-m-d H:i:s");
    }

    /**
     * @return array
     */
    #[ArrayShape(["opis" => "string", "typ" => "string", "data przeglądu" => "string", "tydzień w roku daty przeglądu" => "string", "status" => "string", "zalecenia dalszej obsługi po przeglądzie" => "string", "numer telefonu osoby do kontaktu po stronie klienta" => "string", "data utworzenia" => "string"])]
    public function jsonSerialize(): array
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

    /**
     * @param $dueDate
     * @return string
     */
    protected function defineStatus($dueDate): string
    {
        if (!empty($dueDate)) {
            return "zaplanowano";
        }

        return "nowy";
    }
}