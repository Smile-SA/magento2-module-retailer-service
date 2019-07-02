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

use Magento\Framework\Controller\ResultFactory;
use Smile\RetailerService\Controller\Adminhtml\AbstractService;
use Smile\RetailerService\Model\Status\Source\IsActive;

/**
 * RetailerService Adminhtml MassEnable controller.
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class MassEnable extends AbstractService
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
            $model->setData('status', IsActive::STATUS_ENABLED);
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
