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

namespace Smile\RetailerService\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Smile\RetailerService\Api\ServiceRepositoryInterface;
use Smile\RetailerService\Api\Data\ServiceInterfaceFactory;

/**
 * Abstract Controller for retailer service management.
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
abstract class AbstractService extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Smile_RetailerService::retailer_services';

    /**
     * @var \Magento\Framework\View\Result\PageFactory|null
     */
    protected $resultPageFactory = null;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Service Repository
     *
     * @var ServiceRepositoryInterface
     */
    protected $serviceRepository;

    /**
     * Service Factory
     *
     * @var ServiceInterfaceFactory
     */
    protected $serviceFactory;

    /**
     * Abstract constructor.
     *
     * @param Context                    $context           Application context
     * @param PageFactory                $resultPageFactory Result Page factory
     * @param Registry                   $coreRegistry      Application registry
     * @param ServiceRepositoryInterface $serviceRepository Service Repository
     * @param ServiceInterfaceFactory    $serviceFactory    Service Factory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        ServiceRepositoryInterface $serviceRepository,
        ServiceInterfaceFactory $serviceFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry      = $coreRegistry;
        $this->serviceRepository = $serviceRepository;
        $this->serviceFactory    = $serviceFactory;

        parent::__construct($context);
    }

    /**
     * Create result page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function createPage()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Smile_RetailerService::retailer_services')
            ->addBreadcrumb(__('Sellers'), __('Retailers'), __('Services'));

        return $resultPage;
    }
}
