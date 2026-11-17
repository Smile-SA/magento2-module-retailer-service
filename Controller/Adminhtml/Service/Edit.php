<?php

declare(strict_types=1);

namespace Smile\RetailerService\Controller\Adminhtml\Service;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\RetailerService\Controller\Adminhtml\AbstractService;

/**
 * Retailer Service Adminhtml Edit controller.
 */
class Edit extends AbstractService implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        $serviceId = (int) $this->getRequest()->getParam('id');
        $isExistingService = (bool) $serviceId;

        if ($isExistingService) {
            try {
                $service = $this->serviceRepository->get($serviceId);
                $this->coreRegistry->register('current_service', $service);

                $resultPage = $this->createPage();
                $resultPage->getConfig()->getTitle()->prepend(
                    __('Edit service %1 ', $service->getId())
                );
                $resultPage->addBreadcrumb(__('Service'), __('Service'));

                return $resultPage;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while editing the service.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('*/*/index');

                return $resultRedirect;
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);

        return $resultForward->forward('create');
    }
}
