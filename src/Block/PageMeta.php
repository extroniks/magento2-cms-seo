<?php namespace Extroniks\CmsSeo\Block;

/*
 * The MIT License
 *
 * Copyright 2019 Stefan Erakovic.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class PageMeta extends \Magento\Framework\View\Element\Template {

    /**
     *
     * @var string
     */
    protected $_template = "page/meta.phtml";

    /**
     *
     * @var \Extroniks\CmsSeo\Helper\Data
     */
    private $helper;

    /**
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     *
     * @var \Magento\Cms\Model\Page
     */
    private $cmsPage;

    public function __construct(
    \Extroniks\CmsSeo\Helper\Data $helper,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \Magento\Cms\Model\Page $cmsPage,
    \Magento\Framework\View\Element\Template\Context $context, $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper       = $helper;
        $this->storeManager = $storeManager;
        $this->cmsPage      = $cmsPage;
        $this->storeManager = $storeManager;
    }

    protected function getPageUrl($storeId) {
        return rtrim($this->storeManager->getStore($storeId)->getBaseUrl(), '/') . '/' . $this->cmsPage->getIdentifier();
    }

    protected function getStoreIds() {
        $storeIds = $this->cmsPage->getStores();

        // all stores handling
        if ((count($storeIds) == 1) && $storeIds[0] == 0) {
            $storeIds = [];
            $stores   = $this->storeManager->getStores();
            foreach ($stores as $store) {
                if (!$this->helper->isSharedWebsiteEnabled() && $store->getWebsiteId() != $this->storeManager->getStore()->getId()) {
                    continue;
                }
                $storeIds[] = $store->getId();
            }
        }

        return $storeIds;
    }

    public function getAlternatePages() {
        if (!$this->cmsPage || !$this->cmsPage->getId()) {
            return [];
        }

        $storeIds = $this->getStoreIds();
        $meta     = [];

        if (count($storeIds) > 1) {
            foreach ($storeIds as $storeId) {
                $hrefLang = $this->helper->getStoreHrefLang($storeId);
                if ($hrefLang) {
                    $meta[$hrefLang] = $this->getPageUrl($storeId);
                }
            }
        }

        return $meta;
    }

}
