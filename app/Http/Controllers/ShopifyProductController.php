<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductPayload;
use App\ProductVariant;
use App\Services\HttpService;

use Illuminate\Support\Facades\Http;
use Gnikyt\BasicShopifyAPI\BasicShopifyAPI;
use Gnikyt\BasicShopifyAPI\Options;
use Gnikyt\BasicShopifyAPI\Session;

use App\Product;
use App\ProductOtion;
use App\CronLog;
use App\ProductImage;
use App\Category;
use App\ShopifyClass;
use Illuminate\Support\Facades\DB;
class ShopifyProductController extends Controller
{


    public function saveProduct(){
        ini_set('max_execution_time', 1800); //3 minutes

      $productStrings = ProductPayload::all()->where('status','false');

      foreach($productStrings as $productString) {
        
       $updatePayload = ProductPayload::findOrFail($productString->id);
       $updatePayload->status = "1";
       $updatePayload->save();

         $vendor_id = $productString->vendor_id;

              $payload = json_decode($productString['payload'], true);

               $ProductData = $payload;
             
               // dd($ProductData);
           //   foreach ($payload['products'] as $ProductData) {
                 $ProductExists = Product::where('product_id',$ProductData['id'])->get();
                 if(count($ProductExists) == 0){
                //  dd($ProductData);
                     $Product  = new Product();
                     $Product->product_id          = $ProductData['id'] ;
                     $Product->vendor           = $ProductData['vendor'] ;
                     $Product->handle         = $ProductData['handle'];
                     $Product->title               = $ProductData['title'] ;
                     $Product->product_type        = $ProductData['product_type'] ;
                     $Product->status              = 'inactive'/*$ProductData['status']*/ ;
                     $Product->tags                = $ProductData['tags'] ;
                     $Product->variants            = count($ProductData['variants']) ;
                     $Product->images              = count($ProductData['images']);
                     $Product->name               = $ProductData['title'] ;
                     $Product->code               = $ProductData['id'] ;
                     $Product->type               = "Standard" ;
                     $Product->barcode_symbology               = "Code 128" ;
                     $Product->category_id     =12;
                     $Product->unit_id =7;
                     $Product->purchase_unit_id =1;
                     $Product->sale_unit_id =1;
                     $Product->save();
                     $VariantData=$ProductData['variants'];

                   $totalStock = 0;
                    foreach($VariantData as $variant){
              
                        $Variant             = new ProductVariant();
                        $Variant->product_id = $Product->id ;
                        $Variant->shopify_product_id = $Product->shopify_product_id ;
                        $Variant->title      = $variant['title'] ;
                        $Variant->price      = $variant['price']  ;
                        $Variant->sku        = $variant['sku'] ;
                        $Variant->admin_graphql_api_id       = $variant['admin_graphql_api_id'] ;
                        $Variant->size    = $variant['title'] ;
                        $Variant->barcode    = $variant['barcode'] ;
                        $Variant->weight     = $variant['weight'] ;
                        $Variant->weight_unit = $variant['weight_unit'] ;
                        $Variant->qty = $variant['inventory_quantity'] ;
                        $Variant->inventory_quantity     = $variant['inventory_quantity'] ;
                        $Variant->old_inventory_quantity     = $variant['old_inventory_quantity'] ;
                        $Variant->inventory_item_id     = $variant['inventory_item_id'] ;
                        $Variant->requires_shipping     = $variant['requires_shipping'] ;
                        $Variant->taxable     = $variant['taxable'] ;
                        $Variant->fulfillment_service     = $variant['fulfillment_service'] ;
                        $Variant->image_id     = $variant['image_id'] ;
                        $Variant->shopify_variant_id     = $variant['id'];


                        $Variant->save();


                        $totalStock += $variant['inventory_quantity'];

                     }

                     $ImageData=$ProductData['images'];

                        foreach($ImageData as $img){
                            
                           $Image          = new ProductImage();

                           $Image->shopify_product_id    = $img['product_id'];
                           $Image->product_id    = $Product->id;
                           $Image->position      = $img['position'];
                           $Image->src           = $img['src'];
                           $Image->width      = $img['width'];
                           $Image->height           = $img['height'];
                           $Image->admin_graphql_api_id           = $img['admin_graphql_api_id'];
                             $Image->save();
                        }
                    $optionsData=$ProductData['options'];
                   
                    foreach($optionsData as $options){
                       
                        foreach($options['values'] as $values){
                           
                        $option        = new ProductOtion();
                        $option->product_id        = $Product->id;
                        $option->variant_name        = $options['name'];
                        $option->shopify_product_id        = $options['product_id'];
                        $option->position        = $options['position'];
                        $option->values        = $values;
                        $option->shopify_option_id        = $options['id'];
                        $option->save();

                        
                        }

                    }
                    //  $Product->stock = $totalStock;
                     $Product->save();

                   }


                 }
           //   }


           return json_encode(array('status'=>'200','message'=>'Processed'));



    }
    public function fetchProducts(){
        
        ini_set('max_execution_time', 1800); //3 minutes

        $accessToken  = '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';
        // $vendorID  = $vendor->id;
        $storeName    =  'pakistan-fashion-lounge';
        $pID = 1;
        $sinceID = 0;
        // dd($accessToken,$vendorID,$storeName);
        $productsCount = ShopifyClass::shopify_call($accessToken, $storeName, "/admin/api/2023-04/products/count.json", array(), 'GET',array("Content-Type: application/json"));
        $productsCount = json_decode($productsCount['response'], true);
       $totalProducts = $productsCount['count'];


        $i = 0;
        $iT = ($totalProducts / 250);
        $sinceID = 0;
        for ($i=0; $i <= $iT; $i++) { 

          $prs = ShopifyClass::shopify_call($accessToken, $storeName, "/admin/products.json", array('since_id'=>$sinceID,'limit'=>'250'), 'GET',array("Content-Type: application/json"));

          $response = json_decode($prs['response'], true);
          // dd($response);

          $products = $response['products'];
          foreach($products as $product){
            //   dd($product);
            $pID = $product['id'];
            $prCheck = ProductPayload::where('product_id',$pID)->where('subject','upload')->first();

              if(!isset($prCheck->id)){
                  // dd($prCheck,$vendorID);
                $iProduct = new ProductPayload();
                $iProduct->product_id = $product['id'];
                $iProduct->subject    = 'upload';
                $iProduct->payload    = json_encode($product);

                $iProduct->save();




                }
             }


          $prs = ShopifyClass::shopify_call($accessToken, $storeName, "/admin/products.json", array('since_id'=>$sinceID,'limit'=>'250'), 'GET',array("Content-Type: application/json"));

          $response = json_decode($prs['response'], true);
          $products = $response['products'];
          foreach($products as $product){
              //  dd($product);
                $pID = $product['id'];
                $prCheck = ProductPayload::where('product_id',$pID)->where('subject','upload')->first();

                if(!isset($prCheck->id)){
                    // dd($prCheck,$vendorID);
                  $iProduct = new ProductPayload();
                  $iProduct->product_id = $product['id'];
                  $iProduct->subject    = 'upload'; 
                  $iProduct->payload    = json_encode($product);

                  $iProduct->save();

                }

          }

          $sinceID = $pID;

          echo count($products) ." products found". "last product id is $pID <hr>";

         }

    }
 
