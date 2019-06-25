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
use Magento\Framework\Controller\ResultFactory;

/**
 * MassDelete Controller for Service
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class MassDelete extends AbstractService
{
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $serviceIds = $this->getRequest()->getParam('selected');
        foreach ($serviceIds as $id) {
            $model = $this->serviceRepository->get($id);
            $this->serviceRepository->delete($model);
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deleted.', count($serviceIds))
        );

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
