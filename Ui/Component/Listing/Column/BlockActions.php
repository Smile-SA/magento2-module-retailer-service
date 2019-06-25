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

namespace Smile\RetailerService\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;

/**
 * BlockActions class.
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class BlockActions extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT    = 'smile_retailer_service/service/edit';
    const URL_PATH_DELETE  = 'smile_retailer_service/service/delete';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * @param ContextInterface   $context            Application context
     * @param UiComponentFactory $uiComponentFactory Ui Component Factory
     * @param UrlInterface       $urlBuilder         URL Builder
     * @param array              $components         Components
     * @param array              $data               Component Data
     * @param string             $editUrl            Edit Url
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource The data source
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');

                if (isset($item['service_id'])) {
                    $item[$name]['edit'] = [
                        'href'  => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['service_id']]),
                        'label' => __('Edit'),
                    ];

                    $item[$name]['delete'] = [
                        'href'    => $this->urlBuilder->getUrl(
                            self::URL_PATH_DELETE,
                            ['id' => $item['service_id']]
                        ),
                        'label'   => __('Delete'),
                        'confirm' => [
                            'title'   => __('Delete ${ $.$data.name }'),
                            'message' => __('Are you sure you want to delete ${ $.$data.name } ?'),
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}
