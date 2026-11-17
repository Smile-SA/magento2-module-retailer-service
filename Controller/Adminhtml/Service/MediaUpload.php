<?php

declare(strict_types=1);

namespace Smile\RetailerService\Controller\Adminhtml\Service;

use Magento\Catalog\Controller\Adminhtml\Category\Image\Upload;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * RetailerService Adminhtml MediaUpload controller.
 */
class MediaUpload extends Upload implements HttpPostActionInterface
{
}
