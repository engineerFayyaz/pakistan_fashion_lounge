
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="<?php echo e(asset('calender/date-picker.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('ImageSelector/style.css')); ?>">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php $__env->startSection('content'); ?>

<section class="forms">
    <div class="container-fluid">
        <form id="product-form">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4><?php echo e(trans('file.add_product')); ?></h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small>
                            </p>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Title*</strong> </label>
                                        <input type="text" name="name" class="form-control" id="name" aria-describedby="name" required>
                                        <!-- <span class="validation-msg" id="name-error"></span> -->
                                    </div>
                                    <div class="error-message text-danger" id="name-error"></div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo e(trans('file.Product Details')); ?></label>
                                        <textarea name="product_details" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="error-message text-danger" id="product_details-error"></div>

                                </div>

                                <div class="card shadow-lg  p-3 bg-white rounded col-md-12">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-start">
                                            <label class="media ml-2">Media</strong></label><i class="dripicons-question ml-2" data-toggle="tooltip" title="<?php echo e(trans('file.You can upload multiple image. Only .jpeg, .jpg, .png, .gif file can be uploaded. First image will be base image.')); ?>"></i>
                                        </div>
                                        <input type="hidden" name="image_count" class="image_count">
                                        <div class="media_style">
                                            <input type="file" id="file-input" name="pro_image[]" onchange="preview()" multiple>
                                            <label for="file-input" class="multi_image_select">
                                                <i class="fas fa-upload"></i> &nbsp; Choose A Photo
                                            </label>
                                            <p id="num-of-files" class="text-center mt-2">No Files Chosen</p>
                                            <div id="images" class="d-flex justify-content-start"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="image-count" name="image_count" value="0">
                                    <div class="error-message text-danger" id="file-input-error"></div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo e(trans('file.Product Code')); ?> *</strong> </label>
                                        <div class="input-group">
                                            <input type="text" name="code" class="form-control" id="code" aria-describedby="code" required>
                                            <div class="input-group-append">
                                                <button id="genbutton" type="button" class="btn btn-sm btn-default" title="<?php echo e(trans('file.Generate')); ?>"><i class="fa fa-refresh"></i></button>
                                            </div>
                                        </div>
                                        <div class="error-message text-danger" id="code-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo e(trans('file.Barcode Symbology')); ?> *</strong> </label>
                                        <div class="input-group">
                                            <select name="barcode_symbology" required class="form-control selectpicker">
                                                <option value="C128">Code 128</option>
                                                <option value="C39">Code 39</option>
                                                <option value="UPCA">UPC-A</option>
                                                <option value="UPCE">UPC-E</option>
                                                <option value="EAN8">EAN-8</option>
                                                <option value="EAN13">EAN-13</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="digital" class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo e(trans('file.Attach File')); ?> *</strong> </label>
                                        <div class="input-group">
                                            <input type="file" id="file" name="file" class="form-control">
                                        </div>
                                        <span class="validation-msg"></span>
                                    </div>
                                </div>
                                <div id="combo" class="col-md-9 mb-1">
                                    <label><?php echo e(trans('file.add_product')); ?></label>
                                    <div class="search-box input-group mb-3">
                                        <button class="btn btn-secondary"><i class="fa fa-barcode"></i></button>
                                        <input type="text" name="product_code_name" id="lims_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                    </div>
                                    <label><?php echo e(trans('file.Combo Products')); ?></label>
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-hover order-list">
                                            <thead>
                                                <tr>
                                                    <th><?php echo e(trans('file.product')); ?></th>
                                                    <th><?php echo e(trans('file.Quantity')); ?></th>
                                                    <th><?php echo e(trans('file.Unit Price')); ?></th>
                                                    <th><i class="dripicons-trash"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                                <div class="col-md-4">
                                    <div class="form-group mt-3">
                                        <input type="checkbox" name="is_initial_stock" value="1">&nbsp;
                                        <label><?php echo e(trans('file.Initial Stock')); ?></label>
                                        <p class="italic">
                                            <?php echo e(trans('file.This feature will not work for product with variants and batches')); ?>

                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mt-3">
                                        <input type="checkbox" name="featured" value="1">&nbsp;
                                        <label><?php echo e(trans('file.Featured')); ?></label>
                                        <p class="italic"><?php echo e(trans('file.Featured product will be displayed in POS')); ?>

                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mt-3">
                                        <input type="checkbox" name="is_embeded" value="1">&nbsp;
                                        <label><?php echo e(trans('file.Embedded Barcode')); ?> <i class="dripicons-question" data-toggle="tooltip" title="<?php echo e(trans('file.Check this if this product will be used in weight scale machine.')); ?>"></i></label>
                                    </div>
                                </div>
                                <div class="col-md-6" id="initial-stock-section">
                                    <div class="table-responsive ml-2">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th><?php echo e(trans('file.Warehouse')); ?></th>
                                                    <th><?php echo e(trans('file.qty')); ?></th>
                                                </tr>
                                                <?php $__currentLoopData = $lims_warehouse_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="stock_warehouse_id[]" value="<?php echo e($warehouse->id); ?>">
                                                        <?php echo e($warehouse->name); ?>

                                                    </td>
                                                    <td><input type="number" name="stock[]" min="0" class="form-control"></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-2" id="diffPrice-option">
                                    <h5><input name="is_diffPrice" type="checkbox" id="is-diffPrice" value="1">&nbsp;
                                        <?php echo e(trans('file.This product has different price for different warehouse')); ?>

                                    </h5>
                                </div>
                                <div class="col-md-6" id="diffPrice-section">
                                    <div class="table-responsive ml-2">
                                        <table id="diffPrice-table" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th><?php echo e(trans('file.Warehouse')); ?></th>
                                                    <th><?php echo e(trans('file.Price')); ?></th>
                                                </tr>
                                                <?php $__currentLoopData = $lims_warehouse_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="warehouse_id[]" value="<?php echo e($warehouse->id); ?>">
                                                        <?php echo e($warehouse->name); ?>

                                                    </td>
                                                    <td>
                                                        <input type="number" name="diff_price[]" class="form-control">
                                                        <div class="error-message text-danger" id="diff_price-error"></div>
                                                        warehouse_id
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3" id="batch-option">
                                    <h5><input name="is_batch" type="checkbox" id="is-batch" value="1">&nbsp;
                                        <?php echo e(trans('file.This product has batch and expired date')); ?>

                                    </h5>
                                </div>
                                <div class="col-md-12 mt-3" id="imei-option">
                                    <h5><input name="is_imei" type="checkbox" id="is-imei" value="1">&nbsp;
                                        <?php echo e(trans('file.This product has IMEI or Serial numbers')); ?>

                                    </h5>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <input name="promotion" type="checkbox" id="promotion" value="1">&nbsp;
                                    <label>
                                        <h5> <?php echo e(trans('file.Add Promotional Price')); ?></h5>
                                    </label>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4" id="promotion_price">
                                            <label><?php echo e(trans('file.Promotional Price')); ?></label>
                                            <input type="number" name="promotion_price" class="form-control" step="any" />
                                            <div class="error-message text-danger" id="promotion_price-error"></div>
                                        </div>
                                        <div class="col-md-4" id="start_date">
                                            <div class="form-group">
                                                <label><?php echo e(trans('file.Promotion Starts')); ?></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="dripicons-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="starting_date" id="starting_date" class="form-control" />
                                                </div>
                                                <div class="error-message text-danger" id="starting_date-error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="last_date">
                                            <div class="form-group">
                                                <label><?php echo e(trans('file.Promotion Ends')); ?></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="dripicons-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="last_date" id="ending_date" class="form-control" />
                                                </div>
                                                <div class="error-message text-danger" id="last_date-error"></div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if(\Schema::hasColumn('products', 'woocommerce_product_id')): ?>
                                <div class="col-md-12 ">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="is_sync_disable" value="1">
                                        <label class="form-check-label">
                                            <h5>Disable Woocommerce Sync</h5>
                                        </label>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>


                        </div>
                    </div>
                    <div class="card shadow-lg  p-3 bg-white cards">
                        <label for="" class="pricing">Pricing</label>
                        <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4" class="title">Price</label>
                                <input type="text" class="form-control price" name="price" id="fields" placeholder="Enter amount" aria-label="Amount" oninput="getValue()" style="border: 1px solid black; border-radius: 5px;">
                                <div class="error-message text-danger" id="price-error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4" class="title">Compare-at-price</label>
                                <input type="text" class="form-control comp_price" name="comp_price" value="<?php echo e(old('comp_price')); ?>" id="fields" placeholder="Enter amount" oninput="getValue()" aria-label="Amount" style="border: 1px solid black; border-radius: 5px;">
                                <div class="error-message text-danger" id="comp_price-error"></div>
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="taxCharge" onclick="toggleTax()">
                            <label class="custom-control-label taxChange" id="taxId" style="margin-top: 1px;" oninput="getValue()" for="taxCharge">Change Tax on this
                                product</label>
                        </div>
                        <div class="form-row" id="pro_mar" style="display: none;">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4" class="cost">Cost per item</label>
                                <input type="text" class="form-control cost_per_item" value="<?php echo e(old('per_item_cost')); ?>" name="per_item_cost" id="fields" oninput="getValue()" placeholder="Enter amount" aria-label="Amount" style="border: 1px solid black; border-radius: 5px;">
                                <div class="error-message text-danger" id="per_item_cost-error"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4" class="profit">Profit</label>
                                <input type="text" class="form-control profit_value" id="fields" value="<?php echo e(old('product_profit')); ?>" name="product_profit" placeholder="Enter amount" aria-label="Amount" style="border: 1px solid black; border-radius: 5px;">
                                <span class=" mb-2">
                                    <?php $__errorArgs = ['product_profit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4" class="margin">Margin</label>
                                <input type="text" class="form-control margin_value" id="fields" value="<?php echo e(old('product_margin')); ?>" name="product_margin" placeholder="Enter amount" aria-label="Amount" style="border: 1px solid black; border-radius: 5px;">
                                <span class=" mb-2">
                                    <?php $__errorArgs = ['product_margin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-lg  p-3  bg-white cards">
                        <label for="" class="Inventory">Inventory</label>
                        <div class="custom-control custom-checkbox mb-3 mt-3">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" onclick="toggleQuantityField()">
                            <label class="custom-control-label track " style="margin-top: 1px;" for="customCheck1" id="toggleQuantityCheck">Track Quantity</label>
                        </div>
                        <div id="toggle_quantity" style="display: none;">
                            <div>
                                <label for="" class="Quantity">Quantity</label>
                            </div>
                            <hr />

                            <div class="form-row d-flex justify-content-between">
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4" id="borough">15 Marlborough</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="number" class="form-control" placeholder="0" value="<?php echo e(old('product_quantity')); ?>" name="product_quantity" id="quantityField" style="border: 1px solid black; border-radius: 5px;">
                                    <div class="error-message text-danger" id="product_quantity-error"></div>
                                </div>
                            </div>


                            <div class="custom-control custom-checkbox mb-1 mt-2">
                                <input type="checkbox" class="custom-control-input" onclick="toggleStockField()" id="customCheck2">
                                <label class="custom-control-label contSelling" for="customCheck2" style="margin-top: 1px;">Continue Selling When Out Of Stock</label>
                                <p class=" mt-1" id="stock_out">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Maxime mollitia,
                                    molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
                                    numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium.</p>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox mb-3 mt-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck3" onclick="toggleBarcodeField()">
                            <label class="custom-control-label sku" for="customCheck3" style="margin-top: 1px;;">This
                                Product has a SKU or barcode</label>
                        </div>
                        <div class="form-row" id="barcode">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4" class="sku">SKU (Stock Keeping Unit)</label>
                                <input type="text" class="form-control" id="currencyInput" value="<?php echo e(old('sku_input')); ?>" name="sku_input" aria-label="Amount" style="border: 1px solid black; border-radius: 5px;">
                                <div class="error-message text-danger" id="sku_input-error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4" class="Barcode">Barcode (ISBN, UCP, GTIN, etc)</label>
                                <input type="text" class="form-control" id="currencyInput" name="bar_code" value="<?php echo e(old('bar_code')); ?>" aria-label="Amount" style="border: 1px solid black; border-radius: 5px;">
                                <div class="error-message text-danger" id="bar_code-error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-lg p-3 bg-white cards">
                        <label for="" class="shipping">Shipping</label>
                        <div class="custom-control custom-checkbox mb-3 mt-2">
                            <input type="checkbox" class="custom-control-input" id="shipping" onclick="toggleShippingField()">
                            <label class="custom-control-label" for="shipping" id="req_shipping" style="margin-top: 1px;">This Product require Shipping</label>
                        </div>
                        <div class=" form-group " id="shipping_field">
                            <label for="" class="Weight ">Weight</label>
                            <div class="d-flex">
                                <div class="form-group col-md-5">
                                    <input type="number" class="form-control" value="<?php echo e(old('weight')); ?>" id="currencyInput" name="weight" aria-label="Amount" step="0.01" style="border: 1px solid black; border-radius: 5px;">
                                    <div class="error-message text-danger" id="weight-error"></div>
                                </div>
                                <div class="form-group col-md-3">
                                    <select required class="form-control selectpicker" name="unit_id">
                                        <option value="" disabled selected>Select Product Unit...</option>
                                        <?php $__currentLoopData = $lims_unit_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($unit->base_unit==null): ?>
                                        <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->unit_name); ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="error-message text-danger" id="unit_id-error"></div>
                                </div>
                            </div>
                        </div>
                        <hr class="divider">
                        <a class="text-primary more_opt" id="custom_info" onclick="toggleCustomField()"> + Add custom
                            Information</a>
                        <div class="form-group" id="custom_info_div" style="display: none;">
                            <div class="mb-2">
                                <span class="cus_info">Custom Information</span>
                                <br>
                                <span class="int_order">Printed on custom forms or shipping labels for international
                                    orders</span>
                            </div>
                            <div class="form-group">
                                <label class="Country">Country</label>
                                <div>
                                    <select class="form-select border w-100" name="country" value="<?php echo e(old('country')); ?>" aria-label="Default select example">
                                        <option value="" disabled hidden>Choose Country</option>
                                        <option value="1">Pakistan</option>
                                        <option value="2">India</option>
                                        <option value="3">China</option>
                                        <option value="4">England</option>
                                    </select>

                                </div>

                                <div class="error-message text-danger" id="country-error"></div>
                            </div>

                            <div class="form-group">
                                <label class="HS">HS (Harmonized System)</label>
                                <input name="harmonized_system" type="search" value="<?php echo e(old('harmonized_system')); ?>" placeholder="Search Here" class="form-control" style="border: 1px solid black; border-radius: 5px;">
                                <div class="error-message text-danger" id="harmonized_system-error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-lg p-3 bg-white cards">

                        <div class="col-md-12 mt-3" id="variant-option">
                            <h5><input name="is_variant" type="checkbox" id="is-variant" value="1">&nbsp;
                                <label for="is-variant">This product has variant</label>
                            </h5>
                        </div>
                        <div class="col-md-12" id="variant-section">
                            <div class="row" id="variant-input-section">
                                <div class="col-md-6 form-group mt-2">
                                    <label><?php echo e(trans('file.Option')); ?> *</label>
                                    <input type="text" name="variant_option[]" class="form-control variant-field" placeholder="Size, Color etc...">
                                    <div class="error-message text-danger" id="variant_option-error"></div>

                                </div>
                                <div class="col-md-6 form-group mt-2">
                                    <label><?php echo e(trans('file.Value')); ?> *</label>
                                    <input type="text" name="variant_value[]" class="type-variant form-control variant-field">
                                    <div class="error-message text-danger" id="variant_value-error"></div>
                                </div>
                                <!-- <button type="button" class="btn btn-primary mb-2" style="margin-top: 40px;margin-bottom: 15px !important;">Edit</button> -->
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="button" class="btn btn-info add-more-variant"><i class="dripicons-plus"></i>
                                    <?php echo e(trans('file.Add More Variant')); ?></button>
                            </div>
                            <div class="table-responsive ml-2">
                                <table id="variant-table" class="table table-hover variant-list">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(trans('file.name')); ?></th>
                                            <th>Variant</th>
                                            <th>Price</th>
                                            <th>On Hand</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-lg  p-3  bg-white cards">

                        <div class="form-group ">
                            <div class="d-flex justify-content-between">
                                <h5 class="search_eng">Search Engine Listing</h5>
                                <a href="#" class="edit_search">Edit</a>
                            </div>
                            <!-- <div> -->
                            <span class="little_desc">Add a little description below to see how this product might appear in the search engine listing</span>
                            <!-- </div> -->
                        </div>

                    </div>

                </div>


                <div class="col-lg-4 ">
                    <div class="card shadow-sm p-3 bg-white cards">
                        <div class="form-group text-center">
                            <input type="button" value="Submit" id="submit-btn" class="btn btn-primary">
                        </div>
                    </div>

                    <div class="card shadow-sm p-3  bg-white cards">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="card-title status">Status</label>
                                <div>
                                    <select class="form-select border w-100" name="save_status" title="Select Status">
                                        <option value="Active" class="text"> Active</option>
                                        <option value="Inactive" class="text">Draft</option>
                                    </select>
                                </div>
                                <div class="error-message text-danger" id="save_status-error"></div>
                            </div>

                        </div>
                    </div>
                    <input type="hidden" name="startDate" id="sch_start_date">
                    <input type="hidden" name="endDate" id="sch_end_date">
                    <!--  Modal  -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog w-50" role="document">
                            <div class="modal-content">
                                <div class="modal-header card-header">
                                    <h5 class="modal-title sch_online " id="exampleModalLabel">Schedule Online Store Before
                                        Publishing</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="">Start Date</label>
                                            <input type="text" id="start_date" name="starting_date" class="date-picker form-control" value="<?php echo e(old('starting_date')); ?>" />
                                            <!-- <input type="date" id="start_date" class="form-control" /> -->
                                        </div>
                                        <div class="error-message text-danger" id="starting_date-error"></div>

                                        <div class="col-lg-6">
                                            <label for="">End Time</label>
                                            <input type="text" id="end_date" name="ending_date" class="date-picker form-control" value="<?php echo e(old('ending_date')); ?>" />
                                        </div>
                                        <div class="error-message text-danger" id="ending_date-error"></div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light text-dark " data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-dark text-white schedule_date">Schedule
                                        Publishing</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->

                    <div class="card shadow-sm p-3  bg-white cards">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label class="card-title Publishing">Publishing</label>
                                    <a href="#" style="margin-top: -1px;;" class="text">Manage<i class="fas fa-chevron-down down-arrow"></i></a>
                                </div>
                                <!-- <ul > -->
                                <div>
                                    <ul class="list-unstyled d-flex justify-content-between align-items-center">
                                        <li>
                                            <span class="text Publishing_sub_cont"><i class="fa fa-circle-thin"></i> Online
                                                Store</span>
                                        </li>
                                        <li>
                                            <img src="<?php echo e(asset('icons/datetime.png')); ?>" alt="" width="20px" height="20px" class="" id="product_publish_date" data-toggle="modal" data-target="#exampleModal">
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled">
                                        <li class="mb-3">
                                            <span class="Publishing_sub_cont"><i class="fa fa-circle-thin"></i> Point of
                                                Sale and POS</span>
                                        </li>

                                        <li class="mb-3">
                                            <span class="Publishing_sub_cont"><i class="fa fa-circle-thin"></i> Shop</span>
                                            <div style="margin-left: 19px;"><span class="text-black text">Shop has noticed
                                                    your store does't meet store requirement</span>
                                                <a href="#" class="learnMore">Learn More</a>
                                            </div>
                                        </li>
                                        <li class="mb-3">
                                            <span class="Publishing_sub_cont"><i class="fa fa-circle-thin"></i> Facebook &
                                                Instagram</span>
                                            <div style="margin-left: 19px;"><span class="text-black text">Shop has noticed
                                                    your store does't meet store requirement</span>
                                                <a href="#" class="learnMore">Learn More</a>
                                            </div>
                                        </li>

                                        <li class="mb-3">
                                            <span class="text Publishing_sub_cont"><i class="fa fa-circle-thin"></i>
                                                Markets</span>
                                            <div style="margin-left: 19px;"><span class="text-black text">Shop has noticed
                                                    your store does't meet store requirement</span>
                                                <a href="#" class="text">Learn More</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- </ul> -->
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm p-3 bg-white cards">
                        <div class="card-body">

                            <label class="card-title pro_org">Product Organization</label>

                            <div class="form-group">
                                <label><?php echo e(trans('file.category')); ?> *</strong> </label>
                                <div class="input-group">
                                    <select name="category_id" required class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Category...">
                                        <?php $__currentLoopData = $lims_category_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="error-message text-danger" id="category_id-error"></div>
                            </div>

                            <div class="form-group">
                                <label for="" class="product">Product Type</label>
                                <!-- <input type="text" class="form-control" name="prod_type" style="border: 1px solid black; border-radius: 5px;"> -->
                                <select class="form-select border w-100" aria-label="Default select example" title="Select Product type" name="prod_type" value="<?php echo e(old('prod_type')); ?>" style="border: 1px solid black; border-radius: 5px;">
                                    <option value="Product Type 1">Product Type 1</option>
                                    <option value="Product Type 2">Product Type 2</option>
                                </select>
                                <div class="error-message text-danger" id="prod_type-error"></div>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(trans('file.Brand')); ?></strong> </label>
                                <div class="input-group">
                                    <select name="brand_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Brand...">
                                        <?php $__currentLoopData = $lims_brand_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="error-message text-danger" id="brand_id-error"></div>
                            </div>

                            <span class="coll_error">There are no collection available to add this product to. You can add a
                                new collection or modify your existing collection </span>

                            <div class="form-group">
                                <div class="row d-flex justify-content-between">
                                    <label for="search_tags" class="ml-3">Tags</label>
                                    <a href="#" class="mr-4 manage">Manage</a>
                                </div>
                                <div>
                                    <input type="text" class="form-control tags" id="search_tags" placeholder="Search Tags" name="user_selected_tags" style="border: 1px solid black; border-radius: 5px;">
                                    <div id="tag_suggestions" class="tag-suggestions form-group"></div>
                                    <div id="selected_tag_suggestions" class="select-tag-suggestions form-group"></div>
                                    <input type="hidden" class="form-control tags" name="tags[]" id="tag_collection" placeholder="Search Tags" style="border: 1px solid black; border-radius: 5px;">
                                    <div class="error-message text-danger" id="user_selected_tags-error"></div>
                                </div>
                            </div>
                            <div id="selectedTagsContainer" style="border: 5px;"></div>
                        </div>
                    </div>

                    <div class="card shadow-sm p-3 bg-white cards">
                        <div class="card-body">
                            <label class="card-title on_store">Online Store</label>
                            <div class="form-group">
                                <span for="" class="template">Theme Template</span>
                                <div>
                                    <select class="form-select border w-100" name="pro_theme" aria-label="Default select example" style="border: 1px solid black; border-radius: 5px;">
                                        <option value="">Default Product</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    </form>
    </div>
</section>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    let fileInput = document.getElementById("file-input");
    let imageContainer = document.getElementById("images");
    let numOfFiles = document.getElementById("num-of-files");
    let imageCountInput = document.getElementById("image-count");

    // function preview() {
    //     // Clear the existing images before adding new ones
    //     // imageContainer.innerHTML = "";

    //     let imageFiles = [];
    //     for (let i = 0; i < fileInput.files.length; i++) {
    //         if (fileInput.files[i].type.startsWith('image/')) {
    //             imageFiles.push(fileInput.files[i]);
    //         }
    //     }

    //     numOfFiles.textContent = `${imageFiles.length} Images Selected`;
    //     console.log(numOfFiles.textContent);

    //     imageCountInput.value = imageFiles.length; // Update the image_count hidden input field

    //     for (let i = 0; i < imageFiles.length; i++) {
    //         let image = imageFiles[i];
    //         let reader = new FileReader();
    //         let figure = document.createElement("figure");

    //         // Create an input field to hold the image index
    //         let indexInput = document.createElement("input");
    //         indexInput.setAttribute("type", "hidden");
    //         indexInput.setAttribute("name", "imageIndex[]"); // Set the name attribute to an array
    //         indexInput.value = i; // Set the value to the image index
    //         figure.appendChild(indexInput);

    //         reader.onload = () => {
    //             let img = document.createElement("img");
    //             img.setAttribute("src", reader.result);
    //             figure.appendChild(img);
    //         }
    //         imageContainer.appendChild(figure);
    //         reader.readAsDataURL(image);
    //     }
    // }
    // function preview() {
    //     // Clear the existing images before adding new ones
    //     // imageContainer.innerHTML = "";

    //     let imageFiles = [];
    //     for (let i = 0; i < fileInput.files.length; i++) {
    //         if (fileInput.files[i].type.startsWith('image/')) {
    //             imageFiles.push(fileInput.files[i]);
    //         }
    //     }

    //     numOfFiles.textContent = `${imageFiles.length} Images Selected`;
    //     imageCountInput.value = imageFiles.length; // Update the image_count hidden input field

    //     for (let i = 0; i < imageFiles.length; i++) {
    //         let image = imageFiles[i];
    //         let reader = new FileReader();
    //         let figure = document.createElement("figure");
    //         figure.style.width = "100px";
    //         figure.style.height = "auto";

    //         // Create an input field to hold the image index
    //         let indexInput = document.createElement("input");
    //         indexInput.setAttribute("type", "hidden");
    //         indexInput.setAttribute("name", "imageIndex[]");
    //         indexInput.value = i;
    //         figure.appendChild(indexInput);

    //         reader.onload = () => {
    //             let img = document.createElement("img");
    //             img.setAttribute("src", reader.result);
    //             img.style.height = "150px";
    //             figure.appendChild(img);

    //             // Create a "Remove Image" link
    //             let removeLink = document.createElement("a");
    //             removeLink.textContent = "Remove";
    //             removeLink.href = "javascript:void(0);"; // Add a placeholder href
    //             removeLink.style.marginTop = "-30px"; // Apply negative margin-top
    //             removeLink.addEventListener("click", () => {
    //                 figure.remove(); // Remove the entire figure element
    //             });

    //             // Append the image and the "Remove Image" link to a container div
    //             let imageContainerDiv = document.createElement("div");
    //             imageContainerDiv.appendChild(img);
    //             imageContainerDiv.appendChild(removeLink);
    //             figure.appendChild(imageContainerDiv);
    //         };

    //         imageContainer.appendChild(figure);
    //         reader.readAsDataURL(image);
    //     }
    // }
    function preview() {
        // imageContainer.innerHTML = "";

        let imageFiles = [];
        for (let i = 0; i < fileInput.files.length; i++) {
            if (fileInput.files[i].type.startsWith('image/')) {
                imageFiles.push(fileInput.files[i]);
            }
        }

        updateImageCount(imageFiles.length);
        imageCountInput.value = imageFiles.length;

        for (let i = 0; i < imageFiles.length; i++) {
            let image = imageFiles[i];
            let reader = new FileReader();
            let figure = document.createElement("figure");
            figure.style.width = "100px";
            figure.style.height = "auto";


            let indexInput = document.createElement("input");
            indexInput.setAttribute("type", "hidden");
            indexInput.setAttribute("name", "imageIndex[]");
            indexInput.value = i;
            figure.appendChild(indexInput);

            reader.onload = () => {
                let img = document.createElement("img");
                img.setAttribute("src", reader.result);
                img.style.height = "150px";
                figure.appendChild(img);


                let removeLink = document.createElement("a");
                removeLink.textContent = "Remove";
                removeLink.href = "javascript:void(0);";
                removeLink.style.marginTop = "-30px";
                removeLink.addEventListener("click", (index => {
                    return () => {
                        figure.remove();
                        imageFiles.splice(index, 1);
                        updateImageCount(imageFiles.length);
                    };
                })(i));


                let imageContainerDiv = document.createElement("div");
                imageContainerDiv.appendChild(img);
                imageContainerDiv.appendChild(removeLink);
                figure.appendChild(imageContainerDiv);
            };

            imageContainer.appendChild(figure);
            reader.readAsDataURL(image);
        }
    }

    function updateImageCount(count) {
        numOfFiles.textContent = `${count} Image${count !== 1 ? "s" : ""} Selected`;
    }
</script>
<script type="text/javascript">
    $("ul#product").siblings('a').attr('aria-expanded', 'true');
    $("ul#product").addClass("show");
    $("ul#product #product-create-menu").addClass("active");

    <?php if(config('database.connections.saleprosaas_landlord')): ?>
    numberOfProduct = <?php echo json_encode($numberOfProduct) ?>;
    $.ajax({
        type: 'GET',
        async: false,
        url: '<?php echo e(route("package.fetchData", $general_setting->package_id)); ?>',
        success: function(data) {
            if (data['number_of_product'] > 0 && data['number_of_product'] <= numberOfProduct) {
                localStorage.setItem("message",
                    "You don't have permission to create another product as you already exceed the limit! Subscribe to another package if you wants more!"
                );
                location.href = "<?php echo e(route('products.index')); ?>";
            }
        }
    });
    <?php endif; ?>

    $("#digital").hide();
    $("#combo").hide();
    $("#variant-section").hide();
    $("#initial-stock-section").hide();
    $("#diffPrice-section").hide();
    $("#promotion_price").hide();
    $("#start_date").hide();
    $("#last_date").hide();
    var variantPlaceholder = <?php echo json_encode(trans('file.Enter variant value seperated by comma')); ?>;
    var variantIds = [];
    var combinations = [];
    var oldCombinations = [];
    var oldAdditionalCost = [];
    var oldAdditionalPrice = [];
    var step;
    var numberOfWarehouse = <?php echo json_encode(count($lims_warehouse_list)) ?>;

    $('[data-toggle="tooltip"]').tooltip();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#genbutton').on("click", function() {
        $.get('gencode', function(data) {
            $("input[name='code']").val(data);
        });
    });

    $('.add-more-variant').on("click", function() {
        var htmlText =
            '<div class="col-md-6 form-group mt-2"><label>Option *</label><input type="text" name="variant_option[]" class="form-control variant-field" placeholder="Size, Color etc..."></div><div class="col-md-6 form-group mt-2"><label>Value *</label><input type="text" name="variant_value[]" class="type-variant form-control variant-field"></div>';
        $("#variant-input-section").append(htmlText);
        $('.type-variant').tagsInput();
    });

    //start variant related js
    $(function() {
        $('.type-variant').tagsInput();
    });

    (function($) {
        var delimiter = [];
        var inputSettings = [];
        var callbacks = [];

        $.fn.addTag = function(value, options) {
            options = jQuery.extend({
                focus: false,
                callback: true
            }, options);
            this.each(function() {
                var id = $(this).attr('id');
                var tagslist = $(this).val().split(_getDelimiter(delimiter[id]));
                if (tagslist[0] === '') tagslist = [];

                value = jQuery.trim(value);

                if ((inputSettings[id].unique && $(this).tagExist(value)) || !_validateTag(value,
                        inputSettings[id], tagslist, delimiter[id])) {
                    $('#' + id + '_tag').addClass('error');
                    return false;
                }

                $('<span>', {
                    class: 'tag'
                }).append(
                    $('<span>', {
                        class: 'tag-text'
                    }).text(value),
                    $('<button>', {
                        class: 'tag-remove'
                    }).click(function() {
                        return $('#' + id).removeTag(encodeURI(value));
                    })
                ).insertBefore('#' + id + '_addTag');
                tagslist.push(value);

                $('#' + id + '_tag').val('');
                if (options.focus) {
                    $('#' + id + '_tag').focus();
                } else {
                    $('#' + id + '_tag').blur();
                }

                $.fn.tagsInput.updateTagsField(this, tagslist);

                if (options.callback && callbacks[id] && callbacks[id]['onAddTag']) {
                    var f = callbacks[id]['onAddTag'];
                    f.call(this, this, value);
                }

                if (callbacks[id] && callbacks[id]['onChange']) {
                    var i = tagslist.length;
                    var f = callbacks[id]['onChange'];
                    f.call(this, this, value);
                }

                $(".type-variant").each(function(index) {
                    variantIds.splice(index, 1, $(this).attr('id'));
                });

                //start custom code
                first_variant_values = $('#' + variantIds[0]).val().split(_getDelimiter(delimiter[
                    variantIds[0]]));
                combinations = first_variant_values;
                step = 1;
                while (step < variantIds.length) {
                    var newCombinations = [];
                    for (var i = 0; i < combinations.length; i++) {
                        new_variant_values = $('#' + variantIds[step]).val().split(_getDelimiter(delimiter[
                            variantIds[step]]));
                        for (var j = 0; j < new_variant_values.length; j++) {
                            newCombinations.push(combinations[i] + '/' + new_variant_values[j]);
                        }
                    }
                    combinations = newCombinations;
                    step++;
                }
                var rownumber = $('table.variant-list tbody tr:last').index();
                if (rownumber > -1) {
                    oldCombinations = [];
                    oldAdditionalCost = [];
                    oldAdditionalPrice = [];
                    $(".variant-name").each(function(i) {
                        oldCombinations.push($(this).text());
                        oldAdditionalCost.push($('table.variant-list tbody tr:nth-child(' + (i +
                            1) + ')').find('.additional-cost').val());
                        oldAdditionalPrice.push($('table.variant-list tbody tr:nth-child(' + (i +
                            1) + ')').find('.additional-price').val());
                    });
                }
                $("table.variant-list tbody").remove();
                var newBody = $("<tbody>");
                for (i = 0; i < combinations.length; i++) {
                    var variant_name = combinations[i];

                    var item_code = variant_name + '-' + $("#code").val();
                    var newRow = $("<tr>");
                    var cols = '';
                    cols += '<td class="variant-name mt-2">' + variant_name +
                        '<input type="hidden" name="variant_name[]" value="' + variant_name + '" disabled /></td>';
                    cols +=
                        '<td><input type="text" class="form-control item-code" name="item_code[]" value="' +
                        item_code + '" disabled /></td>';
                    //checking if this variant already exist in the variant table
                    oldIndex = oldCombinations.indexOf(combinations[i]);
                    if (oldIndex >= 0) {
                        cols +=
                            '<td><input type="number" class="form-control additional-cost" name="additional_cost[]" value="' +
                            oldAdditionalCost[oldIndex] + '" step="any" disabled /></td>';
                        cols +=
                            '<td><input type="number" class="form-control additional-price" name="additional_price[]" value="' +
                            oldAdditionalPrice[oldIndex] + '" step="any" disabled /></td>';
                    } else {
                        cols +=
                            '<td><input type="number" class="form-control additional-cost" name="additional_cost[]" value="" step="any" disabled /></td>';
                        cols +=
                            '<td><input type="number" class="form-control additional-price" name="additional_price[]" value="" step="any" disabled /></td>';
                    }
                    cols +=
                        '<td><input type="number" class="form-control" name="variant_quantity[]" value="" step="any" disabled /></td>';
                    cols +=
                        '<td class="d-flex"><button type="button" class="btn btn-primary edit-button ">Edit</button><button type="button" class="btn btn-danger ml-2 delete-button">Delete</button></td>';

                    newRow.append(cols);
                    newBody.append(newRow);
                }
                $("table.variant-list").append(newBody);
                //end custom code
            });
            return false;
        };

        $(document).ready(function() {
            // Event delegation for the "Edit" button
            $(document).on("click", ".edit-button", function() {
                // alert("edit");
                var row = $(this).closest("tr"); // Get the parent row
                var inputs = row.find("input"); // Find all input fields within the row

                // Enable editing for input fields
                inputs.prop("disabled", false);
            });
            $(document).on("click", ".delete-button", function() {

                var row = $(this).closest("tr"); // Get the parent row
                row.remove(); // Remove the entire row
            });
        });

        $.fn.removeTag = function(value) {
            value = decodeURI(value);

            this.each(function() {
                var id = $(this).attr('id');

                var old = $(this).val().split(_getDelimiter(delimiter[id]));

                $('#' + id + '_tagsinput .tag').remove();

                var str = '';
                for (i = 0; i < old.length; ++i) {
                    if (old[i] != value) {
                        str = str + _getDelimiter(delimiter[id]) + old[i];
                    }
                }

                $.fn.tagsInput.importTags(this, str);

                if (callbacks[id] && callbacks[id]['onRemoveTag']) {
                    var f = callbacks[id]['onRemoveTag'];
                    f.call(this, this, value);
                }
            });

            return false;
        };

        $.fn.tagExist = function(val) {
            var id = $(this).attr('id');
            var tagslist = $(this).val().split(_getDelimiter(delimiter[id]));
            return (jQuery.inArray(val, tagslist) >= 0);
        };

        $.fn.importTags = function(str) {
            var id = $(this).attr('id');
            $('#' + id + '_tagsinput .tag').remove();
            $.fn.tagsInput.importTags(this, str);
        };

        $.fn.tagsInput = function(options) {
            var settings = jQuery.extend({
                interactive: true,
                placeholder: variantPlaceholder,
                minChars: 0,
                maxChars: null,
                limit: null,
                validationPattern: null,
                width: 'auto',
                height: 'auto',
                autocomplete: null,
                hide: true,
                delimiter: ',',
                unique: true,
                removeWithBackspace: true
            }, options);

            var uniqueIdCounter = 0;

            this.each(function() {
                if (typeof $(this).data('tagsinput-init') !== 'undefined') return;

                $(this).data('tagsinput-init', true);

                if (settings.hide) $(this).hide();

                var id = $(this).attr('id');
                if (!id || _getDelimiter(delimiter[$(this).attr('id')])) {
                    id = $(this).attr('id', 'tags' + new Date().getTime() + (++uniqueIdCounter)).attr('id');
                }

                var data = jQuery.extend({
                    pid: id,
                    real_input: '#' + id,
                    holder: '#' + id + '_tagsinput',
                    input_wrapper: '#' + id + '_addTag',
                    fake_input: '#' + id + '_tag'
                }, settings);

                delimiter[id] = data.delimiter;
                inputSettings[id] = {
                    minChars: settings.minChars,
                    maxChars: settings.maxChars,
                    limit: settings.limit,
                    validationPattern: settings.validationPattern,
                    unique: settings.unique
                };

                if (settings.onAddTag || settings.onRemoveTag || settings.onChange) {
                    callbacks[id] = [];
                    callbacks[id]['onAddTag'] = settings.onAddTag;
                    callbacks[id]['onRemoveTag'] = settings.onRemoveTag;
                    callbacks[id]['onChange'] = settings.onChange;
                }

                var markup = $('<div>', {
                    id: id + '_tagsinput',
                    class: 'tagsinput'
                }).append(
                    $('<div>', {
                        id: id + '_addTag'
                    }).append(
                        settings.interactive ? $('<input>', {
                            id: id + '_tag',
                            class: 'tag-input',
                            value: '',
                            placeholder: settings.placeholder
                        }) : null
                    )
                );

                $(markup).insertAfter(this);

                $(data.holder).css('width', settings.width);
                $(data.holder).css('min-height', settings.height);
                $(data.holder).css('height', settings.height);

                if ($(data.real_input).val() !== '') {
                    $.fn.tagsInput.importTags($(data.real_input), $(data.real_input).val());
                }

                // Stop here if interactive option is not chosen
                if (!settings.interactive) return;

                $(data.fake_input).val('');
                $(data.fake_input).data('pasted', false);

                $(data.fake_input).on('focus', data, function(event) {
                    $(data.holder).addClass('focus');

                    if ($(this).val() === '') {
                        $(this).removeClass('error');
                    }
                });

                $(data.fake_input).on('blur', data, function(event) {
                    $(data.holder).removeClass('focus');
                });

                if (settings.autocomplete !== null && jQuery.ui.autocomplete !== undefined) {
                    $(data.fake_input).autocomplete(settings.autocomplete);
                    $(data.fake_input).on('autocompleteselect', data, function(event, ui) {
                        $(event.data.real_input).addTag(ui.item.value, {
                            focus: true,
                            unique: settings.unique
                        });

                        return false;
                    });

                    $(data.fake_input).on('keypress', data, function(event) {
                        if (_checkDelimiter(event)) {
                            $(this).autocomplete("close");
                        }
                    });
                } else {
                    $(data.fake_input).on('blur', data, function(event) {
                        $(event.data.real_input).addTag($(event.data.fake_input).val(), {
                            focus: true,
                            unique: settings.unique
                        });

                        return false;
                    });
                }

                // If a user types a delimiter create a new tag
                $(data.fake_input).on('keypress', data, function(event) {
                    if (_checkDelimiter(event)) {
                        event.preventDefault();

                        $(event.data.real_input).addTag($(event.data.fake_input).val(), {
                            focus: true,
                            unique: settings.unique
                        });

                        return false;
                    }
                });

                $(data.fake_input).on('paste', function() {
                    $(this).data('pasted', true);
                });

                // If a user pastes the text check if it shouldn't be splitted into tags
                $(data.fake_input).on('input', data, function(event) {
                    if (!$(this).data('pasted')) return;

                    $(this).data('pasted', false);

                    var value = $(event.data.fake_input).val();

                    value = value.replace(/\n/g, '');
                    value = value.replace(/\s/g, '');

                    var tags = _splitIntoTags(event.data.delimiter, value);

                    if (tags.length > 1) {
                        for (var i = 0; i < tags.length; ++i) {
                            $(event.data.real_input).addTag(tags[i], {
                                focus: true,
                                unique: settings.unique
                            });
                        }

                        return false;
                    }
                });

                // Deletes last tag on backspace
                data.removeWithBackspace && $(data.fake_input).on('keydown', function(event) {
                    if (event.keyCode == 8 && $(this).val() === '') {
                        event.preventDefault();
                        var lastTag = $(this).closest('.tagsinput').find('.tag:last > span').text();
                        var id = $(this).attr('id').replace(/_tag$/, '');
                        $('#' + id).removeTag(encodeURI(lastTag));
                        $(this).trigger('focus');
                    }
                });

                // Removes the error class when user changes the value of the fake input
                $(data.fake_input).keydown(function(event) {
                    // enter, alt, shift, esc, ctrl and arrows keys are ignored
                    if (jQuery.inArray(event.keyCode, [13, 37, 38, 39, 40, 27, 16, 17, 18, 225]) ===
                        -1) {
                        $(this).removeClass('error');
                    }
                });
            });

            return this;
        };

        $.fn.tagsInput.updateTagsField = function(obj, tagslist) {
            var id = $(obj).attr('id');
            $(obj).val(tagslist.join(_getDelimiter(delimiter[id])));
        };

        $.fn.tagsInput.importTags = function(obj, val) {
            $(obj).val('');

            var id = $(obj).attr('id');
            var tags = _splitIntoTags(delimiter[id], val);

            for (i = 0; i < tags.length; ++i) {
                $(obj).addTag(tags[i], {
                    focus: false,
                    callback: false
                });
            }

            if (callbacks[id] && callbacks[id]['onChange']) {
                var f = callbacks[id]['onChange'];
                f.call(obj, obj, tags);
            }
        };

        var _getDelimiter = function(delimiter) {
            if (typeof delimiter === 'undefined') {
                return delimiter;
            } else if (typeof delimiter === 'string') {
                return delimiter;
            } else {
                return delimiter[0];
            }
        };

        var _validateTag = function(value, inputSettings, tagslist, delimiter) {
            var result = true;

            if (value === '') result = false;
            if (value.length < inputSettings.minChars) result = false;
            if (inputSettings.maxChars !== null && value.length > inputSettings.maxChars) result = false;
            if (inputSettings.limit !== null && tagslist.length >= inputSettings.limit) result = false;
            if (inputSettings.validationPattern !== null && !inputSettings.validationPattern.test(value)) result =
                false;

            if (typeof delimiter === 'string') {
                if (value.indexOf(delimiter) > -1) result = false;
            } else {
                $.each(delimiter, function(index, _delimiter) {
                    if (value.indexOf(_delimiter) > -1) result = false;
                    return false;
                });
            }

            return result;
        };

        var _checkDelimiter = function(event) {
            var found = false;

            if (event.which === 13) {
                return true;
            }

            if (typeof event.data.delimiter === 'string') {
                if (event.which === event.data.delimiter.charCodeAt(0)) {
                    found = true;
                }
            } else {
                $.each(event.data.delimiter, function(index, delimiter) {
                    if (event.which === delimiter.charCodeAt(0)) {
                        found = true;
                    }
                });
            }

            return found;
        };

        var _splitIntoTags = function(delimiter, value) {
            if (value === '') return [];

            if (typeof delimiter === 'string') {
                return value.split(delimiter);
            } else {
                var tmpDelimiter = '∞';
                var text = value;

                $.each(delimiter, function(index, _delimiter) {
                    text = text.split(_delimiter).join(tmpDelimiter);
                });

                return text.split(tmpDelimiter);
            }

            return [];
        };
    })(jQuery);
    //end of variant related js 

    tinymce.init({
        selector: 'textarea',
        height: 130,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code wordcount'
        ],
        toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
        branding: false
    });

    $('select[name="type"]').on('change', function() {
        if ($(this).val() == 'combo') {
            $("input[name='cost']").prop('required', false);
            $("select[name='unit_id']").prop('required', false);
            hide();
            $("#combo").show(300);
            $("input[name='price']").prop('disabled', true);
            $("#is-variant").prop("checked", false);
            $("#is-diffPrice").prop("checked", false);
            $("#variant-section, #variant-option, #diffPrice-option, #diffPrice-section").hide(300);
        } else if ($(this).val() == 'digital') {
            $("input[name='cost']").prop('required', false);
            $("select[name='unit_id']").prop('required', false);
            $("input[name='file']").prop('required', true);
            hide();
            $("#digital").show(300);
            $("#combo").hide(300);
            $("input[name='price']").prop('disabled', false);
            $("#is-variant").prop("checked", false);
            $("#is-diffPrice").prop("checked", false);
            $("#variant-section, #variant-option, #diffPrice-option, #diffPrice-section, #batch-option").hide(300);
        } else if ($(this).val() == 'service') {
            $("input[name='cost']").prop('required', false);
            $("select[name='unit_id']").prop('required', false);
            $("input[name='file']").prop('required', true);
            hide();
            $("#combo").hide(300);
            $("#digital").hide(300);
            $("input[name='price']").prop('disabled', false);
            $("#is-variant").prop("checked", false);
            $("#is-diffPrice").prop("checked", false);
            $("#variant-section, #variant-option, #diffPrice-option, #diffPrice-section, #batch-option, #imei-option")
                .hide(300);
        } else if ($(this).val() == 'standard') {
            $("input[name='cost']").prop('required', true);
            $("select[name='unit_id']").prop('required', true);
            $("input[name='file']").prop('required', false);
            $("#cost").show(300);
            $("#unit").show(300);
            $("#alert-qty").show(300);
            $("#variant-option, #diffPrice-option, #batch-option, #imei-option").show(300);
            $("#digital").hide(300);
            $("#combo").hide(300);
            $("input[name='price']").prop('disabled', false);
        }
    });

    $('select[name="unit_id"]').on('change', function() {

        unitID = $(this).val();
        if (unitID) {
            populate_category(unitID);
        } else {
            $('select[name="sale_unit_id"]').empty();
            $('select[name="purchase_unit_id"]').empty();
        }
    });
    <?php $productArray = []; ?>
    var lims_product_code = [
        <?php $__currentLoopData = $lims_product_list_without_variant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $productArray[] = htmlspecialchars($product->code) . ' (' . preg_replace('/[\n\r]/', "<br>", htmlspecialchars($product->name)) . ')';
        ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $lims_product_list_with_variant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $productArray[] = htmlspecialchars($product->item_code) . ' (' . preg_replace('/[\n\r]/', "<br>", htmlspecialchars($product->name)) . ')';
        ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php
        echo  '"' . implode('","', $productArray) . '"';
        ?>
    ];

    var lims_productcodeSearch = $('#lims_productcodeSearch');

    lims_productcodeSearch.autocomplete({
        source: function(request, response) {
            var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(lims_product_code, function(item) {
                return matcher.test(item);
            }));
        },
        select: function(event, ui) {
            var data = ui.item.value;
            $.ajax({
                type: 'GET',
                url: 'lims_product_search',
                data: {
                    data: data
                },
                success: function(data) {
                    //console.log(data);
                    var flag = 1;
                    $(".product-id").each(function() {
                        if ($(this).val() == data[8]) {
                            alert('Duplicate input is not allowed!')
                            flag = 0;
                        }
                    });
                    $("input[name='product_code_name']").val('');
                    if (flag) {
                        var newRow = $("<tr>");
                        var cols = '';
                        cols += '<td>' + data[0] + ' [' + data[1] + ']</td>';
                        cols +=
                            '<td><input type="number" class="form-control qty" name="product_qty[]" value="1" step="any"/></td>';
                        cols +=
                            '<td><input type="number" class="form-control unit_price" name="unit_price[]" value="' +
                            data[2] + '" step="any"/></td>';
                        cols +=
                            '<td><button type="button" class="ibtnDel btn btn-sm btn-danger">X</button></td>';
                        cols +=
                            '<input type="hidden" class="product-id" name="product_id[]" value="' +
                            data[8] + '"/>';
                        cols += '<input type="hidden" class="" name="variant_id[]" value="' + data[
                            9] + '"/>';

                        newRow.append(cols);
                        $("table.order-list tbody").append(newRow);
                        calculate_price();
                    }
                }
            });
        }
    });

    //Change quantity or unit price
    $("#myTable").on('input', '.qty , .unit_price', function() {
        calculate_price();
    });

    //Delete product
    $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
        $(this).closest("tr").remove();
        calculate_price();
    });

    function hide() {
        $("#cost").hide(300);
        $("#unit").hide(300);
        $("#alert-qty").hide(300);
    }

    function calculate_price() {
        var price = 0;
        $(".qty").each(function() {
            rowindex = $(this).closest('tr').index();
            quantity = $(this).val();
            unit_price = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .unit_price').val();
            price += quantity * unit_price;
        });
        $('input[name="price"]').val(price);
    }

    function populate_category(unitID) {
        $.ajax({
            url: 'saleunit/' + unitID,
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('select[name="sale_unit_id"]').empty();
                $('select[name="purchase_unit_id"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="sale_unit_id"]').append('<option value="' + key + '">' + value +
                        '</option>');
                    $('select[name="purchase_unit_id"]').append('<option value="' + key + '">' + value +
                        '</option>');
                });
                $('.selectpicker').selectpicker('refresh');
            },
        });
    }

    $("input[name='is_initial_stock']").on("change", function() {
        if ($(this).is(':checked')) {
            if (numberOfWarehouse > 0)
                $("#initial-stock-section").show(300);
            else {
                alert('Please create warehouse first before adding stock!');
                $(this).prop("checked", false);
            }
        } else {
            $("#initial-stock-section").hide(300);
        }
    });

    $("input[name='is_batch']").on("change", function() {
        if ($(this).is(':checked')) {
            $("#variant-option").hide(300);
        } else
            $("#variant-option").show(300);
    });

    $("input[name='is_variant']").on("change", function() {
        if ($(this).is(':checked')) {
            $("#variant-section").show(300);
            $("#batch-option").hide(300);
            $(".variant-field").prop("required", true);
        } else {
            $("#variant-section").hide(300);
            $("#batch-option").show(300);
            $(".variant-field").prop("required", false);
        }
    });

    $("input[name='is_diffPrice']").on("change", function() {
        if ($(this).is(':checked')) {
            $("#diffPrice-section").show(300);
        } else
            $("#diffPrice-section").hide(300);
    });

    $("#promotion").on("change", function() {
        if ($(this).is(':checked')) {
            $("#starting_date").val($.datepicker.formatDate('dd-mm-yy', new Date()));
            $("#promotion_price").show(300);
            $("#start_date").show(300);
            $("#last_date").show(300);
        } else {
            $("#promotion_price").hide(300);
            $("#start_date").hide(300);
            $("#last_date").hide(300);
        }
    });

    var starting_date = $('#starting_date');
    starting_date.datepicker({
        format: "dd-mm-yyyy",
        startDate: "<?php echo date('d-m-Y'); ?>",
        autoclose: true,
        todayHighlight: true
    });

    var ending_date = $('#ending_date');
    ending_date.datepicker({
        format: "dd-mm-yyyy",
        startDate: "<?php echo date('d-m-Y'); ?>",
        autoclose: true,
        todayHighlight: true
    });

    $(window).keydown(function(e) {
        if (e.which == 13) {
            var $targ = $(e.target);

            if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
                var focusNext = false;
                $(this).find(":input:visible:not([disabled],[readonly]), a").each(function() {
                    if (this === e.target) {
                        focusNext = true;
                    } else if (focusNext) {
                        $(this).focus();
                        return false;
                    }
                });

                return false;
            }
        }
    });
    //dropzone portion
    Dropzone.autoDiscover = false;

    jQuery.validator.setDefaults({
        errorPlacement: function(error, element) {
            if (error.html() == 'Select Category...')
                error.html('This field is required.');
            $(element).closest('div.form-group').find('.validation-msg').html(error.html());
        },
        highlight: function(element) {
            $(element).closest('div.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('div.form-group').removeClass('has-error').addClass('has-success');
            $(element).closest('div.form-group').find('.validation-msg').html('');
        }
    });

    function validate() {
        var product_code = $("input[name='code']").val();
        var barcode_symbology = $('select[name="barcode_symbology"]').val();
        var exp = /^\d+$/;

        if (!(product_code.match(exp)) && (barcode_symbology == 'UPCA' || barcode_symbology == 'UPCE' ||
                barcode_symbology == 'EAN8' || barcode_symbology == 'EAN13')) {
            alert('Product code must be numeric.');
            return false;
        } else if (product_code.match(exp)) {
            if (barcode_symbology == 'UPCA' && product_code.length > 11) {
                alert('Product code length must be less than 12');
                return false;
            } else if (barcode_symbology == 'EAN8' && product_code.length > 7) {
                alert('Product code length must be less than 8');
                return false;
            } else if (barcode_symbology == 'EAN13' && product_code.length > 12) {
                alert('Product code length must be less than 13');
                return false;
            }
        }

        if ($("#type").val() == 'combo') {
            var rownumber = $('table.order-list tbody tr:last').index();
            if (rownumber < 0) {
                alert("Please insert product to table!")
                return false;
            }
        }
        if ($("#is-variant").is(":checked")) {
            rowindex = $("table#variant-table tbody tr:last").index();
            if (rowindex < 0) {
                alert('This product has variant. Please insert variant to table');
                return false;
            }
        }
        $("input[name='price']").prop('disabled', false);
        return true;
    }

    function validateAllFields() {

        $(".error-message").text(""); // Clear previous errors
        var isValid = true;

        var imageFiles = $('#file-input')[0].files;

        var selectImageElement = $("#file-input-error");
        if (imageFiles.length === 0) {
            isValid = false;
            selectImageElement.text("Please select atleast one image.");
        }

        if ($("#is-variant").is(":checked")) {
            $(".variant-field").each(function() {
                if ($(this).val() === "") {
                    isValid = false;
                    var fieldName = $(this).attr("name").replace("[]", "");
                    $("#" + fieldName + "-error").text("This field is required.");
                }
            });
        }

        // Validate variant fields




        var publishDateImage = document.getElementById("product_publish_date");

        publishDateImage.addEventListener("click", function() {
            alert("Image clicked!");
        });

        // Validate brand select field
        if ($("select[name='brand_id']").val() === "") {
            isValid = false;
            $("#brand_id-error").text("Please select a brand.");
        }

        $("#promotion").on("change", function() {
            if ($(this).is(':checked')) {
                $("#starting_date").val($.datepicker.formatDate('dd-mm-yy', new Date()));
                $("#promotion_price").show(300);
                $("#start_date").show(300);
                $("#last_date").show(300);
            }
        });







        // var proDiffPriceCheckbox = document.getElementById("is-diffPrice");

        // if (proDiffPriceCheckbox.checked) {
        //     alert("ware hourse price");
        //     alert($("input[name='diff_price']").contents);
        //     var productPriceElement = $("#diff_price-error");
        //     if ($("input[name='diff_price']").val() === "") {
        //         alert("price");
        //         isValid = false;
        //         productPriceElement.text("Please enter warehouse price.");
        //     }

        // }


        var promotionCheckbox = document.getElementById("promotion");

        if (promotionCheckbox.checked) {
            var productPromotionElement = $("#promotion_price-error");
            if ($("input[name='promotion_price']").val() === "") {
                isValid = false;
                productPromotionElement.text("Please enter promotion price.");
            }

            var promotionStartDateElement = $("#starting_date-error");
            if ($("input[name='starting_date']").val() === "") {
                isValid = false;
                promotionStartDateElement.text("Please enter promotion start date.");
            }
            var promotionLastDateElement = $("#last_date-error");
            if ($("input[name='last_date']").val() === "") {
                isValid = false;
                promotionLastDateElement.text("Please enter promotion end date.");
            }
        }





        if ($("select[name='prod_type']").val() === "") {
            isValid = false;
            $("#prod_type-error").text("Please select a Product Type.");
        }

        if ($("select[name='category_id']").val() === "") {
            isValid = false;
            $("#category_id-error").text("Please select a Category Type.");
        }



        if ($("select[name='ending_date']").val() === "") {
            isValid = false;
            $("#ending_date-error").text("Please select a End Date.");
        }

        if ($("select[name='starting_date']").val() === "") {
            isValid = false;
            $("#starting_date-error").text("Please select a Start Date.");
        }


        if ($("select[name='save_status']").val() === "") {
            isValid = false;
            $("#save_status-error").text("Please select save status.");
        }

        var productDetailsErrorMessageElement = $("#product_details-error");
        if (tinymce.get("product_details").getContent() === "") {
            isValid = false;
            productDetailsErrorMessageElement.text("Please enter product details.");
        }

        var nameElement = $("#name-error");
        if ($("input[name='name']").val() === "") {
            isValid = false;
            nameElement.text("Please enter your first name.");
        } else {
            var namePattern = /^[a-zA-Z0-9]+-[a-zA-Z0-9]+$/;

            if (!namePattern.test($("input[name='name']").val())) {
                isValid = false;
                nameElement.text("Name format is incorrect. It should be in the format 'name-[alphabets or numbers]' followed by numbers and optional letters and dashes.");
            } else {
                nameElement.text(""); // Clear the error message if the format is correct
            }
        }


        // var imageElement = $("#image-error");
        // var uploadedImagesCount = $(".dz-preview").length;
        // if (uploadedImagesCount === 0) {
        //     isValid = false;
        //     imageElement.text("Please upload at least one image.");
        // }


        var selectedTagsCount = $('.selected-tag').length;
        if (selectedTagsCount === 0) {
            $('#user_selected_tags-error').text("Please select at least one tag.");
            // return; // Prevent further execution
        }

        // Clear error message if tags are selected
        $('#user_selected_tags-error').text("");





        var codeElement = $("#code-error");
        if ($("input[name='code']").val() === "") {
            // alert("passs");
            isValid = false;
            codeElement.text("Please enter code.");
        }

        var barcodeSymbologyElement = $("#barcode_symbology-error");
        if ($("input[name='barcode_symbology']").val() === "") {
            isValid = false;
            barcodeSymbologyElement.text("Please select barcode type.");
        }

        var priceElement = $("#price-error");
        if ($("input[name='price']").val() === "") {
            isValid = false;
            priceElement.text("Please enter price.");
        }

        var compPriceElement = $("#comp_price-error");
        if ($("input[name='comp_price']").val() === "") {
            isValid = false;
            compPriceElement.text("Please enter compare price.");
        }

        var checkbox = document.getElementById("taxCharge");
        if (checkbox.checked) {
            var perItemCostElement = $("#per_item_cost-error");
            if ($("input[name='per_item_cost']").val() === "") {
                isValid = false;
                perItemCostElement.text("Please enter per item cost .");
            }
        }

        var checkbox = document.getElementById("customCheck1");
        if (checkbox.checked) {

            var productQuantityElement = $("#product_quantity-error");
            if ($("input[name='product_quantity']").val() === "") {
                isValid = false;
                productQuantityElement.text("Please enter product quantity .");
            }
        }

        var checkbox = document.getElementById("customCheck3");

        if (checkbox.checked) {

            var barCodeElement = $("#bar_code-error");
            if ($("input[name='bar_code']").val() === "") {
                isValid = false;
                barCodeElement.text("Please enter product barcode .");
            }

            var skuInputElement = $("#sku_input-error");
            if ($("input[name='sku_input']").val() === "") {
                isValid = false;
                skuInputElement.text("Please enter product sku .");
            }
        }

        var checkbox = document.getElementById("shipping");
        if (checkbox.checked) {

            var weightElement = $("#weight-error");
            if ($("input[name='weight']").val() === "") {
                isValid = false;
                weightElement.text("Please enter product weight .");
            }


            if ($("select[name='unit_id']").val() === "") {
                isValid = false;
                $("#unit_id-error").text("Please select product weight.");
            }


            if ($("select[name='country']").val() === "") {
                isValid = false;
                $("#country-error").text("Please select country Date.");
            }

            var harmonizedSystemElement = $("#harmonized_system-error");
            if ($("input[name='harmonized_system']").val() === "") {
                isValid = false;
                harmonizedSystemElement.text("Please enter harmonized.");
            }

        }
        var selectedTagsCount = $('.selected-tag').length;
        if (selectedTagsCount === 0) {
            $('#user_selected_tags-error').text("Please select at least one tag.");
            return; // Prevent further execution
        }

        // Clear error message if tags are selected
        $('#user_selected_tags-error').text("");

        return isValid;
    }

    $(".dropzone").sortable({
        items: '.dz-preview',
        cursor: 'grab',
        opacity: 0.5,
        containment: '.dropzone',
        distance: 20,
        tolerance: 'pointer',
        stop: function() {
            var queue = myDropzone.getAcceptedFiles();
            newQueue = [];
            $('#imageUpload .dz-preview .dz-filename [data-dz-name]').each(function(count, el) {
                var name = el.innerHTML;
                queue.forEach(function(file) {
                    if (file.name === name) {
                        newQueue.push(file);
                    }
                });
            });
            myDropzone.files = newQueue;
        }
    });

    // myDropzone = new Dropzone('div#imageUpload', {
    //     addRemoveLinks: true,
    //     autoProcessQueue: false,
    //     uploadMultiple: true,
    //     parallelUploads: 100,
    //     maxFilesize: 12,
    //     paramName: 'image',
    //     clickable: true,
    //     method: 'POST',
    //     url: '/product_store',

    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     renameFile: function(file) {
    //         var dt = new Date();
    //         var time = dt.getTime();
    //         return time + file.name;
    //     },
    //     acceptedFiles: ".jpeg,.jpg,.png,.gif",
    //     init: function() {
    //         var myDropzone = this;
    //         $('#submit-btn').on("click", function(e) {

    //             e.preventDefault();
    //             // if (validateAllFields()) {
    //             if ($("#product-form").valid() && validate()) {
    //                 tinyMCE.triggerSave();
    //                 if (myDropzone.getAcceptedFiles().length) {
    //                     myDropzone.processQueue();
    //                 } else {
    //                     var formData = new FormData();
    //                     var data = $("#product-form").serializeArray();
    //                     $.each(data, function(key, el) {
    //                         formData.append(el.name, el.value);
    //                     });
    //                     var file = $('#file')[0].files;
    //                     if (file.length > 0)
    //                         formData.append('file', file[0]);
    //                     $.ajax({
    //                         type: 'POST',
    //                         url: '/product_store',

    //                         data: formData,
    //                         contentType: false,
    //                         processData: false,
    //                         success: function(response) {
    //                             //console.log(response);
    //                             // location.href = '../products';
    //                         },
    //                         error: function(response) {
    //                             if (response.responseJSON.errors.name) {
    //                                 $("#name-error").text(response.responseJSON.errors
    //                                     .name);
    //                             } else if (response.responseJSON.errors.code) {
    //                                 $("#code-error").text(response.responseJSON.errors
    //                                     .code);
    //                             }
    //                         },
    //                     });
    //                 }
    //             }
    //             // }

    //         });

    //         this.on('sending', function(file, xhr, formData) {
    //             // Append all form inputs to the formData Dropzone will POST
    //             var data = $("#product-form").serializeArray();
    //             $.each(data, function(key, el) {
    //                 formData.append(el.name, el.value);
    //             });
    //             var file = $('#file')[0].files;
    //             if (file.length > 0)
    //                 formData.append('file', file[0]);
    //         });
    //     },
    //     error: function(file, response) {
    //         console.log(response);
    //         if (response.errors.name) {
    //             $("#name-error").text(response.errors.name);
    //             this.removeAllFiles(true);
    //         } else if (response.errors.code) {
    //             $("#code-error").text(response.errors.code);
    //             this.removeAllFiles(true);
    //         } else {
    //             try {
    //                 var res = JSON.parse(response);
    //                 if (typeof res.message !== 'undefined' && !$modal.hasClass('in')) {
    //                     $("#success-icon").attr("class", "fas fa-thumbs-down");
    //                     $("#success-text").html(res.message);
    //                     $modal.modal("show");
    //                 } else {
    //                     if ($.type(response) === "string")
    //                         var message = response; //dropzone sends it's own error messages in string
    //                     else
    //                         var message = response.message;
    //                     file.previewElement.classList.add("dz-error");
    //                     _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
    //                     _results = [];
    //                     for (_i = 0, _len = _ref.length; _i < _len; _i++) {
    //                         node = _ref[_i];
    //                         _results.push(node.textContent = message);
    //                     }
    //                     return _results;
    //                 }
    //             } catch (error) {
    //                 console.log(error);
    //             }
    //         }
    //     },
    //     successmultiple: function(file, response) {
    //         location.href = '../products';
    //         //console.log(file, response);
    //     },
    //     completemultiple: function(file, response) {
    //         console.log(file, response, "completemultiple");
    //     },
    //     reset: function() {
    //         console.log("resetFiles");
    //         this.removeAllFiles(true);
    //     }
    // });
    $('#submit-btn').on("click", function(e) {

        e.preventDefault();
        if (validateAllFields()) {
            if ($("#product-form").valid() && validate()) {
                tinyMCE.triggerSave();

                var formData = new FormData();
                var data = $("#product-form").serializeArray();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                var imageFiles = $('#file-input')[0].files;
                console.log(imageFiles);
                for (var i = 0; i < imageFiles.length; i++) {
                    formData.append('pro_image[]', imageFiles[i]);
                }
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: '/product_store',

                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        //console.log(response);
                        location.href = '../products';
                    },
                    error: function(response) {
                        if (response.responseJSON.errors.name) {
                            $("#name-error").text(response.responseJSON.errors
                                .name);
                        } else if (response.responseJSON.errors.code) {
                            $("#code-error").text(response.responseJSON.errors
                                .code);
                        }
                    },
                });
            }
        }

    });



    function toggleTax() {
        var checkbox = document.getElementById("taxCharge");
        var quantityField = document.getElementById("pro_mar");
        if (checkbox.checked) {
            quantityField.style.display = "flex";
        } else {
            quantityField.style.display = "none";
        }
    }


    function updateHiddenInput(name, value, rowIndex) {
        const inputName = `${name}[${rowIndex}]`;
        const inputField = document.createElement('input');
        inputField.type = 'hidden';
        inputField.name = inputName;
        inputField.value = value;
        document.getElementById('hiddenForm').appendChild(inputField);
    }

    var variantPlaceholder = <?php echo json_encode(trans('file.Enter variant value seperated by comma')); ?>;
    var variantIds = [];
    var combinations = [];
    var oldCombinations = [];
    var oldAdditionalCost = [];
    var oldAdditionalPrice = [];
    var step;
    var numberOfWarehouse = <?php echo json_encode(count($lims_warehouse_list)) ?>;

    $('[data-toggle="tooltip"]').tooltip();


    $('.add-more-variant').on("click", function() {
        var variantListElement = document.getElementById("variant-section");
        if (variantListElement.style.display === "none") {
            variantListElement.style.display = "block";
        }
        // else {
        //     var tableRow =
        //         '<tr class="table_body  text-center"><td class="variantOptionValue"></td><td>    <input type="text" class="form-control" name="var_price" id="var_price" value="<?php echo e(old("var_price")); ?>" style="border: 1px solid black; border-radius: 5px;"></td><td>    <input type="text" class="form-control" name="var_available" value="<?php echo e(old("var_available")); ?>" style="border: 1px solid black; border-radius: 5px;"></td><td>    <input type="text" class="form-control" name="var_on_hand" value="<?php echo e(old("var_on_hand")); ?>" style="border: 1px solid black; border-radius: 5px;"></td><td>    <input type="text" class="form-control" name="var_sku" value="<?php echo e(old("var_sku")); ?>" style="border: 1px solid black; border-radius: 5px;"></td><td>    <input type="text" class="form-control" name="var_barcode" value="<?php echo e(old("var_barcode")); ?>" style="border: 1px solid black; border-radius: 5px;"></td><td>    <button type="button" class="btn border text-black bg-light " style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); border-radius: 5px;"><i class="fa-solid fa-trash-can"></i></button></td</tr>'
        //     $("#variant-table tbody").append(tableRow);
        //     var htmlText =
        //         '<div class="col-md-12 form-group mt-2"><label>Option *</label><input type="text" name="variant_option[]" class="form-control variant-field" placeholder="Size, Color etc..."></div><div class="col-md-12 form-group mt-2"><label>Value *</label><input type="text" name="variant_value[]" class="type-variant form-control variant-field"></div><div class="form-group"><button type="button" onclick="hideNAppend()" class="btn border text-black bg-light mb-1 ml-3" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); border-radius: 5px;">Done</button></div>';
        //     $("#variant-input-section").append(htmlText);
        //     $('.type-variant').tagsInput();

        // }

    });
    // Variants Code End


    function toggleQuantityField() {
        var checkbox = document.getElementById("customCheck1");
        var quantityField = document.getElementById("toggle_quantity");

        if (checkbox.checked) {
            quantityField.style.display = "block";
        } else {
            quantityField.style.display = "none";
        }
    }

    function toggleStockField() {
        var checkbox = document.getElementById("customCheck2");
        var quantityField = document.getElementById("stock_out");

        if (checkbox.checked) {
            quantityField.style.display = "none";
        } else {
            quantityField.style.display = "block";
        }
    }

    function toggleBarcodeField() {
        var checkbox = document.getElementById("customCheck3");
        var barcodeFields = document.getElementById("barcode");

        if (checkbox.checked) {
            barcodeFields.style.display = "flex";
        } else {
            barcodeFields.style.display = "none";
        }
    }

    function toggleShippingField() {
        var checkbox = document.getElementById("shipping");
        var shippingFields = document.getElementById("shipping_field");

        if (checkbox.checked) {
            shippingFields.style.display = "block";
        } else {
            shippingFields.style.display = "none";
        }
    }

    function toggleCustomField() {
        var customInfoElement = document.getElementById("custom_info");
        var jsCodeBlock = document.getElementById("custom_info_div");
        if (jsCodeBlock.style.display === "none") {
            customInfoElement.style.display = "none";
            jsCodeBlock.style.display = "block";
        } else {
            jsCodeBlock.style.display = "none";
        }
    }

    function toggleVariant() {
        var variantsDiv = document.getElementById("variants_div");
        if (variantsDiv.style.display === "none") {
            variantsDiv.style.display = "block";
        } else {
            variantsDiv.style.display = "none";
        }
    }

    function belowField() {
        var extraOption = document.getElementById("extraOption");
        extraOption.style.display = "block";
    }

    function getValue() {
        var price = parseFloat(document.querySelector(".price").value);
        var cost = parseFloat(document.querySelector(".cost_per_item").value);
        var profit = price - cost;
        var price = parseFloat(document.querySelector(".price").value);
        var cost = parseFloat(document.querySelector(".cost_per_item").value);
        var profit = price - cost;

        if (profit > 1) {
            document.querySelector('.profit_value').value = profit;
            var margin = (profit / price) * 100;
            document.querySelector('.margin_value').value = margin.toFixed(2) + '%';
        } else {
            document.querySelector('.profit_value').value = "";
            document.querySelector('.margin_value').value = "";
        }

        // const margin = ((price - cost) / cost) * 100;
        // document.querySelector(".margin").value = margin;

    }

    //  Schedule Date 
    $('.schedule_date').on('click', function() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();

        $('#sch_start_date').val(startDate);
        $('#sch_end_date').val(endDate);

        $('#exampleModal').modal('hide');
    });

    $('#search_tags').on('keyup', function() {
        var query = $(this).val();
        $.ajax({
            url: "<?php echo e(route('search_tags')); ?>",
            type: "GET",
            data: {
                'query': query
            },
            success: function(data) {
                var maxSuggestions =
                    5; // Maximum number of suggestions to display   string.substring(0, length)
                var suggestions = data.slice(0, maxSuggestions).map(tag =>
                    '<div class="tag-option mt-2 tx">' + tag.title.substr(0, 35) + '</div>').join(
                    '');
                $('#tag_suggestions').html(suggestions);
                var inputWidth = $('#search_tags').outerWidth();
                $('#tag_suggestions').css('width', inputWidth);
            }
        })
    });
    var selectedTags = [];

    $('#tag_suggestions').on('click', '.tag-option', function() {

        var selectedTag = $(this).text().trim();

        // Append the selected tag to the selected_tag_suggestions with styling and remove button
        $('#selected_tag_suggestions').append('<div class="selected-tag">' + selectedTag +
            '<span class="remove-tag">✕</span></div>');

        // Clear the input and suggestions
        $('#search_tags').val('');
        $('#tag_suggestions').empty();

        selectedTags.push(selectedTag);
        $('#tag_collection').val(selectedTags.join(','));


    });

    $('#selected_tag_suggestions').on('click', '.remove-tag', function() {
        $(this).parent('.selected-tag').remove();
    });
</script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $('#summernote').summernote({
        height: 400
    });
</script>
<script src="<?php echo e(asset('calender/date-picker.js')); ?>"></script>
<!-- Include Dropzone.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

<script>
    // Initialize Dropzone
    Dropzone.autoDiscover = false; // Prevent Dropzone from automatically discovering elements with the "dropzone" class

    // Initialize Dropzone on the element with the id "imageUpload"
    var myDropzone = new Dropzone("#imageUpload", {
        acceptedFiles: ".jpeg, .jpg, .png, .gif", // Define the accepted file types
        maxFiles: 10, // Maximum number of files allowed
        maxFilesize: 5, // Maximum file size in megabytes
        parallelUploads: 1, // Number of files to upload in parallel (set to 1 for sequential uploads)
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Development-Software\IDE\wamp64\www\pakistan_fashion_lounge\resources\views/backend/product/create.blade.php ENDPATH**/ ?>