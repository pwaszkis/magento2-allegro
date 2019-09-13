<?php

namespace Macopedia\Allegro\Ui\AllegroOffer\Form;

use Magento\Catalog\Model\Product;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;

use Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku;

class CreateDataProvider extends DataProvider
{

    /** @var GetSalableQuantityDataBySku */
    protected $getSalableQuantityDataBySku;

    /** @var Registry */
    protected $registry;

    /**
     * CreateDataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param GetSalableQuantityDataBySku $getSalableQuantityDataBySku
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        GetSalableQuantityDataBySku $getSalableQuantityDataBySku,
        Registry $registry,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->getSalableQuantityDataBySku = $getSalableQuantityDataBySku;
        $this->registry = $registry;
    }

    /**
     * Get data
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        /** @var Product $product */
        $product = $this->registry->registry('product');
        $stock = $this->getSalableQuantityDataBySku->execute($product->getSku());

        $imageUrl = $product->getMediaGalleryImages()->getFirstItem()->getUrl();

        $this->_loadedData[$product->getId()] = [
            'allegro' => [
                'product' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'images' => $imageUrl ? [$imageUrl] : [],
                'qty' => $stock[0]['qty']
            ]
        ];

        return $this->_loadedData;
    }
}
