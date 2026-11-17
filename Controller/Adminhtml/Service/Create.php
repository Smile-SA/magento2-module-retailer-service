<?php

declare(strict_types=1);

namespace Smile\RetailerService\Controller\Adminhtml\Service;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Smile\RetailerService\Controller\Adminhtml\AbstractService;

/**
 * Retailer Service Creation Controller
 */
class Create extends AbstractService implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        $this->coreRegistry->register("current_service", $this->serviceFactory->create([]));

        $resultPage = $this->createPage();

        $resultPage->setActiveMenu('Smile_RetailerService::retailer_service');
        $resultPage->getConfig()->getTitle()->prepend(__('New Retailer Service'));

        return $resultPage;
    }
}
