<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 23.06.2023
 * @license MIT
 */

namespace Data;

use Exception;

class EntityFactory implements EntityFactoryInterface
{

    /**
     * @throws Exception
     */
    public function factory(string $type, array $data): Review|CrashReport
    {
        extract($data);
        if ($type == 'review') {
            return new Review($description, $dueDate, $phone);
        }

        if ($type == 'crashRaport') {
            return new CrashReport($description, $dueDate, $phone);
        }

        throw new Exception("Unrecognized type of entity.");
    }
}