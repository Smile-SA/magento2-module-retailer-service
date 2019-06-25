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

namespace Smile\RetailerService\Block\Adminhtml\Service\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Smile\RetailerService\Block\Adminhtml\Service\Edit\AbstractButton;

/**
 * SaveAndContinue class
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class SaveAndContinue extends AbstractButton implements ButtonProviderInterface
{
    /**
     * get the button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label'          => __('Save and Continue Edit'),
            'class'          => 'save',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'saveAndContinueEdit']],
                'form-role' => 'save'
            ],
            'sort_order'     => 80,
        ];
    }
}