    public function collection(){
          $accessToken  = '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';
          // $vendorID  = $vendor->id;
          $storeName    =  'pakistan-fashion-lounge';

          $pID = 1;
          $sinceID = 0;
          // dd($accessToken,$vendorID,$storeName);

          $collectionCount = ShopifyClass::shopify_call($accessToken, $storeName, "/admin/smart_collections.json", array(), 'GET',array("Content-Type: application/json"));   
          $collectionCount = json_decode($collectionCount['response'], true);

          foreach($collectionCount as $collects){

            foreach($collects as $col){

              $collect = new Collection();
              $collect->handle = $col['handle'];
              $collect->title = $col['title'];
              $collect->sort_order = $col['sort_order'];
              $collect->published_scope = $col['published_scope'];
              $collect->admin_graphql_api_id = $col['admin_graphql_api_id'];
              $collect->collection_id = $col['id'];
              $collect->save();
            }
        }

      }

      
    public function updateProduct(){
      $esdate = date("Y-m-d")." 00:00:00";
      $eedate = date("Y-m-d")." 03:00:00";
      $cron_logs= new CronLog();
      $cron_logs->cron_name='Upload to shopify';
      $cron_logs->expected_start_time='Every hour';
      $cron_logs->expected_end_time='-';
      $cron_logs->save();
      $config = array(
      'ShopUrl' => 'pakistan-fashion-lounge.myshopify.com',
      'AccessToken' => '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',
       );

   $shopify = ShopifySDK::config($config);
   dd($shopify);
    ShopifySDK::config($apiKey, $apiPassword);
    ShopifySDK::setShopUrl($shopUrl);
dd(ShopifySDK::config($apiKey, $apiPassword));

 
  // $products = $db->query("SELECT * FROM fm_products_new where shopify_id=? AND pcode !=?",0 ,'')->fetchAll();
      // print_r(count($products));exit;
  foreach($products as $product){

    $sizes = array();
    $variantsArray = array();
    $imagArray = array();
    $name = $product->title;
    $discription = $product->discription;
    $tags = array_filter(explode(",", $product->category));
    $colorTag = array();
    $variants=FmProductVariantsNew::where('product_id',$product->id)->get();
    // $variants = $db->query("SELECT * FROM fm_product_variants_new WHERE product_id=?", $product['id'])->fetchAll();

    $sizesList = array();
    foreach($variants as $var){
      $colorTag []= 'color-'.$var->color;
      if($var->size != ''){
        $sizes[] = $var->size;
      }
      if(trim($var->size) == 'S'){
        $var->size = 'Small'; 
      }
      if(trim($var->size) == 'M'){
        $var->size = 'Medium'; 
      }
      if(trim($var->size) == 'L'){
        $var->size = 'Large'; 
      }
      if(trim($var->size) == 'XS'){
        $var->size = 'Extra Small'; 
      }
      if(trim($var->size) == 'XL'){
        $var->size = 'Extra Large'; 
      }
      if(trim($var->size) == 'XXL'){
        $var->size = 'Double Extra Large'; 
      }
      $weight = ($var->weight > 0) ? $var->weight : 0.5;
      if($var->compare_price > 0 && $var->size != ''){

        $variantsArray[] = array(
          'price' => $var->compare_price,
          'compare_price' => $var->price,
          'option1' => $var->size,
          "barcode"=> $product->pcode,
          "sku" => $var->barcode,
          "fulfillment_service"=> "manual",
          "grams"=> $weight * 1000,
          'weight' => $weight,
          "weight_unit"=> "kg",
          "inventory_management"=> "shopify",
          "inventory_policy"=> "deny",
          "inventory_quantity"=> $var->stock,
          "position"=> 1,
        );
      }else if($var->size != ''){
        $variantsArray[] = array(
          'price' => $var->price,
          'option1' => $var->size,
          "barcode"=> $product->pcode,
          "sku" => $var->barcode,
          "fulfillment_service"=> "manual",
          "grams"=> $weight * 1000,
          'weight' => $weight,
          "weight_unit"=> "kg",
          "inventory_management"=> "shopify",
          "inventory_policy"=> "deny",
          "inventory_quantity"=> $var->stock,
          "position"=> 1,
        );
      }

    }
    //dd($sizes, $variantsArray);
    $images = scandir('fm-images/'.$product->pcode);
    // dd($images,$product->pcode);
    unset($images[0]);
    unset($images[1]);
    $totalImages = count($images);
    $cnt3 = 1;
    foreach($images as $img){
      $imagArray[]=asset('fm-images/'.$product->pcode.'/'.$product->pcode.'-'.$cnt3.'.jpeg');
      // $imagArray[] = array("src"=> "https://shopify.unze.com.pk/fm-images/".$product->pcode."/".$product->pcode."-".$cnt3.".jpeg");
      
      $cnt3++;
    }
    $tags=array_merge($tags,$colorTag);
    // dd($tags);
    $productToUpload = array(
      "title" => ($name == '') ? $product->pcode: $name,
      "body_html" =>  $discription,
      "vendor" =>  "Unze London",
      "product_type" =>  "",
      "tags" =>  array_values(array_unique($tags)),
      "options" =>  array(
        array(
          "name"=> "Size",
          "values" => array_values(array_unique($sizes))
        )
      ),
      "variants" => $variantsArray,
      "images" => $imagArray

    );
              //dd($productToUpload);
    $productsUploaded = $shopify->Product->post($productToUpload);
             //dd($productsUploaded);
    if(isset($productsUploaded['id'])){
      $update=FmProductNew::where('pcode',$product->pcode)->first();
      $update->shopify_id=$productsUploaded['id'];
      $update->save();
      // $update = $db->query("UPDATE fm_products_new SET shopify_id=? WHERE pcode=?", $productsUploaded['id'], $product['pcode']);

      foreach($productsUploaded['variants'] as $variant){
        $fm_product_variants_new=FmProductVariantsNew::where('barcode', $variant['sku'])->first();
        $fm_product_variants_new->variant_id=$variant['id'];
        $fm_product_variants_new->inventory_id=$variant['inventory_item_id'];
        $fm_product_variants_new->save();
        // $db->query('UPDATE fm_product_variants_new SET variant_id=?,inventory_id=? WHERE barcode=?', $variant['id'],$variant['inventory_item_id'], $variant['sku']);
      }
    }
    // sleep(1);
     }
     $cron_logs->comments="script ended";
      $cron_logs->save();
      echo "upload to shopify script ended";
     // $db->query("UPDATE  cron_logs SET comments = ? WHERE id = ?", "script ended", $lastCronInsertID)->affectedRows();
   }

// public function uploadProductsToShopify($productId)
// {
//   $accessToken  = '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';
//         // $vendorID  = $vendor->id;
//         $storeName    =  'pakistan-fashion-lounge';
//     // Configure your Shopify API credentials
//      $apiKey = '6e49e7497a289a039ed7aee0ef0d7b6f';
//      $shopUrl = 'pakistan-fashion-lounge.myshopify.com';
//      $productId = 8309367603488;
    
//      $productToUpload1 = 
//      '{
//       "product": {
//         "id": 8309367603488,
//         "title": "ab testing",
//         "body_html": "clierhvfbciuh;b;ocineaidso;fchbn;reoisdnc",
//         "vendor": "Pakistan Fashion Lounge",
//         "product_type": "",
//         "created_at": "2023-06-07T17:56:59+01:00",
//         "handle": "ab-testing",
//         "updated_at": "2023-07-12T13:12:38+01:00",
//         "published_at": null,
//         "template_suffix": "",
//         "status": "draft",
//         "published_scope": "web",
//         "tags": "all",
//         "admin_graphql_api_id": "gid://shopify/Product/8309367603488",
//         "variants": [
//           {
//             "product_id": 8309367603488,
//             "id": 45241213747488,
//             "title": "S",
//             "price": "1234.00",
//             "sku": "sxcdedasc21423",
//             "position": 1,
//             "inventory_policy": "deny",
//             "compare_at_price": "12345.00",
//             "fulfillment_service": "manual",
//             "inventory_management": "shopify",
//             "option1": "S",
//             "option2": null,
//             "option3": null,
//             "created_at": "2023-06-07T18:56:16+01:00",
//             "updated_at": "2023-06-07T18:56:16+01:00",
//             "taxable": true,
//             "barcode": "",
//             "grams": 100,
//             "image_id": null,
//             "weight": 0.1,
//             "weight_unit": "kg",
//             "inventory_item_id": 47290045530400,
//             "inventory_quantity": 12,
//             "old_inventory_quantity": 12,
//             "requires_shipping": true,
//             "admin_graphql_api_id": "gid://shopify/ProductVariant/45241213747488"
//           },
//           {
//             "product_id": 8309367603488,
//             "id": 45241213780256,
//             "title": "M",
//             "price": "1234.00",
//             "sku": "sxcdedasc21424",
//             "position": 2,
//             "inventory_policy": "deny",
//             "compare_at_price": "12345.00",
//             "fulfillment_service": "manual",
//             "inventory_management": "shopify",
//             "option1": "M",
//             "option2": null,
//             "option3": null,
//             "created_at": "2023-06-07T18:56:16+01:00",
//             "updated_at": "2023-07-11T20:03:47+01:00",
//             "taxable": true,
//             "barcode": "",
//             "grams": 100,
//             "image_id": null,
//             "weight": 0.1,
//             "weight_unit": "kg",
//             "inventory_item_id": 47290045563168,
//             "inventory_quantity": 12,
//             "old_inventory_quantity": 12,
//             "requires_shipping": true,
//             "admin_graphql_api_id": "gid://shopify/ProductVariant/45241213780256"
//           },
//           {
//             "product_id": 8309367603488,
//             "id": 45241213813024,
//             "title": "L",
//             "price": "1234.00",
//             "sku": "sxcdedasc21425",
//             "position": 3,
//             "inventory_policy": "deny",
//             "compare_at_price": "12345.00",
//             "fulfillment_service": "manual",
//             "inventory_management": "shopify",
//             "option1": "L",
//             "option2": null,
//             "option3": null,
//             "created_at": "2023-06-07T18:56:16+01:00",
//             "updated_at": "2023-07-11T20:03:46+01:00",
//             "taxable": true,
//             "barcode": "",
//             "grams": 100,
//             "image_id": null,
//             "weight": 0.1,
//             "weight_unit": "kg",
//             "inventory_item_id": 47290045595936,
//             "inventory_quantity": 12,
//             "old_inventory_quantity": 12,
//             "requires_shipping": true,
//             "admin_graphql_api_id": "gid://shopify/ProductVariant/45241213813024"
//           }
//         ],
//         "options": [
//           {
//             "product_id": 8309367603488,
//             "id": 10557667737888,
//             "name": "Size",
//             "position": 1,
//             "values": ["S", "M", "L"]
//           }
//         ],
//         "images": [
//           {
//             "product_id": 8309367603488,
//             "id": 41547255677216,
//             "position": 1,
//             "created_at": "2023-06-07T17:57:00+01:00",
//             "updated_at": "2023-06-07T17:57:00+01:00",
//             "alt": null,
//             "width": 600,
//             "height": 800,
//             "src": "https://cdn.shopify.com/s/files/1/0761/6082/7680/files/Black_3_6d03d5ce-5077-4b9d-8aa6-5e16574dfd23.jpg?v=1686157020",
//             "variant_ids": [],
//             "admin_graphql_api_id": "gid://shopify/ProductImage/41547255677216"
//           },
//           {
//             "product_id": 8309367603488,
//             "id": 41547255644448,
//             "position": 2,
//             "created_at": "2023-06-07T17:57:00+01:00",
//             "updated_at": "2023-06-07T17:57:00+01:00",
//             "alt": null,
//             "width": 600,
//             "height": 800,
//             "src": "https://cdn.shopify.com/s/files/1/0761/6082/7680/files/Black_1_9c775511-17bc-4d2d-a9d8-167be808ba57.jpg?v=1686157020",
//             "variant_ids": [],
//             "admin_graphql_api_id": "gid://shopify/ProductImage/41547255644448"
//           },
//           {
//             "product_id": 8309367603488,
//             "id": 41547255775520,
//             "position": 3,
//             "created_at": "2023-06-07T17:57:01+01:00",
//             "updated_at": "2023-06-07T17:57:01+01:00",
//             "alt": null,
//             "width": 600,
//             "height": 800,
//             "src": "https://cdn.shopify.com/s/files/1/0761/6082/7680/files/Black_2_167ccaac-e6f0-4084-a7ea-c00ade957717.jpg?v=1686157021",
//             "variant_ids": [],
//             "admin_graphql_api_id": "gid://shopify/ProductImage/41547255775520"
//           }
//         ],
//         "image": {
//           "product_id": 8309367603488,
//           "id": 41547255677216,
//           "position": 1,
//           "created_at": "2023-06-07T17:57:00+01:00",
//           "updated_at": "2023-06-07T17:57:00+01:00",
//           "alt": null,
//           "width": 600,
//           "height": 800,
//           "src": "https://cdn.shopify.com/s/files/1/0761/6082/7680/files/Black_3_6d03d5ce-5077-4b9d-8aa6-5e16574dfd23.jpg?v=1686157020",
//           "variant_ids": [],
//           "admin_graphql_api_id": "gid://shopify/ProductImage/41547255677216"
//         }
//       }
//     }
//     '
//     ;
    
//     $esdate = date("Y-m-d")." 00:00:00";
//   $eedate = date("Y-m-d")." 03:00:00";
//   $cron_logs= new CronLog();
//   $cron_logs->cron_name='Upload to shopify';
//   $cron_logs->expected_start_time='Every hour';
//   $cron_logs->data=$productToUpload1;
//   $cron_logs->expected_end_time='-';
//   $cron_logs->save();

//     $response = ShopifyClass::shopify_call(
//       $accessToken,
//       $storeName,
//       "/admin/api/2021-07/products/{$productId}.json", // Use curly braces for string interpolation
//       $productToUpload1,
//       'PUT'
//   );
//   dd($response);
//   if ($response instanceof Response && $response->successful()) {
//     // Product updated successfully
//     return 'Product updated successfully';
// } else {
//     // Handle the error
//     return 'Failed to update product: ' . $response;
// }
// }

public function uploadProductsToShopify($productId) {
  $accessToken = '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';
  $storeName = 'pakistan-fashion-lounge';
  // Create options for the API
$options = new Options();
$options->setVersion('2023-07');

// Create the client and session
$api = new BasicShopifyAPI($options);
$api->setSession(new Session('pakistan-fashion-lounge.myshopify.com', $accessToken));

// Now run your requests...
  // Better to pass product code as a parameter rather than hardcoding
  $products = Product::where('code', 8309367603488)->get();
 
  foreach ($products as $product) {
      $sizes = [];
      $variantsArray = [];
      $tags = [];
      $colorTag = [];
      $description = $product->description;
      
      $category = Category::where('id', $product->category_id)->first();
      if ($category) {
          $tags = array_filter(explode(",", $category->name));
      }

      $sizeMapping = [
          'S' => 'Small',
          'M' => 'Medium',
          'L' => 'Large',
          'XS' => 'Extra Small',
          'XL' => 'Extra Large',
          'XXL' => 'Double Extra Large'
      ];
      
      $variants = ProductVariant::where('product_id', $product->id)->take(1)->get();
      foreach ($variants as $var) {
          $colorTag[] = 'color-' . $var->color;
          if (isset($sizeMapping[trim($var->size)])) {
              $var->size = $sizeMapping[trim($var->size)];
              $sizes[] = $var->size;
          }

          $weight = ($var->weight > 0) ? $var->weight : 0.5;
          $variantData = [
            'title'=>'gh',
              'price' => "322",
              'option1' => $var->size,
              'option2' => null,
              'option3' =>null,
              "barcode" => $product->pcode,
              "sku" => "fhghg",
              "fulfillment_service" => "manual",
              "grams" => $weight * 1000,
              'weight' => $weight,
              "weight_unit" => "kg",
              "inventory_management" => "shopify",
              "inventory_policy" => "deny",
              "inventory_quantity" => $var->stock,
              "position" => 1,
          ];
          // if ($var->compare_price > 0) {
          //     $variantData['price'] = $var->compare_price;
          //     $variantData['compare_price'] = $var->price;
          // }
          $variantsArray[] = $variantData;
      }
      $tags = "all";
      $productToUpload = [
      "product" =>[
          "title" => "kjy]g",
          "body_html" => $description,
          "vendor" => "Pakistan Fashion Lounge",
          "product_type" => "",
          "tags" => $tags,
          "options" => [
              [
                  "name" => "Size",
                  "values" => array_values(array_unique($sizes))
              ]
          ],
          "variants" => $variantsArray
      ]
      ];
      $result = $api->rest('PUT',"/admin/products/$productId.json",$productToUpload);


    // $response = ShopifyClass::shopify_call(
    //     $accessToken,
    //     $storeName,
    //     "/admin/api/2021-07/products/{$productId}.json",
    //     $productToUpload,
    //     'PUT'
    // );
    
   }
   dd( $result);
   if ($response instanceof Response && $response->successful()) {
    return 'Product updated successfully';
  } else {
    return 'Failed to update product: ' . json_encode($response);
}

}

public function updateInventory(){

        //fetch inv records
        $products = ProductInventory::all()->where('status',0);

        foreach($products as $product){
          $variantID = $product->variant_id;
          $stock = $product->stock;
          $oldStock = $product->old_stock;
          $invItemId = $product->inventory_item_id;
            

          $productsCount = ShopifyClass::shopify_call($accessToken, $storeName, "/admin/api/2021-10/inventory_levels.json?inventory_item_ids=".$invItemId, array(), 'GET',array("Content-Type: application/json"));
          $invenrotyLevelDataArray = json_decode($productsCount['response'], true);


          $inventoryItemId = $invenrotyLevelDataArray['inventory_levels'][0]['inventory_item_id'];
          $locationID = $invenrotyLevelDataArray['inventory_levels'][0]['location_id'];

          dd($invenrotyLevelDataArray);

        }






        $invenrotyLevel = shopify_call($common->cronsToken,$common->storeName, "/admin/inventory_levels.json", array('inventory_item_ids' => $varientData['inventory_id']), 'GET');
        $invenrotyLevelDataArray = json_decode($invenrotyLevel['response'], TRUE);
        
        $inventoryItemId = $invenrotyLevelDataArray['inventory_levels'][0]['inventory_item_id'];
        $locationID = $invenrotyLevelDataArray['inventory_levels'][0]['location_id'];
        $updateProductStock = array(
            "location_id" =>  $locationID,
            "inventory_item_id" => $inventoryItemId,
            "available" => $currentStock
        );
        $invUpdateResponse = shopify_call($common->cronsToken, $common->storeName, "/admin/inventory_levels/set.json", $updateProductStock, 'POST');
        $db->query("UPDATE  fm_product_variants_new SET stock_updated = ? WHERE id = ?", "1", $varientData['id'])->affectedRows();
    }
    
