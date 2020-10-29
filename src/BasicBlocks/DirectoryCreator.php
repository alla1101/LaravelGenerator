<?php

namespace Alla\Generator\BasicBlocks;

use Illuminate\Filesystem\Filesystem;

class DirectoryCreator
{

    private $base_directory = "";

    private $folders_map = [];

    private $filesystem;

    public function __construct($filesystem = null)
    {
        $this->filesystem = is_null($filesystem) ? new Filesystem : $filesystem;
    }

    public function createFolders()
    {
        $dir_arr = $this->changeFoldersMapIntoDirectories($this->base_directory, $this->folders_map);

        foreach ($dir_arr as $directory) {
            $this->createFolder($directory);
        }
    }

    private function createFolder(string $directory)
    {
        if ($this->filesystem->missing($directory)) {
            $this->filesystem->makeDirectory($directory);
        }
    }

    /**
     * Recursive function to map the
     *
     * @param string $base
     * @param array $folders
     * @return array
     */
    private function changeFoldersMapIntoDirectories(string $base, array $folders): array
    {
        $result = [];

        foreach ($folders as $key => $folder) {
            if (!is_array($folder)) {
                $result[] = $base . "/" . $folder;
                continue;
            }
            $result[] = $base . "/" . $key;
            $mini_result = $this->changeFoldersMapIntoDirectories($base . "/" . $key, $folder);
            $result = array_merge($result, $mini_result);
        }

        return $result;
    }

    /**
     * Get the value of base_directory
     */
    public function getBaseDirectory()
    {
        return $this->base_directory;
    }

    /**
     * Set the value of base_directory
     *
     * @return  self
     */
    public function setBaseDirectory(string $base_directory)
    {
        if (!$this->filesystem->isDirectory($base_directory)) {
            throw new \Exception($base_directory . " is Not A Directory");
        }

        $this->base_directory = $base_directory;

        return $this;
    }

    /**
     * Get the value of folders
     */
    public function getFoldersMap()
    {
        return $this->folders_map;
    }

    /**
     * Set the value of folders
     *
     * @return  self
     */
    public function setFoldersMap(array $folders_map)
    {
        $this->folders_map = $folders_map;

        return $this;
    }
}
