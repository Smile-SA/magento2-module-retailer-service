<?php

declare(strict_types=1);

namespace Smile\RetailerService\Controller\Adminhtml\Service;

use Exception;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Smile\RetailerService\Controller\Adminhtml\AbstractService;

/**
 * Delete Controller for Service
 */
class Delete extends AbstractService implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $identifier = $this->getRequest()->getParam('id', false);
        $model = $this->serviceFactory->create();
        if ($identifier) {
            $model = $this->serviceRepository->get($identifier);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This service no longer exists.'));

                return $resultRedirect->setPath('*/*/index');
            }
        }

        try {
            $this->serviceRepository->delete($model);
            $this->messageManager->addSuccessMessage(__('You deleted the service %1.', $model->getId()));

            return $resultRedirect->setPath('*/*/index');
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
    }
}
