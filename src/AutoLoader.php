<?php
namespace Elevator;


class AutoLoader
{
    private $prefixes = array();

    /**
     * @param string $prefix
     * @param string $baseDir
     */
    public function addPrefix($prefix, $baseDir)
    {
        $prefix = trim($prefix, '\\').'\\';
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $this->prefixes[] = array($prefix, $baseDir);
    }

    /**
     * @param string $className
     *
     * @return string|null
     */
    public function findFile($className)
    {
        $className = ltrim($className, '\\');
        foreach ($this->prefixes as $current) {
            list($currentPrefix, $currentBaseDir) = $current;
            if (0 === strpos($className, $currentPrefix)) {
                $classWithoutPrefix = substr($className, strlen($currentPrefix));
                $file = $currentBaseDir . str_replace('\\', DIRECTORY_SEPARATOR, $classWithoutPrefix) . '.php';
                if (file_exists($file)) {
                    return $file;
                }
            }
        }
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function loadClass($className)
    {
        $file = $this->findFile($className);
        if (null !== $file) {
            require $file;

            return true;
        }

        return false;
    }

    /**
     * Registers this instance as an autoloader.
     *
     * @param bool $prepend
     */
    public function register($prepend = false)
    {
        spl_autoload_register(array($this, 'loadClass'), true, $prepend);
    }
}
