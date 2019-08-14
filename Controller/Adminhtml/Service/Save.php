<?php
/**
 * DISCLAIMER
 *
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

use Smile\RetailerService\Api\Data\ServiceInterface;
use Smile\RetailerService\Controller\Adminhtml\AbstractService;

/**
 * Retailer Service Adminhtml Save controller.
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Save extends AbstractService
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data         = $this->getRequest()->getPostValue();
        $redirectBack = $this->getRequest()->getParam('back', false);

        if ($data) {
            $identifier = $this->getRequest()->getParam('service_id');
            $retailerIds = $this->getRequest()->getParam('retailer_id', false);

            $media = false;
            if (!empty($data[ServiceInterface::MEDIA_PATH])) {
                $media = $data[ServiceInterface::MEDIA_PATH][0]['name'];
            }

            /** @var \Smile\RetailerService\Api\Data\ServiceInterface $model*/
            $model = $this->serviceFactory->create();

            if ($identifier) {
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
                    $model->setMediaPath($retailerId. '_' .$media);
                }

                try {
                    $this->serviceRepository->save($model);
                    $model = $this->serviceFactory->create();
                    $this->messageManager->addSuccessMessage(__('You saved the service %1.', $model->getName()));
                    $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);

                    if ($redirectBack) {
                        return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                    }
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                    $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);

                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
            }

            return $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect->setPath('*/*/');
    }
}
