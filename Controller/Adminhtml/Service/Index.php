<?php

declare(strict_types=1);

namespace Smile\RetailerService\Controller\Adminhtml\Service;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Smile\RetailerService\Controller\Adminhtml\AbstractService;

/**
 * Index Controller for retailer service management.
 */
class Index extends AbstractService implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->createPage();
        $resultPage->getConfig()->getTitle()->prepend(__('Retailer Services List'));

        return $resultPage;
    }
}