    public function postproduct()
    {
        $http = new HttpService();
        $productUtil = new ProductUtil();
        $headers = [
            'X-Shopify-Access-Token' => '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',
            'Content-Type' => "application/json",
        ];
        $products = $event->data;
        foreach ($products as $data) {
            $vendor = $data['vendor'];
            $supplierName = "Sehgal Motors";
            $supplier = Contact::find($vendor);
            if ($supplier) {
                $supplierName = $supplier->first()->name;
            }
            $category = Category::where('id', $data['category_id'])->first();
            $subCategory = Category::where('id', $data['sub_category_id'])->first();
            $variation = Variation::where('product_id', $data['id'])->first();
            $discountedPrice = $productUtil->getProductDiscount($data, 1, null);
            $discountedAmount = 0;
            if ($discountedPrice) {
                $discountedPrice = ($data->sell_price_inc_tax / $discountedPrice->discount_amount) * 100;
            } else {
                $discountedPrice = 0;
            }
            $imageBaseUrl = "https://erp.sehgalmotor.pk/photo/";
            $images = ProductImage::where('product_id', $data->id)->get();
            $imageData = [];
            foreach ($images as $key => $image) {
                $imageData[$key] = [
                    "src" => $imageBaseUrl . $image->image_path,
                    "position" => $key
                ];
            }
            $tags = [];
            $carMake = json_decode($data['car_make'], true);
            if (is_array($carMake)){
                $carMake = CarMakeModel::whereIn('id', $carMake)
                    ->get();
            foreach ($carMake as $car) {
                $tags[] = $car->name;
            }
            }
            $carMake = json_decode($data['car_model'], true);
            if (is_array($carMake)) {
            $carMake = CarMakeModel::whereIn('id', $carMake)
                ->get();
            foreach ($carMake as $car) {
                $tags[] = $car->name;
            }
            }
            $carMake = json_decode($data['car_model'], true);
            if (is_array($carMake)) {
            $carMake = CarMakeModel::whereIn('id', $carMake)
                ->get();
            foreach ($carMake as $car) {
                $tags[] = $car->name;
            }
            }
            if ($subCategory) {
                $tags[] = $subCategory->name;
            }



            $productData = [
                "product" => [
                    "title" => $data->name,
                    "body_html" => $data->product_description,
                    "vendor" => $supplierName,
                    "product_type" => $category->name ?? null,
                    "metafields_global_title_tag" => $data->meta_title,
                    "metafields_global_description_tag" => $data->meta_desc,
                    "images" => $imageData,
                    "tags" => implode(",", $tags),
                    "variants" => [
                        [
                            "title" => "Default",
                            "price" => $variation->sell_price_inc_tax,
                            "compare_at_price" => $discountedPrice,
                            "sku" => $data->sku,
                            "cost" => $variation->dpp_inc_tax,
                            "barcode" => $data->barcode
                        ]
                    ],
                ],
            ];

            $url = 'https://' . "mtechotp.myshopify.com" . '/admin/api/2020-10/products.json';

            $response = $http->post($url, $productData, $headers);
            $createdProduct = json_decode($response, true);
        
        }
      }

}

