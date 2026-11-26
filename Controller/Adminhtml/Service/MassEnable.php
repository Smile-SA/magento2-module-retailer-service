<?php

declare(strict_types=1);

namespace Smile\RetailerService\Controller\Adminhtml\Service;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Smile\RetailerService\Controller\Adminhtml\AbstractService;
use Smile\RetailerService\Model\Status\Source\IsActive;

/**
 * RetailerService Adminhtml MassEnable controller.
 */
class MassEnable extends AbstractService implements HttpPostActionInterface
{
    /**
     * Execute action
     *
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute(): Redirect
    {
        $serviceIds = $this->getRequest()->getParam('selected');
        foreach ($serviceIds as $id) {
            $model = $this->serviceRepository->get($id);
            $model->setStatus(IsActive::STATUS_ENABLED);
            $this->serviceRepository->save($model);
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been enabled.', count($serviceIds))
        );

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
