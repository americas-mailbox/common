<?php
declare(strict_types=1);

namespace AMB\Transformer;

use IamPersistent\Money\Interactor\MoneyToArray;
use IamPersistent\SimpleShop\Entity\Product;

final class TransformProduct
{
    public function transform(Product $product): array
    {
        return [
            'categories'  => $this->getCategories($product),
            'description' => $product->getDescription(),
            'id'          => $product->getId(),
            'name'        => $product->getName(),
            'price'       => (new MoneyToArray())($product->getPrice()),
        ];
    }

    private function getCategories(Product $product): array
    {
        $categories = [];
        $productCategories = $product->getCategories();
        foreach ($productCategories as $category) {
            $categories[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
            ];
        }

        return $categories;
    }
}

