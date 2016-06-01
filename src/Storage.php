<?php

namespace SCollins\LaravelExpose;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class Storage
{
    protected $files;
    protected $folder;
    protected $gc_probability = 5;

    public function __construct($files, string $folder = null)
    {
        $this->files = $files;
        if (isset($folder)) {
            $this->folder = $folder;
        }
    }

    public function setFolder(string $folder)
    {
        $this->folder = $folder;
    }

    public function getFolder()
    {
        return $this->folder;
    }

    public function createStorage()
    {
        if (!$this->files->isDirectory($this->folder)) {
            if ($this->files->makeDirectory($this->folder, 0777, true)) {
                $this->files->put($this->folder . '/.gitignore', "*\n!.gitignore");
            } else {
                throw new \IOException('Cannot create cache folder ' . $this->folder);
            }
        }

        if (!$this->files->isWritable($this->folder)) {
            throw new \IOException('Cannot write to cache folder' . $this->folder);
        }
    }

    /**
     * Randomly check if we should collect old files
     */
    public function garbageCollect()
    {
        if (rand(1, 100) <= $this->gc_probability) {
            $this->clearDirectory();
        }
    }

    /**
     * Delete files older then a certain age (gc_lifetime)
     */
    protected function clearDirectory()
    {
        foreach (Finder::create()->files()->name('*.cache')->in($this->folder) as $file) {
            $this->files->delete($file->getRealPath());
        }
    }
}
