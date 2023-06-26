<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 23.06.2023
 * @license MIT
 */

namespace Data;

use Exception;
use Helpers\AnalyseHelper;

class EntityFactory implements EntityFactoryInterface
{

    /**
     * @throws Exception
     */
    public function factory(array $data): Review|CrashReport|null
    {
        extract($data);
        try {
            if (AnalyseHelper::define($description, '/(.*)przegląd(.*)/')) {
                return new Review($description, $dueDate, $phone);
            } else {
                return new CrashReport($description, $dueDate, $phone);
            }
        } catch (Exception $e) {
            return null;
        }
    }
}