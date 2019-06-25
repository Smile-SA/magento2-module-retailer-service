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
 * Back class
 *
 * @category Smile
 * @package  Smile\RetailerService
 * @author   Fanny DECLERCK <fadec@smile.fr>
 */
class Back extends AbstractButton implements ButtonProviderInterface
{
    /**
     * get the button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label'      => __('Back'),
            'on_click'   => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class'      => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}
