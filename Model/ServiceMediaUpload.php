<?php

declare(strict_types=1);

namespace Smile\RetailerService\Model;

use Exception;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Smile\RetailerService\Api\Data\ServiceInterface;

/**
 * ServiceMediaUpload Model
 */
class ServiceMediaUpload
{
    /**
     * Image Uploader.
     */
    protected ImageUploader $imageUploader;

    /**
     * Directory List.
     */
    protected DirectoryList $directoryList;

    /**
     * Core file storage database
     */
    protected Database $coreFileStorageDatabase;

    /**
     * Media directory object (writable).
     */
    protected WriteInterface $mediaDirectory;

    /**
     * ServiceMediaUpload constructor.
     *
     * @param ImageUploader $imageUploader           Image uploader
     * @param DirectoryList $directoryList           Directory List.
     * @param Database      $coreFileStorageDatabase File Storage Database.
     * @param Filesystem    $filesystem              File System.
     * @throws FileSystemException
     */
    public function __construct(
        ImageUploader $imageUploader,
        DirectoryList $directoryList,
        Database $coreFileStorageDatabase,
        Filesystem $filesystem
    ) {
        $this->imageUploader           = $imageUploader;
        $this->directoryList           = $directoryList;
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->mediaDirectory          = $filesystem->getDirectoryWrite(
            DirectoryList::MEDIA
        );
    }

    /**
     * Remove media From Tmp Directory.
     *
     * @param ServiceInterface $service Service.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function removeMediaFromTmp(ServiceInterface $service): void
    {
        $media = str_replace($service->getRetailerId() . '_', '', (string) $service->getMediaPath());
        $baseTmpPath = $this->imageUploader->getBaseTmpPath();
        if (!empty($media) && $this->pathExist($baseTmpPath, $media)) {
            $this->moveFileFromTmp($media, $service);
        }
    }

    /**
     * Move media From Tmp Directory.
     *
     * @param string           $imageName Image name.
     * @param ServiceInterface $service   Service.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function moveFileFromTmp(string $imageName, ServiceInterface $service): void
    {
        $baseTmpPath = $this->imageUploader->getBaseTmpPath();
        $basePath = $this->imageUploader->getBasePath();

        $baseImagePath = $this->imageUploader->getFilePath(
            $basePath,
            $service->getRetailerId() . '_' . $imageName
        );
        $baseTmpImagePath = $this->imageUploader->getFilePath($baseTmpPath, $imageName);

        try {
            $this->coreFileStorageDatabase->copyFile(
                $baseTmpImagePath,
                $baseImagePath
            );
            $this->mediaDirectory->renameFile(
                $baseTmpImagePath,
                $baseImagePath
            );
        } catch (Exception $e) {
            throw new LocalizedException(
                __('Something went wrong while saving the file(s).')
            );
        }
    }

    /**
     * Remove File.
     *
     * @param ServiceInterface $service Service.
     * @throws FileSystemException
     */
    public function removeMedia(ServiceInterface $service): void
    {
        $media = $service->getRetailerId() . '_' . $service->getMediaPath();
        $basePath = $this->imageUploader->getBasePath();
        if ($service->getMediaPath() && $this->pathExist($basePath, $media)) {
            $this->removeFile($media);
        }
    }

    /**
     * Check if media exist.
     *
     * @param string $basePath Base Path.
     * @param string $fileName File Name.
     * @throws FileSystemException
     */
    public function pathExist(string $basePath, string $fileName): bool
    {
        return file_exists($this->getPath($basePath, $fileName));
    }

    /**
     * Get media Path.
     *
     * @param string $basePath Base Path.
     * @param string $fileName File Name.
     * @throws FileSystemException
     */
    public function getPath(string $basePath, string $fileName): string
    {
        return $this->directoryList->getPath(DirectoryList::MEDIA) .
            '/'
            . $this->imageUploader->getFilePath($basePath, $fileName);
    }

    /**
     * Remove File.
     *
     * @param string $fileName File Name.
     * @throws FileSystemException
     */
    public function removeFile(string $fileName): void
    {
        unlink($this->getPath($this->imageUploader->getBasePath(), $fileName));
    }
}
