<?php

declare(strict_types=1);

namespace Smile\RetailerService\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Smile\RetailerService\Api\Data\ServiceInterfaceFactory;
use Smile\RetailerService\Api\ServiceRepositoryInterface;

/**
 * Abstract Controller for retailer service management.
 *
 * @category Smile
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
abstract class AbstractService extends Action
{
    protected ?PageFactory $resultPageFactory = null;

    /**
     * Core registry
     */
    protected Registry $coreRegistry;

    /**
     * Service Repository
     */
    protected ServiceRepositoryInterface $serviceRepository;

    /**
     * Service Factory
     */
    protected ServiceInterfaceFactory $serviceFactory;

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
     */
    protected function createPage(): Page
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Smile_RetailerService::retailer_services')
            ->addBreadcrumb(__('Sellers'), __('Retailers'), __('Services'));

        return $resultPage;
    }

    /**
     * Check if allowed to manage service
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Smile_RetailerService::retailer_services');
    }
}
