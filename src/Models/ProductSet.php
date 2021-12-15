<?php

namespace Bamboo\ImportData\Models;

use Bamboo\ImportData\Models\Transforms\AsCategoryTrait;

class ProductSet extends BaseModel
{
    use AsCategoryTrait;

    protected $table = 'ct_products_Sets';

    protected $fillable = [
        'name',
        'parent_id',
        'options',
        'department_id',
        'bamboo_inventory_type',
        'bamboo_source_inventory_type',
        'price',
        'units',
        'order_weight',
        'prices_by',
        'product_size',
        'inventory_by',
        'store',
        'status',
        'status_active',
        'excel_color',
        'internal_tracking_id',
    ];

    public function parent()
    {
        return $this->belongsTo(ProductSet::class, 'parent_id');
    }
}
