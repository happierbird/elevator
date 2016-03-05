<?php
namespace Elevator\Services;

use InvalidArgumentException;


final class ConfigurationReader
{
    /**
     * Avoid instantiation.
     */
    private function __construct()
    {
    }

    /**
     * @param string $jsonFile file location.
     *
     * @throws InvalidArgumentException
     *
     * @return mixed[]
     */
    public static function readFromJsonFile($jsonFile)
    {
        if (!is_file($jsonFile)) {
            throw new InvalidArgumentException(sprintf('The file %s does not exist!', $jsonFile));
        }

        return json_decode(file_get_contents($jsonFile), true);
    }
}