<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 22.06.2023
 * @license MIT
 */

namespace Data;

use JsonSerializable;

abstract class Entity implements JsonSerializable
{
    protected string $description;
    protected string $type;
    protected string $status;
    protected string $creationDate;
    protected ?string $clientPhone;

    /**
     * @param string|null $dueDate
     * @return string|null
     */
    abstract protected function defineStatus(?string $dueDate): ?string;
    abstract public function jsonSerialize(): array;
}