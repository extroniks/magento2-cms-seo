<?php namespace Extroniks\CmsSeo\Helper;

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

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

    const XML_CONFIG_PATH_ENABLED        = 'cms_seo/general/enabled';
    const XML_CONFIG_PATH_HREF_LANG      = 'cms_seo/general/href_lang';
    const XML_CONFIG_PATH_SHARED_WEBSITE = 'cms_seo/general/shared_website';

    public function isEnabled($storeId = null) {
        return (bool) $this->scopeConfig->getValue(self::XML_CONFIG_PATH_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isSharedWebsiteEnabled() {
        return (bool) $this->scopeConfig->getValue(self::XML_CONFIG_PATH_SHARED_WEBSITE);
    }

    public function getStoreHrefLang($storeId = null) {
        if ($this->isEnabled($storeId)) {
            return $this->scopeConfig->getValue(self::XML_CONFIG_PATH_HREF_LANG, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
        }
        return null;
    }

}
