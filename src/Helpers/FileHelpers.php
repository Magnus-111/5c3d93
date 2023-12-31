<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 17.06.2023
 * @license MIT
 */

namespace Helpers;

use \Exception;

/**
 * @todo: Description
 */
class FileHelpers
{
    private string $resourcePath;

    /**
     * Constructor FileHelper
     *
     * @param string $resourcePath
     */
    public function __construct(string $resourcePath)
    {
        $this->resourcePath = $resourcePath;
    }

    /**
     * @todo: Description
     * @return string
     */
    public function getResourcePath(): string
    {
        return $this->resourcePath;
    }

    /**
     * @todo: Description
     * @param string $resourcePath
     */
    public function setResourcePath(string $resourcePath): void
    {
        $this->resourcePath = $resourcePath;
    }

    /**
     * @todo: Przenieść do ValidationHelper, pomyśleć o Dependenci Injection.
     * @todo: Description
     * @return void
     */
    private function validatePath() {

    }

    /**
     * @return mixed|void
     * @throws Exception
     */
    public function loadFromJsonFile() {
        $file = pathinfo($this->resourcePath);

        $data = [];

        $contentFile = file_get_contents($this->resourcePath);

        if (empty($contentFile)) {
            throw new Exception("Warning: File is empty.");
        }

        switch ($file['extension']) {
            case 'json': {
                $data = json_decode($contentFile, true);

                if (json_last_error() != JSON_ERROR_NONE) {
                    throw new Exception("Wrong data in file. Content is not correct JSON.");
                }

                return $data;
            }
            default:
                break;
        }
    }

    /**
     * @todo: Description
     * @throws \Exception
     */
    public function loadFiles($extension): array
    {

        $resource = glob($this->resourcePath.DIRECTORY_SEPARATOR."*.$extension");

        $data = [];
        foreach ($resource as $file) {
            $contentsFile = file_get_contents($file);

            if (empty($contentFile)) {
                throw new Exception("Warning: File is empty.");
            }

            if (strtolower($extension) == 'json') {
                // @todo: przerobić, by funkcja była uniwersalna pod pliki, a nie miała zaimplementowane czytanie JSON.
                $data[] = json_decode($contentsFile, true);

                if (json_last_error() != JSON_ERROR_NONE) {
                    throw new Exception("Wrong data in file. Content is not correct JSON.");
                }

                continue;
            }

            throw new Exception("Notice: Unsupported file extension.");

        }

        return $data;
    }

    /**
     * @param $data
     * @param $path
     * @return void
     */
    public static function saveToFile($data, $path): void
    {
        try {
            $file = fopen($path, "w");
            fwrite($file, $data);
            fclose($file);
        } catch (\Exception $e) {
            echo $e->getMessage().PHP_EOL;
        }
    }
}