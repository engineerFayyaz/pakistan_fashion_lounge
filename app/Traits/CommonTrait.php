<?php

namespace App\Http\Traits;
use App\Models\Orders\Order;
use App\Models\Courier\MNP\MnpMapping; 
use App\Models\Setting;

trait CommonTrait
{
  
  

  public $token = 'ca07c37979b607b1afa2ac324c89f433';
  public $shopifyToken = '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';
  public $storeUrl = 'pakistan-fashion-lounge';
  public $storeName = 'pakistan-fashion-lounge';
  public $base_url="http://localhost";
 
  function getImagesCron($pcode, $imagesList) {

    $images = explode(",", $imagesList);
    // dd($images);
    $cnt = 1;
    foreach($images as $img){
        if($img != '' && strpos($img, ' ') === false){
            $isValid = true;
            $fileName = $pcode."-".$cnt;
            $requestExtra='';
            $requestExtra='http://soap.unze.co.uk/pk/service.asmx/GetProductImageFile?imagename='.$img;
            $stringExtra = file_get_contents($requestExtra);
            $stringExtra = str_replace(":", "_", $stringExtra);
            $stringExtra= str_replace('xmlns="fashionmaster"', 'xmlns="http://soap.unze.co.uk/pk/service.asmx/GetProductImageFile?imagename"', $stringExtra);
             // dd($stringExtra);
            $sxeXtra = new \SimpleXMLElement($stringExtra);
            if (!$sxeXtra) {
                echo "Failed loading XML\n";
                foreach(libxml_get_errors() as $error) {
                    echo "\t", $error->message;
                }
            } 
            $b64 = "'".$sxeXtra."'";
            $folderPath = public_path()."/fm-images/".$pcode.'/';
            if (!file_exists($folderPath)) {
                $check=\File::makeDirectory($folderPath, $mode = 0777, true, true);
            }
            try {
                $image_parts = $b64;
            $image_type_aux = explode("image/", $b64);
            $image_base64 = base64_decode($image_parts);
            $img_name=$fileName . '.jpeg';
            $file = $folderPath .$img_name;
            $sd=file_put_contents($file, $image_base64);
                
            } catch (Exception $e) {
                
            }  
            
        }
        $cnt++;
    }
}


function shopify_call($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array()) {
    
  // Build URL
  $url = "https://" . $shop . ".myshopify.com" . $api_endpoint;
  if (!is_null($query) && in_array($method, array('GET',  'DELETE'))) $url = $url . "?" . http_build_query($query);
  // Configure cURL
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_HEADER, TRUE);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
  // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 3);
  // curl_setopt($curl, CURLOPT_SSLVERSION, 3);
  curl_setopt($curl, CURLOPT_USERAGENT, 'My New Shopify App v.1');
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
  curl_setopt($curl, CURLOPT_TIMEOUT, 30);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

  // Setup headers
  $request_headers[] = "";
  if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
  curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

  if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
    if (is_array($query)) $query = http_build_query($query);
    curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
  }
    
  // Send request to Shopify and capture any errors
  $response = curl_exec($curl);
  $error_number = curl_errno($curl);
  $error_message = curl_error($curl);

  // Close cURL to be nice
  curl_close($curl);

  // Return an error is cURL has a problem
  if ($error_number) {
    return $error_message;
  } else {

    // No error, return Shopify's response by parsing out the body and the headers
    $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

    // Convert headers into an array
    $headers = array();
    $header_data = explode("\n",$response[0]);
    $headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
    array_shift($header_data); // Remove status, we've already set it above
    foreach($header_data as $part) {
      $h = explode(":", $part);
      $headers[trim($h[0])] = trim($h[1]);
    }

    // Return headers and Shopify's response
    return array('headers' => $headers, 'response' => $response[1]);

  }
    
}

}
