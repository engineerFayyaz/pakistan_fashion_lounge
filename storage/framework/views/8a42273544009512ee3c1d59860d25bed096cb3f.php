 
<?php $__env->startSection('content'); ?>
<?php if(session()->has('create_message')): ?>
<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('create_message')); ?></div>
<?php endif; ?>
<?php if(session()->has('edit_message')): ?>
<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('edit_message')); ?></div>
<?php endif; ?>
<?php if(session()->has('import_message')): ?>
<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('import_message')); ?></div>
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div>
<?php endif; ?>
<?php if(session()->has('message')): ?>
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div>
<?php endif; ?>

<section>
    <div class="container-fluid">
        <?php if(in_array("products-add", $all_permission)): ?>
        <a href="<?php echo e(route('products.create')); ?>" class="btn btn-info add-product-btn"><i class="dripicons-plus"></i> <?php echo e(__('file.add_product')); ?></a>
        <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary add-product-btn"><i class="dripicons-copy"></i> <?php echo e(__('file.import_product')); ?></a>
        <?php endif; ?>
    </div>
    <div class="table-responsive">
        <table id="product-data-table" class="table" style="width: 100%">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Image')); ?></th>
                    <th><?php echo e(trans('file.name')); ?></th>
                    <th><?php echo e(trans('file.Code')); ?></th>
                    <th>Vendor</th>
                    <th><?php echo e(trans('file.category')); ?></th>
                    <th><?php echo e(trans('file.Quantity')); ?></th>
                    <th>Status</th>
                    <th><?php echo e(trans('file.Price')); ?></th>
                    <th>Inventory Quantitys</th>
                    <th>Created_At</th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
        </table>
    </div>
</section>

<div id="importProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <?php echo Form::open(['route' => 'product.import', 'method' => 'post', 'files' => true]); ?>

            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">Import Product</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                <p><?php echo e(trans('file.The correct column order is')); ?> (image, name*, code*, type*, brand, category*, unit_code*, cost*, price*, product_details, variant_name, item_code, additional_price) <?php echo e(trans('file.and you must follow this')); ?>.</p>
                <p><?php echo e(trans('file.To display Image it must be stored in')); ?> public/images/product <?php echo e(trans('file.directory')); ?>. <?php echo e(trans('file.Image name must be same as product name')); ?></p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?php echo e(trans('file.Upload CSV File')); ?> *</label>
                            <?php echo e(Form::file('file', array('class' => 'form-control','required'))); ?>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> <?php echo e(trans('file.Sample File')); ?></label>
                            <a href="sample_file/sample_products.csv" class="btn btn-info btn-block btn-md"><i class="dripicons-download"></i> <?php echo e(trans('file.Download')); ?></a>
                        </div>
                    </div>
                </div>
                <?php echo e(Form::submit('Submit', ['class' => 'btn btn-primary'])); ?>

            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>

