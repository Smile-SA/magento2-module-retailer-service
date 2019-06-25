<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\RetailerService
 * @author    Fanny DECLERCK <fadec@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */
namespace Smile\RetailerService\Controller\Adminhtml\Service;

use Smile\RetailerService\Controller\Adminhtml\AbstractService;

/**
 * Delete Controller for Service
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Delete extends AbstractService
{
    /**
     * {@inheritdoc}
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
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
    }
}
