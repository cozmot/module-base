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


namespace Cozmot\Base\Block\Adminhtml;

use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Template;

class Extensions extends Template
{
    private const COZMOT_EXTENSION_JSON_URL = 'https://cozmot.com/media/modules/modules.json';

    /**
     * @var string
     */
    protected $_template = 'Cozmot_Base::extensions.phtml';

    /**
     * @var PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * @var File
     */
    private $driverFile;

    /**
     * Extensions constructor.
     *
     * @param Template\Context $context
     * @param PriceCurrencyInterface $priceCurrency
     * @param File $driverFile
     * @param array $data
     */
    public function __construct(
        Template\Context       $context,
        PriceCurrencyInterface $priceCurrency,
        File                   $driverFile,
        array                  $data = []
    )
    {
        $this->priceCurrency = $priceCurrency;
        $this->driverFile = $driverFile;
        parent::__construct($context, $data);
    }

    /**
     * Get module data
     *
     * @return string
     */
    public function getModuleData()
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('test');
        try {
            $moduleData = '';
            $fileGet = self::COZMOT_EXTENSION_JSON_URL;
            $data = $this->driverFile->fileGetContents($fileGet);
            if ($data) {
                $moduleData = json_decode($data);
            }
        } catch (\Exception $e) {
            $moduleData = '';
        }

        return $moduleData;
    }

    /**
     * Get price
     *
     * @param float $price
     * @return string
     */
    public function getFormattedPrice($price)
    {
        return $this->priceCurrency->convertAndFormat($price, false, 0);
    }
}
