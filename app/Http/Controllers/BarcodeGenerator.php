<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\productBarcode;
use App\ProductVariant;
use App\Variant;
use Automattic\WooCommerce\HttpClient\Response;
use Milon\Barcode\DNS1D;
use App\Product_Warehouse;

use Picqer\Barcode\BarcodeGeneratorHTML;

class BarcodeGenerator extends Controller
{
    //
    public function generateBarcode()
    {

        $products = Product::with('productVariants')->whereNotIn('id', range(1, 10))->get(); //Change The rang according to your need
        foreach ($products as $product) {
            $product->product_barcode = null ? $product->product_barcode : mt_rand(1000000000000, 9999999999999);
            if ($product->update()) {
                $parts = explode('-', $product->name, 2);
                if (isset($parts[1])) {
                    $lastPart = $parts[1];
                    if (count($product->productVariants) > 0) {
                        foreach ($product->productVariants as $eachVariant) {
                            if ($eachVariant->sku == null && $eachVariant->barcode == null) {
                                $eachVariant->sku =  $lastPart . "-" . $eachVariant->title;
                                $eachVariant->barcode = $lastPart . "-" . $eachVariant->title . "-" . $eachVariant->title;
                                $eachVariant->update();
                            }
                        }
                    }
                }
            }
        }




        // foreach ($products as  $product) {

        //     $product = Product::findOrFail($id);
        //     if ($product && $product->product_barcode == null) {
        //         // dd("nj/");
        //         dd($product->id);
        //         $product->product_barcode = mt_rand(1000000000000, 9999999999999);
        //         $product->update();
        //     }
        // }
    }

    public function fetchBarcodeProduct()
    {
        $products = Product::pluck("id");
        // return($products);

       
        // foreach ($products as $id) {
        //     # code...
        //     $pro_warehouse = new Product_Warehouse();
        //     $pro_warehouse->product_id = $id;
        //     $pro_warehouse->warehouse_id = 1;
        //     $pro_warehouse->qty = 100;
        //     // return($pro_warehouse);
        //     $pro_warehouse->save();
        // }
        

        // die();
        $products = Product::orderBy('id', 'desc')->with('productVariants')->paginate(5);
        // $products = Product::orderBy('id', 'desc')->with('productVariants')->where('id',786)->get();
        // return($products);
        return view('backend.barcode.barcode', compact('products'));
    }
}
