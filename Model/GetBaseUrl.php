<?php
/**
 * Copyright (c) 2021. All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\Seo\Model;

use Hryvinskyi\SeoApi\Api\GetBaseUrlInterface;
use Magento\Framework\UrlInterface;

class GetBaseUrl implements GetBaseUrlInterface
{
    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * GetBaseUrl constructor.
     *
     * @param UrlInterface $url
     */
    public function __construct(UrlInterface $url)
    {
        $this->url = $url;
    }

    /**
     * @inheritDoc
     */
    public function execute(): string
    {
        $baseStoreUri = parse_url($this->url->getUrl(), PHP_URL_PATH);

        if ($baseStoreUri === '/') {
            return $_SERVER['REQUEST_URI'];
        }

        $requestUri = $_SERVER['REQUEST_URI'];
        $prepareUri = str_replace($baseStoreUri, '', $requestUri);

        if (isset($prepareUri[0]) && $prepareUri[0] === '/') {
            return $prepareUri;
        }

        return '/' . $prepareUri;
    }
}
