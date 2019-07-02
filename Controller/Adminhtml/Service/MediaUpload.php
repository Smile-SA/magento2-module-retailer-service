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
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Smile\RetailerService\Api\ServiceRepositoryInterface;
use Smile\RetailerService\Api\Data\ServiceInterfaceFactory;
use Smile\RetailerService\Ui\Component\Form\FileUploader\FileProcessor;

/**
 * RetailerService Adminhtml MediaUpload controller.
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class MediaUpload extends AbstractService
{
    /**
     * @var FileProcessor
     */
    protected $fileProcessor;

    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'Smile_RetailerService::retailer_services';

    /**
     * Abstract constructor.
     *
     * @param Context                    $context           Application context
     * @param PageFactory                $resultPageFactory Result Page factory
     * @param Registry                   $coreRegistry      Application registry
     * @param ServiceRepositoryInterface $serviceRepository Service Repository
     * @param ServiceInterfaceFactory    $serviceFactory    Service Factory
     * @param FileProcessor              $fileProcessor     File processor
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        ServiceRepositoryInterface $serviceRepository,
        ServiceInterfaceFactory $serviceFactory,
        FileProcessor $fileProcessor
    ) {
        $this->fileProcessor = $fileProcessor;

        parent::__construct($context, $resultPageFactory, $coreRegistry, $serviceRepository, $serviceFactory);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $result = $this->fileProcessor->saveToTmp(key($_FILES));
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
