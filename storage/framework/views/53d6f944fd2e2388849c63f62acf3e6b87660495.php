<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?php echo e(url('logo', $general_setting->site_logo)); ?>" />
    <title><?php echo e($general_setting->site_title); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 14px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
            text-transform: capitalize;
        }
        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }
        tr {border-bottom: 1px dotted #ddd;}
        td,th {padding: 7px 0;width: 50%;}

        table {width: 100%;}
        tfoot tr th:first-child {text-align: left;}

        .centered {
            text-align: center;
            align-content: center;
        }
        small{font-size:11px;}

        @media  print {
            * {
                font-size:12px;
                line-height: 20px;
            }
            td,th {padding: 5px 0;}
            .hidden-print {
                display: none !important;
            }
            @page  { margin: 1.5cm 0.5cm 0.5cm; }
            @page:first { margin-top: 0.5cm; }
            /*tbody::after {
                content: ''; display: block;
                page-break-after: always;
                page-break-inside: avoid;
                page-break-before: avoid;        
            }*/
        }
    </style>
  </head>
<body>

<div style="max-width:400px;margin:0 auto">
    <?php if(preg_match('~[0-9]~', url()->previous())): ?>
        <?php $url = '../../pos'; ?>
    <?php else: ?>
        <?php $url = url()->previous(); ?>
    <?php endif; ?>
    <div class="hidden-print">
        <table>
            <tr>
                <td><a href="<?php echo e($url); ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> <?php echo e(trans('file.Back')); ?></a> </td>
                <td><button onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i> <?php echo e(trans('file.Print')); ?></button></td>
            </tr>
        </table>
        <br>
    </div>
        
    <div id="receipt-data">
        <div class="centered">
            <?php if($general_setting->site_logo): ?>
                <img src="<?php echo e(asset('assets/images/logo.jpg')); ?>" height="80" width="160" style="margin:10px 0;">
            <?php endif; ?>
            
            <h2><?php echo e($lims_biller_data->company_name); ?></h2>
            
            <p><?php echo e(trans('file.Address')); ?>: <?php echo e($lims_warehouse_data->address); ?>

                <br><?php echo e(trans('file.Phone Number')); ?>: <?php echo e($lims_warehouse_data->phone); ?>

                <?php if($general_setting->vat_registration_number): ?>
                <br><?php echo e(trans('file.VAT Number')); ?>: <?php echo e($general_setting->vat_registration_number); ?>

                <?php endif; ?>
            </p>
        </div>
        <p><?php echo e(trans('file.Date')); ?>: <?php echo e(date($general_setting->date_format, strtotime($lims_sale_data->created_at->toDateString()))); ?><br>
            <?php echo e(trans('file.reference')); ?>: <?php echo e($lims_sale_data->reference_no); ?><br>
            <?php echo e(trans('file.customer')); ?>: <?php echo e($lims_customer_data->name); ?>

            <?php if($lims_sale_data->table_id): ?>
            <br><?php echo e(trans('file.Table')); ?>: <?php echo e($lims_sale_data->table->name); ?>

            <br><?php echo e(trans('file.Queue')); ?>: <?php echo e($lims_sale_data->queue); ?>

            <?php endif; ?>
            <?php 
                foreach($sale_custom_fields as $key => $fieldName) {
                    $field_name = str_replace(" ", "_", strtolower($fieldName));
                    echo '<br>'.$fieldName.': ' . $lims_sale_data->$field_name;
                }
                foreach($customer_custom_fields as $key => $fieldName) {
                    $field_name = str_replace(" ", "_", strtolower($fieldName));
                    echo '<br>'.$fieldName.': ' . $lims_customer_data->$field_name;
                }
            ?>
            
        </p>
        <table class="table-data">
            <tbody>
                <?php $total_product_tax = 0;?>
                <?php $__currentLoopData = $lims_product_sale_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product_sale_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $lims_product_data = \App\Product::find($product_sale_data->product_id);
                    if($product_sale_data->variant_id) {
                        $variant_data = \App\Variant::find($product_sale_data->variant_id);
                        $product_name = $lims_product_data->name.' ['.$variant_data->name.']';
                    }
                    elseif($product_sale_data->product_batch_id) {
                        $product_batch_data = \App\ProductBatch::select('batch_no')->find($product_sale_data->product_batch_id);
                        $product_name = $lims_product_data->name.' ['.trans("file.Batch No").':'.$product_batch_data->batch_no.']';
                    }
                    else
                        $product_name = $lims_product_data->name;

                    if($product_sale_data->imei_number) {
                        $product_name .= '<br>'.trans('IMEI or Serial Numbers').': '.$product_sale_data->imei_number;
                    }
                ?>
                <tr>
                    <td colspan="2">
                        <?php echo $product_name; ?>

                        <br><?php echo e($product_sale_data->qty); ?> x <?php echo e(number_format((float)($product_sale_data->total / $product_sale_data->qty), $general_setting->decimal, '.', '')); ?>


                        <?php if($product_sale_data->tax_rate): ?>
                            <?php $total_product_tax += $product_sale_data->tax ?>
                            [<?php echo e(trans('file.Tax')); ?> (<?php echo e($product_sale_data->tax_rate); ?>%): <?php echo e($product_sale_data->tax); ?>]
                        <?php endif; ?>
                    </td>
                    <td style="text-align:right;vertical-align:bottom"><?php echo e(number_format((float)($product_sale_data->total), $general_setting->decimal, '.', '')); ?> €</td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <!-- <tfoot> -->
                <tr>
                    <th colspan="2" style="text-align:left"><?php echo e(trans('file.Total')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)($lims_sale_data->total_price), $general_setting->decimal, '.', '')); ?> €</th>
                </tr>
                <?php if($general_setting->invoice_format == 'gst' && $general_setting->state == 1): ?>
                <tr>
                    <td colspan="2">IGST</td>
                    <td style="text-align:right"><?php echo e(number_format((float)($total_product_tax), $general_setting->decimal, '.', '')); ?> €</td>
                </tr>
                <?php elseif($general_setting->invoice_format == 'gst' && $general_setting->state == 2): ?>
                <tr>
                    <td colspan="2">SGST</td>
                    <td style="text-align:right"><?php echo e(number_format((float)($total_product_tax / 2), $general_setting->decimal, '.', '')); ?> €</td>
                </tr>
                <tr>
                    <td colspan="2">CGST</td>
                    <td style="text-align:right"><?php echo e(number_format((float)($total_product_tax / 2), $general_setting->decimal, '.', '')); ?> €</td>
                </tr>
                <?php endif; ?>
                <?php if($lims_sale_data->order_tax): ?>
                <tr>
                    <th colspan="2" style="text-align:left"><?php echo e(trans('file.Order Tax')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)($lims_sale_data->order_tax), $general_setting->decimal, '.', '')); ?> €</th>
                </tr>
                <?php endif; ?>
                <?php if($lims_sale_data->order_discount): ?>
                <tr>
                    <th colspan="2" style="text-align:left"><?php echo e(trans('file.Order Discount')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)($lims_sale_data->order_discount), $general_setting->decimal, '.', '')); ?> €</th>
                </tr>
                <?php endif; ?>
                <?php if($lims_sale_data->coupon_discount): ?>
                <tr>
                    <th colspan="2" style="text-align:left"><?php echo e(trans('file.Coupon Discount')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)($lims_sale_data->coupon_discount), $general_setting->decimal, '.', '')); ?> €</th>
                </tr>
                <?php endif; ?>
                <?php if($lims_sale_data->shipping_cost): ?>
                <tr>
                    <th colspan="2" style="text-align:left"><?php echo e(trans('file.Shipping Cost')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)($lims_sale_data->shipping_cost), $general_setting->decimal, '.', '')); ?> €</th>
                </tr>
                <?php endif; ?>
                <tr>
                    <th colspan="2" style="text-align:left"><?php echo e(trans('file.grand total')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)($lims_sale_data->grand_total), $general_setting->decimal, '.', '')); ?> €</th>
                </tr>
                <tr>
                    <?php if($general_setting->currency_position == 'prefix'): ?>
                    <th class="centered" colspan="3"><?php echo e(trans('file.In Words')); ?>: <span><?php echo e($currency_code); ?></span> <span><?php echo e(str_replace("-"," ",$numberInWords)); ?></span></th>
                    <?php else: ?>
                    <th class="centered" colspan="3"><?php echo e(trans('file.In Words')); ?>: <span><?php echo e(str_replace("-"," ",$numberInWords)); ?></span> <span><?php echo e($currency_code); ?></span></th>
                    <?php endif; ?>
                </tr>
            </tbody>
            <!-- </tfoot> -->
        </table>
        <table>
            <tbody>
                <?php $__currentLoopData = $lims_payment_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style="background-color:#ddd;">
                    <td style="padding: 5px;width:30%"><?php echo e(trans('file.Paid By')); ?>: <?php echo e($payment_data->paying_method); ?></td>
                    <td style="padding: 5px;width:40%"><?php echo e(trans('file.Amount')); ?>: <?php echo e(number_format((float)($payment_data->amount), $general_setting->decimal, '.', '')); ?> €</td>
                    <td style="padding: 5px;width:30%"><?php echo e(trans('file.Change')); ?>: <?php echo e(number_format((float)$payment_data->change, $general_setting->decimal, '.', '')); ?> €</td>
                </tr>                
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr><td class="centered" colspan="3"><?php echo e(trans('file.Thank you for shopping with us. Please come again')); ?></td></tr>
                <tr>
                    <td class="centered" colspan="3">
                    <?php echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_sale_data->reference_no, 'C128') . '" width="300" alt="barcode"   />';?>
                    <br>
                    <?php echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS2D::getBarcodePNG($qrText, 'QRCODE') . '" alt="QRcode"   />';?>    
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- <div class="centered" style="margin:30px 0 50px">
            <small><?php echo e(trans('file.Invoice Generated By')); ?> <?php echo e($general_setting->site_title); ?>.
            <?php echo e(trans('file.Developed By')); ?> LionCoders</strong></small>
        </div> -->
    </div>
</div>

<script type="text/javascript">
    localStorage.clear();
    function auto_print() {     
        window.print();
    }
    setTimeout(auto_print, 1000);
</script>

</body>
</html>
<?php /**PATH D:\Development-Software\IDE\wamp64\www\pakistan_fashion_lounge\resources\views/backend/sale/invoice.blade.php ENDPATH**/ ?>