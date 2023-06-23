<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 23.06.2023
 * @license MIT
 */

namespace Data;

interface EntityFactoryInterface {
    public function factory(string $type, array $data);
}