<div id="product-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('Product Details')); ?></h5>
                <button id="print-btn" type="button" class="btn btn-default btn-sm ml-3"><i class="dripicons-print"></i> <?php echo e(trans('file.Print')); ?></button>
                <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5" id="slider-content"></div>
                    <div class="col-md-5 offset-1" id="product-content"></div>
                    <?php if($role_id <= 2): ?> <div class="col-md-12 mt-2" id="product-warehouse-section">
                        <h5><?php echo e(trans('file.Warehouse Quantity')); ?></h5>
                        <table class="table table-bordered table-hover product-warehouse-list">
                            <thead>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                </div>
                <?php endif; ?>
                <div class="col-md-7 mt-2" id="product-variant-section">
                    <h5><?php echo e(trans('file.Product Variant Information')); ?></h5>
                    <table class="table table-bordered table-hover product-variant-list">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <?php if($role_id <= 2): ?> <div class="col-md-5 mt-2" id="product-variant-warehouse-section">
                    <h5><?php echo e(trans('file.Warehouse quantity of product variants')); ?></h5>
                    <table class="table table-bordered table-hover product-variant-warehouse-list">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
            </div>
            <?php endif; ?>
        </div>

        <h5 id="combo-header"></h5>
        <table class="table table-bordered table-hover item-list">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    $("ul#product").siblings('a').attr('aria-expanded', 'true');
    $("ul#product").addClass("show");
    $("ul#product #product-list-menu").addClass("active");

    <?php if(config('database.connections.saleprosaas_landlord')): ?>
    if (localStorage.getItem("message")) {
        alert(localStorage.getItem("message"));
        localStorage.removeItem("message");
    }

    numberOfProduct = <?php echo json_encode($numberOfProduct) ?>;
    $.ajax({
        type: 'GET',
        async: false,
        url: '<?php echo e(route("package.fetchData", $general_setting->package_id)); ?>',
        success: function(data) {
            if (data['number_of_product'] > 0 && data['number_of_product'] <= numberOfProduct) {
                $("a.add-product-btn").addClass('d-none');
            }
        }
    });
    <?php endif; ?>

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    var warehouse = [];
    var variant = [];
    var qty = [];
    var htmltext;
    var slidertext;
    var product_id = [];
    var all_permission = <?php echo json_encode($all_permission) ?>;
    var role_id = <?php echo json_encode($role_id) ?>;
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;
    var logoUrl = <?php echo json_encode(url('logo', $general_setting->site_logo)) ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#select_all").on("change", function() {
        if ($(this).is(':checked')) {
            $("tbody input[type='checkbox']").prop('checked', true);
        } else {
            $("tbody input[type='checkbox']").prop('checked', false);
        }
    });

    $(document).on("click", "tr.product-link td:not(:first-child, :last-child)", function() {
        productDetails($(this).parent().data('product'), $(this).parent().data('imagedata'));
    });

    $(document).on("click", ".view", function() {
        var product = $(this).parent().parent().parent().parent().parent().data('product');
        var productArray = product.split(',');
        // var type = productArray[0].trim();         
        // alert(type);

        var imagedata = $(this).parent().parent().parent().parent().parent().data('imagedata');
        productDetails(productArray, imagedata);
    });

    $("#print-btn").on("click", function() {
        var divToPrint = document.getElementById('product-details');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css"><style type="text/css">@media  print {.modal-dialog { max-width: 1000px;} }</style><body onload="window.print()">' + divToPrint.innerHTML + '</body>');
        newWin.document.close();
        //   setTimeout(function(){newWin.close();},10);
    });

    function productDetails(productArray, imagedata) {

        // product[11] = product[11].replace(/@/g, '"');
        htmltext = slidertext = '';

        const srcIndex = productArray[19].indexOf('src=');

        let srcValue = productArray[19].slice(srcIndex + 5);

        srcValue = srcValue.split(' ')[0];

        srcValue = srcValue.replace(/"/g, '');


        htmltext = '<p><strong><?php echo e(trans("file.Type")); ?>: </strong>' + productArray[0].trim() + '</p><p><strong><?php echo e(trans("file.name")); ?>: </strong>' + productArray[1].trim() + '</p><p><strong><?php echo e(trans("file.Code")); ?>: </strong>' + productArray[2].trim() + '</p><p><strong><?php echo e(trans("file.Brand")); ?>: </strong>' + productArray[3].trim() + '</p><p><strong><?php echo e(trans("file.category")); ?>: </strong>' + productArray[4].trim() + '</p><p><strong><?php echo e(trans("file.Quantity")); ?>: </strong>' + productArray[17].trim() + '</p><p><strong><?php echo e(trans("file.Unit")); ?>: </strong>' + productArray[5].trim() + '</p><p><strong><?php echo e(trans("file.Cost")); ?>: </strong>' + productArray[6].trim() + '</p><p><strong><?php echo e(trans("file.Price")); ?>: </strong>' + productArray[7].trim() + '</p><p><strong><?php echo e(trans("file.Tax")); ?>: </strong>' + productArray[8].trim() + '</p><p><strong><?php echo e(trans("file.Tax Method")); ?> : </strong>' + productArray[9].trim() + '</p><p><strong><?php echo e(trans("file.Alert Quantity")); ?> : </strong>' + productArray[10].trim() + '</p><p><strong><?php echo e(trans("file.Product Details")); ?>: </strong></p>' + productArray[11].trim();

        if (srcValue) {
            // var product_image = product[18].split(",");
            if (srcValue.length > 0) {
                slidertext = '<div id="product-img-slider" class="carousel slide" data-ride="carousel"><div class="carousel-inner">';
                // for (var i = 0; i < srcValue.length; i++) {
                // if (!i)
                slidertext += '<div class="carousel-item active"><img src="' + srcValue + '" height="300" width="100%"></div>';
                // else
                //     slidertext += '<div class="carousel-item"><img src="' + srcValue[i] + '" height="300" width="100%"></div>';
                // }
                slidertext += '</div><a class="carousel-control-prev" href="#product-img-slider" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#product-img-slider" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a></div>';
            } else {
                slidertext = '<img src="images/product/' + product[18] + '" height="300" width="100%">';
            }
        } else {
            slidertext = '<img src="images/product/zummXD2dvAtI.png" height="300" width="100%">';
        }
        $("#combo-header").text('');
        $("table.item-list thead").remove();
        $("table.item-list tbody").remove();
        $("table.product-warehouse-list thead").remove();
        $("table.product-warehouse-list tbody").remove();
        $(".product-variant-list thead").remove();
        $(".product-variant-list tbody").remove();
        $(".product-variant-warehouse-list thead").remove();
        $(".product-variant-warehouse-list tbody").remove();
        $("#product-warehouse-section").addClass('d-none');
        $("#product-variant-section").addClass('d-none');
        $("#product-variant-warehouse-section").addClass('d-none');
        if (product[0] == 'combo') {
            $("#combo-header").text('<?php echo e(trans("file.Combo Products")); ?>');
            product_list = product[13].split(",");
            variant_list = product[14].split(",");
            qty_list = product[15].split(",");
            price_list = product[16].split(",");
            $(".item-list thead").remove();
            $(".item-list tbody").remove();
            var newHead = $("<thead>");
            var newBody = $("<tbody>");
            var newRow = $("<tr>");
            newRow.append('<th><?php echo e(trans("file.product")); ?></th><th><?php echo e(trans("file.Quantity")); ?></th><th><?php echo e(trans("file.Price")); ?></th>');
            newHead.append(newRow);

            $(product_list).each(function(i) {
                if (!variant_list[i])
                    variant_list[i] = 0;
                $.get('products/getdata/' + product_list[i] + '/' + variant_list[i], function(data) {
                    var newRow = $("<tr>");
                    var cols = '';
                    cols += '<td>' + data['name'] + ' [' + data['code'] + ']</td>';
                    cols += '<td>' + qty_list[i] + '</td>';
                    cols += '<td>' + price_list[i] + '</td>';

                    newRow.append(cols);
                    newBody.append(newRow);
                });
            });

            $("table.item-list").append(newHead);
            $("table.item-list").append(newBody);
        } else if (product[0] == 'standard') {
            if (product[19]) {
                $.get('products/variant-data/' + product[12], function(variantData) {
                    var newHead = $("<thead>");
                    var newBody = $("<tbody>");
                    var newRow = $("<tr>");
                    newRow.append('<th><?php echo e(trans("file.Variant")); ?></th><th><?php echo e(trans("file.Item Code")); ?></th><th><?php echo e(trans("file.Additional Cost")); ?></th><th><?php echo e(trans("file.Additional Price")); ?></th><th><?php echo e(trans("file.Qty")); ?></th>');
                    newHead.append(newRow);
                    $.each(variantData, function(i) {
                        var newRow = $("<tr>");
                        var cols = '';
                        cols += '<td>' + variantData[i]['name'] + '</td>';
                        cols += '<td>' + variantData[i]['item_code'] + '</td>';
                        if (variantData[i]['additional_cost'])
                            cols += '<td>' + variantData[i]['additional_cost'] + '</td>';
                        else
                            cols += '<td>0</td>';
                        if (variantData[i]['additional_price'])
                            cols += '<td>' + variantData[i]['additional_price'] + '</td>';
                        else
                            cols += '<td>0</td>';
                        cols += '<td>' + variantData[i]['qty'] + '</td>';

                        newRow.append(cols);
                        newBody.append(newRow);
                    });
                    $("table.product-variant-list").append(newHead);
                    $("table.product-variant-list").append(newBody);
                });
                $("#product-variant-section").removeClass('d-none');
            }
            if (role_id <= 2) {
                $.get('products/product_warehouse/' + product[12], function(data) {
                    if (data.product_warehouse[0].length != 0) {
                        warehouse = data.product_warehouse[0];
                        qty = data.product_warehouse[1];
                        batch = data.product_warehouse[2];
                        expired_date = data.product_warehouse[3];
                        imei_numbers = data.product_warehouse[4];
                        var newHead = $("<thead>");
                        var newBody = $("<tbody>");
                        var newRow = $("<tr>");
                        newRow.append('<th><?php echo e(trans("file.Warehouse")); ?></th><th><?php echo e(trans("file.Batch No")); ?></th><th><?php echo e(trans("file.Expired Date")); ?></th><th><?php echo e(trans("file.Quantity")); ?></th><th><?php echo e(trans("file.IMEI or Serial Numbers")); ?></th>');
                        newHead.append(newRow);
                        $.each(warehouse, function(index) {
                            var newRow = $("<tr>");
                            var cols = '';
                            cols += '<td>' + warehouse[index] + '</td>';
                            cols += '<td>' + batch[index] + '</td>';
                            cols += '<td>' + expired_date[index] + '</td>';
                            cols += '<td>' + qty[index] + '</td>';
                            cols += '<td>' + imei_numbers[index] + '</td>';

                            newRow.append(cols);
                            newBody.append(newRow);
                            $("table.product-warehouse-list").append(newHead);
                            $("table.product-warehouse-list").append(newBody);
                        });
                        $("#product-warehouse-section").removeClass('d-none');
                    }
                    if (data.product_variant_warehouse[0].length != 0) {
                        warehouse = data.product_variant_warehouse[0];
                        variant = data.product_variant_warehouse[1];
                        qty = data.product_variant_warehouse[2];
                        var newHead = $("<thead>");
                        var newBody = $("<tbody>");
                        var newRow = $("<tr>");
                        newRow.append('<th><?php echo e(trans("file.Warehouse")); ?></th><th><?php echo e(trans("file.Variant")); ?></th><th><?php echo e(trans("file.Quantity")); ?></th>');
                        newHead.append(newRow);
                        $.each(warehouse, function(index) {
                            var newRow = $("<tr>");
                            var cols = '';
                            cols += '<td>' + warehouse[index] + '</td>';
                            cols += '<td>' + variant[index] + '</td>';
                            cols += '<td>' + qty[index] + '</td>';

                            newRow.append(cols);
                            newBody.append(newRow);
                            $("table.product-variant-warehouse-list").append(newHead);
                            $("table.product-variant-warehouse-list").append(newBody);
                        });
                        $("#product-variant-warehouse-section").removeClass('d-none');
                    }
                });
            }
        }

        $('#product-content').html(htmltext);
        $('#slider-content').html(slidertext);
        $('#product-details').modal('show');
        $('#product-img-slider').carousel(0);
    }

    $(document).ready(function() {
        var table = $('#product-data-table').DataTable({
            responsive: true,
            fixedHeader: {
                header: true,
                footer: true
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "products/product-data",
                data: {
                    all_permission: all_permission
                },
                dataType: "json",
                type: "post"
            },
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('product-link');
                $(row).attr('data-product', data['product']);
                $(row).attr('data-imagedata', data['imagedata']);
            },
            "columns": [{
                    "data": "key"
                },
                {
                    "data": "image"
                },
                {
                    "data": "name"
                },
                {
                    "data": "code"
                },
                {
                    "data": "brand"
                },
                {
                    "data": "category"
                },
                {
                    "data": "qty"
                },
                {
                    "data": "unit"
                },
                {
                    "data": "price"
                },
                {
                    "data": "cost"
                },
                {
                    "data": "stock_worth"
                },
                {
                    "data": "options"
                },
            ],
            'language': {
                /*'searchPlaceholder': "<?php echo e(trans('file.Type Product Name or Code...')); ?>",*/
                'lengthMenu': '_MENU_ <?php echo e(trans("file.records per page")); ?>',
                "info": '<small><?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)</small>',
                "search": '<?php echo e(trans("file.Search")); ?>',
                'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
                }
            },
            order: [
                ['2', 'asc']
            ],
            'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 1, 9, 10, 11]
                },
                {
                    'render': function(data, type, row, meta) {
                        if (type === 'display') {
                            data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                    },
                    'targets': [0]
                }
            ],
            'select': {
                style: 'multi',
                selector: 'td:first-child'
            },
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"row"lfB>rtip',
            buttons: [{
                    extend: 'pdf',
                    text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible',
                        stripHtml: false
                    },
                    customize: function(doc) {
                        for (var i = 1; i < doc.content[1].table.body.length; i++) {
                            if (doc.content[1].table.body[i][0].text.indexOf('<img src=') !== -1) {
                                var imagehtml = doc.content[1].table.body[i][0].text;
                                var regex = /<img.*?src=['"](.*?)['"]/;
                                var src = regex.exec(imagehtml)[1];
                                var tempImage = new Image();
                                tempImage.src = src;
                                var canvas = document.createElement("canvas");
                                canvas.width = tempImage.width;
                                canvas.height = tempImage.height;
                                var ctx = canvas.getContext("2d");
                                ctx.drawImage(tempImage, 0, 0);
                                var imagedata = canvas.toDataURL("image/png");
                                delete doc.content[1].table.body[i][0].text;
                                doc.content[1].table.body[i][0].image = imagedata;
                                doc.content[1].table.body[i][0].fit = [30, 30];
                            }
                        }
                    },
                },
                {
                    extend: 'excel',
                    text: '<i title="export to excel" class="dripicons-document-new"></i>',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                    var regex = /<img.*?src=['"](.*?)['"]/;
                                    data = regex.exec(data)[1];
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'csv',
                    text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                    var regex = /<img.*?src=['"](.*?)['"]/;
                                    data = regex.exec(data)[1];
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'print',
                    title: '',
                    text: '<i title="print" class="fa fa-print"></i>',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible',
                        stripHtml: false
                    },
                    repeatingHead: {
                        logo: logoUrl,
                        logoPosition: 'left',
                        logoStyle: '',
                        title: '<h3>Product List</h3>'
                    }
                    /*customize: function ( win ) {
                        $(win.document.body)
                            .prepend(
                                '<img src="http://datatables.net/media/images/logo-fade.png" style="margin:10px;" />'
                            );
                    }*/
                },
                {
                    text: '<i title="delete" class="dripicons-cross"></i>',
                    className: 'buttons-delete',
                    action: function(e, dt, node, config) {
                        if (user_verified == '1') {
                            product_id.length = 0;
                            $(':checkbox:checked').each(function(i) {
                                if (i) {
                                    var product_data = $(this).closest('tr').data('product');
                                    product_id[i - 1] = product_data[12];
                                }
                            });
                            if (product_id.length && confirmDelete()) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'products/deletebyselection',
                                    data: {
                                        productIdArray: product_id
                                    },
                                    success: function(data) {
                                        //dt.rows({ page: 'current', selected: true }).deselect();
                                        dt.rows({
                                            page: 'current',
                                            selected: true
                                        }).remove().draw(false);
                                    }
                                });
                            } else if (!product_id.length)
                                alert('No product is selected!');
                        } else
                            alert('This feature is disable for demo!');
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i title="column visibility" class="fa fa-eye"></i>',
                    columns: ':gt(0)'
                },
            ],
        });

    });

    if (all_permission.indexOf("products-delete") == -1)
        $('.buttons-delete').addClass('d-none');

    $('select').selectpicker();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Development-Software\IDE\wamp64\www\pakistan_fashion_lounge\resources\views/backend/product/index.blade.php ENDPATH**/ ?>