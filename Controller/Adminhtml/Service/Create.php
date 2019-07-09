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
 * Retailer Service Creation Controller
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Create extends AbstractService
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->coreRegistry->register("current_service", $this->serviceFactory->create([]));

        $resultPage = $this->createPage();

        $resultPage->setActiveMenu('Smile_Seller::retailer_service');
        $resultPage->getConfig()->getTitle()->prepend(__('New Retailer Service'));

        return $resultPage;
    }
}
