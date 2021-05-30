<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductVariationStockView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            create view product_variation_stock_view AS
            select product_variations.product_id as product_id, product_variations.id as product_variation_id,
            COALESCE(sum(stocks.quantity), 0) - COALESCE(orders.order_quantity, 0) as stock,
            case when COALESCE(sum(stocks.quantity), 0) - COALESCE(orders.order_quantity, 0) > 0
                then 'TRUE'
                else 'FALSE'
            end as in_stock
            from product_variations
            LEFT JOIN stocks on product_variations.id = stocks.product_variation_id
            LEFT JOIN (select sum(product_variation_order.quantity) as order_quantity,
            product_variation_id from product_variation_order GROUP BY product_variation_id) as orders on orders.product_variation_id = product_variations.id
            GROUP BY product_variations.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS product_variation_stock_view');
    }
}
