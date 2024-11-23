<?php

namespace Develtio\ZonesHewalex\Synology;

use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Filesystem;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_Synology
 */
class ZH_Synology
{
    const OFFER_FORMS_PATH = '/stage_hewalex/offer_forms';

    const ALLOWED_PATHS = [
        self::OFFER_FORMS_PATH,
    ];

    /** @var \League\Flysystem\Filesystem */
    private $filesystem;

    public function __construct()
    {
        //if (!in_array($rootPath, self::ALLOWED_PATHS)) {
        //  throw new \League\Flysystem\NotSupportedException('Not allowed root path');
        //}

        $this->filesystem = new Filesystem(
            new Ftp([
                'host' => SYNOLOGY_HOST,
//                'host' => '213.5.249.215',
                'username' => SYNOLOGY_USERNAME,
                'password' => SYNOLOGY_PASSWORD,
                'root' => '/stage_hewalex/offer_forms',
                'ssl' => false
            ])
        );
    }

    public function has($path)
    {
        return $this->filesystem->has($path);
    }

    public function read($path)
    {
        return $this->filesystem->read($path);
    }

    public function readStream($path)
    {
        return $this->filesystem->readStream($path);
    }

    public function listContents($directory = '', $recursive = false)
    {
        return $this->filesystem->listContents($directory, $recursive);
    }

    public function getMetadata($path)
    {
        return $this->filesystem->getMetadata($path);
    }

    public function getSize($path)
    {
        return $this->filesystem->getSize($path);
    }

    public function getMimetype($path)
    {
        return $this->filesystem->getMimetype($path);
    }

    public function getTimestamp($path)
    {
        return $this->filesystem->getTimestamp($path);
    }

    public function getVisibility($path)
    {
        return $this->filesystem->getVisibility($path);
    }

    public function write($path, $contents, array $config = [])
    {
        return $this->filesystem->write($path, $contents, $config);
    }

    public function writeStream($path, $resource, array $config = [])
    {
        return $this->filesystem->writeStream($path, $resource, $config);
    }

    public function update($path, $contents, array $config = [])
    {
        return $this->filesystem->update($path, $contents, $config);
    }

    public function updateStream($path, $resource, array $config = [])
    {
        return $this->filesystem->updateStream($path, $resource, $config);
    }

    public function rename($path, $newpath)
    {
        return $this->filesystem->rename($path, $newpath);
    }

    public function copy($path, $newpath)
    {
        return $this->filesystem->copy($path, $newpath);
    }

    public function delete($path)
    {
        return $this->filesystem->delete($path);
    }

    public function deleteDir($dirname)
    {
        return $this->filesystem->deleteDir($dirname);
    }

    public function createDir($dirname, array $config = [])
    {
        return $this->filesystem->createDir($dirname, $config);
    }

    public function setVisibility($path, $visibility)
    {
        return $this->filesystem->setVisibility($path, $visibility);
    }

    public function put($path, $contents, array $config = [])
    {
        return $this->filesystem->put($path, $contents, $config);
    }

    public function putStream($path, $resource, array $config = [])
    {
        return $this->filesystem->putStream($path, $resource, $config);
    }

    public function readAndDelete($path)
    {
        return $this->filesystem->readAndDelete($path);
    }

    public function get($path, \League\Flysystem\Handler $handler = null)
    {
        return $this->filesystem->get($path, $handler);
    }

    public function addPlugin(\League\Flysystem\PluginInterface $plugin)
    {
        return $this->filesystem->addPlugin($plugin);
    }
}