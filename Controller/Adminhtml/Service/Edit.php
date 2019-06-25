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

use Magento\Framework\Exception\NoSuchEntityException;
use Smile\RetailerService\Controller\Adminhtml\AbstractService;

/**
 * Retailer Service Adminhtml Edit controller.
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Edit extends AbstractService
{
    /**
     * {@inheritdoc}
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

        $this->_forward('create');
    }
}
