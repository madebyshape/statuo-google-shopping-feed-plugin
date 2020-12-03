<?php

namespace statuo\GoogleShoppingFeed\models;

use craft\base\Model;

class Settings extends Model
{
    public string $shoppingFeed = '/feeds/products/google';
    public string $id = 'sku';
    public ?int $siteId = null;
    public string $title = 'title';
    public string $price = 'price';
    public string $availability = 'in stock';
    public ?string $description = null;
    public ?string $image_link = null;
    public ?string $brand = null;
    public ?string $brandCustom = null;
    public ?string $currencyIso = null;
    public ?string $mpn = null;

    public function rules(): array
    {
        return [
            ['shoppingFeed', 'required'],
            ['description', 'required'],
            ['image_link', 'required'],
            ['brand', 'required'],
        ];
    }
}
