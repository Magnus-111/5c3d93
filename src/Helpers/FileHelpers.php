<?php
/**
 * @author Cezary Jackiewicz <cjackiewicz11@gmail.com>
 * @date 17.06.2023
 * @license MIT
 */

namespace Helpers;

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
     * @todo: Description
     * @throws \Exception
     */
    public function loadFiles($extension) {

        $resource = glob($this->resourcePath.DIRECTORY_SEPARATOR."*.$extension");

        $data = "";
        foreach ($resource as $file) {
            $contentsFile = file_get_contents($file);

            // @todo: przerobić, by funkcja była uniwersalna pod pliki, a nie miała zaimplementowane czytanie JSON.
            $data = json_decode($contentsFile, true);

            if (json_last_error() != JSON_ERROR_NONE) {
                throw new \Exception("Błędny zapis w pliku. Nie zawiera formatu JSON");
            }

        }

        return $data;
    }
}