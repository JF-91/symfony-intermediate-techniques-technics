<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Product;

class ProductFactory
{
    public function create(
        null|string $title = null,
        null|string $description = null,
        null|int $price = null,
        null|string $image = null
    ): Product {
        $product = new Product();
        $product->setBase64($title);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setImage($image);

        return $product;
    }



}
