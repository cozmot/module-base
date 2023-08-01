<?php
/**
 * Cozmot
 *
 * NOTICE OF LICENSE
 * This source file is subject to the cozmot.com license that is
 * available through the world-wide-web at this URL:
 * https://cozmot.com/end-user-license-agreement
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Commerce
 * @package     Module
 * @copyright   Copyright (c) Cozmot (https://cozmot.com/)
 * @license     https://cozmot.com/end-user-license-agreement
 *
 */

namespace Cozmot\Base\Observer;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Cozmot\Base\Helper\Data;
use Cozmot\Base\Model\Feed;

class GetCozmotUpdate implements ObserverInterface
{
    /**
     * @var Session
     */
    protected $backendAuthSession;

    /**
     * @var AbstractData
     */
    protected $helper;

    /**
     * GetCozmotUpdate constructor.
     *
     * @param Session $backendAuthSession
     * @param Data $helper
     */
    public function __construct(
        Session $backendAuthSession,
        Data    $helper
    )
    {
        $this->backendAuthSession = $backendAuthSession;
        $this->helper = $helper;
    }

    /**
     * Get updates
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->backendAuthSession->isLoggedIn()
            && $this->helper->isModuleOutputEnabled('Magento_AdminNotification')) {
            /* @var $feedModel Feed */
            $feedModel = $this->helper->createObject(Feed::class);
            $feedModel->checkUpdate();
        }
    }
}
