<?php

declare(strict_types=1);

namespace Smile\RetailerService\Controller\Adminhtml\Service;

use Exception;
use Magento\Backend\Model\Session;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Smile\RetailerService\Api\Data\ServiceInterface;
use Smile\RetailerService\Controller\Adminhtml\AbstractService;

/**
 * Retailer Service Adminhtml Save controller.
 */
class Save extends AbstractService implements HttpPostActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        /** @var \Magento\Framework\App\Request\Http $request */
        $request      = $this->getRequest();
        $data         = $request->getPostValue();
        $redirectBack = $this->getRequest()->getParam('back', false);

        if ($data) {
            $identifier = $this->getRequest()->getParam('service_id');
            $retailerIds = $this->getRequest()->getParam('retailer_id', false);

            $media = false;
            if (!empty($data[ServiceInterface::MEDIA_PATH])) {
                $media = $data[ServiceInterface::MEDIA_PATH][0]['name'];
            }

            /** @var \Smile\RetailerService\Model\Service $model */
            $model = $this->serviceFactory->create();

            if ($identifier) {
                /** @var \Smile\RetailerService\Model\Service $model */
                $model = $this->serviceRepository->get($identifier);
                $retailerIds = [$model->getRetailerId()];
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This service no longer exists.'));

                    return $resultRedirect->setPath('*/*/');
                }
            }

            foreach ($retailerIds as $retailerId) {
                $model->setData($data);
                $model->setRetailerId($retailerId);

                if ($media) {
                    $model->setMediaPath($retailerId . '_' . $media);
                }

                try {
                    $this->serviceRepository->save($model);
                    $this->messageManager->addSuccessMessage(__('You saved the service %1.', $model->getName()));
                    $this->_objectManager->get(Session::class)->setFormData(false);

                    if ($redirectBack) {
                        return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                    }

                    $model = $this->serviceFactory->create();
                } catch (Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                    $this->_objectManager->get(Session::class)->setFormData($data);

                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
            }

            return $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect->setPath('*/*/');
    }
}
