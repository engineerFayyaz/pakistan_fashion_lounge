 <?php $__env->startSection('content'); ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div>
<?php endif; ?>

<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center"><?php echo e(trans('file.Product History')); ?></h3>
            </div>
            <?php echo Form::open(['route' => 'products.history', 'method' => 'get']); ?>

            <div class="row ml-1">
                <input type="hidden" name="product_id" value="<?php echo e($product_id); ?>">
                <div class="col-md-4">
                    <div class="form-group">
                        <h4 class="mt-4"><?php echo e($product_data->name.' ['.$product_data->code.']'); ?></h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Date')); ?></strong></label>
                        <input type="text" class="daterangepicker-field form-control" value="<?php echo e($starting_date); ?> To <?php echo e($ending_date); ?>" required />
                        <input type="hidden" name="starting_date" value="<?php echo e($starting_date); ?>" />
                        <input type="hidden" name="ending_date" value="<?php echo e($ending_date); ?>" />
                    </div>
                </div>
                <div class="col-md-3 <?php if(\Auth::user()->role_id > 2): ?><?php echo e('d-none'); ?><?php endif; ?>">
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Warehouse')); ?></strong></label>
                        <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                            <option value="0"><?php echo e(trans('file.All Warehouse')); ?></option>
                            <?php $__currentLoopData = $lims_warehouse_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($warehouse->id); ?>"><?php echo e($warehouse->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 mt-4">
                    <div class="form-group">
                        <button class="btn btn-primary" id="filter-btn" type="submit"><?php echo e(trans('file.submit')); ?></button>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
    <ul class="nav nav-tabs ml-4 mt-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#product-sale" role="tab" data-toggle="tab"><?php echo e(trans('file.Sale')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#product-purchase" role="tab" data-toggle="tab"><?php echo e(trans('file.Purchase')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#product-sale-return" role="tab" data-toggle="tab"><?php echo e(trans('file.Sale Return')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#product-purchase-return" role="tab" data-toggle="tab"><?php echo e(trans('file.Purchase Return')); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <!-- sale table -->
        <div role="tabpanel" class="tab-pane fade show active" id="product-sale">
            <div class="table-responsive mb-4">
                <table id="sale-table" class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="not-exported-sale"></th>
                            <th><?php echo e(trans('file.Date')); ?></th>
                            <th><?php echo e(trans('file.reference')); ?></th>
                            <th><?php echo e(trans('file.Warehouse')); ?></th>
                            <th><?php echo e(trans('file.customer')); ?></th>
                            <th><?php echo e(trans('file.qty')); ?></th>
                            <th><?php echo e(trans('file.Unit Price')); ?></th>
                            <th><?php echo e(trans('file.Subtotal')); ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- purchase table -->
        <div role="tabpanel" class="tab-pane fade" id="product-purchase">
            <div class="table-responsive mb-4">
                <table id="purchase-table" class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="not-exported-purchase"></th>
                            <th><?php echo e(trans('file.Date')); ?></th>
                            <th><?php echo e(trans('file.reference')); ?></th>
                            <th><?php echo e(trans('file.Warehouse')); ?></th>
                            <th><?php echo e(trans('file.Supplier')); ?></th>
                            <th><?php echo e(trans('file.qty')); ?></th>
                            <th><?php echo e(trans('file.Unit Price')); ?></th>
                            <th><?php echo e(trans('file.Subtotal')); ?></th>
                        </tr>
                    </thead>

                    <tfoot class="tfoot active">
                        <th></th>
                        <th><?php echo e(trans('file.Total')); ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- sale return table -->
        <div role="tabpanel" class="tab-pane fade" id="product-sale-return">
            <div class="table-responsive mb-4">
                <table id="sale-return-table" class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="not-exported-sale-return"></th>
                            <th><?php echo e(trans('file.Date')); ?></th>
                            <th><?php echo e(trans('file.reference')); ?></th>
                            <th><?php echo e(trans('file.Warehouse')); ?></th>
                            <th><?php echo e(trans('file.customer')); ?></th>
                            <th><?php echo e(trans('file.qty')); ?></th>
                            <th><?php echo e(trans('file.Unit Price')); ?></th>
                            <th><?php echo e(trans('file.Subtotal')); ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- purchase return table -->
        <div role="tabpanel" class="tab-pane fade" id="product-purchase-return">
            <div class="table-responsive mb-4">
                <table id="purchase-return-table" class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="not-exported-purchase-return"></th>
                            <th><?php echo e(trans('file.Date')); ?></th>
                            <th><?php echo e(trans('file.reference')); ?></th>
                            <th><?php echo e(trans('file.Warehouse')); ?></th>
                            <th><?php echo e(trans('file.Supplier')); ?></th>
                            <th><?php echo e(trans('file.qty')); ?></th>
                            <th><?php echo e(trans('file.Unit Price')); ?></th>
                            <th><?php echo e(trans('file.Subtotal')); ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");

    var starting_date = <?php echo json_encode($starting_date); ?>;
    var ending_date = <?php echo json_encode($ending_date); ?>;
    var warehouse_id = <?php echo json_encode($warehouse_id); ?>;
    var product_id = <?php echo json_encode($product_id); ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#warehouse_id").val(warehouse_id);

    $(".daterangepicker-field").daterangepicker({
      callback: function(startDate, endDate, period){
        var starting_date = startDate.format('YYYY-MM-DD');
        var ending_date = endDate.format('YYYY-MM-DD');
        var title = starting_date + ' To ' + ending_date;
        $(this).val(title);
        $('input[name="starting_date"]').val(starting_date);
        $('input[name="ending_date"]').val(ending_date);
      }
    });
    //retreiving sale table data
    $('#sale-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url:"sale-history-data",
            data:{
                product_id: product_id,
                starting_date: starting_date,
                ending_date: ending_date,
                warehouse_id: warehouse_id
            },
            dataType: "json",
            type:"post"
        },
        "columns": [
            {"data": "key"},
            {"data": "date"},
            {"data": "reference_no"},
            {"data": "warehouse"},
            {"data": "customer"},
            {"data": "qty"},
            {"data": "unit_price"},
            {"data": "sub_total"}
        ],
        'language': {

            'lengthMenu': '_MENU_ <?php echo e(trans("file.records per page")); ?>',
             "info":      '<small><?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)</small>',
            "search":  '<?php echo e(trans("file.Search")); ?>',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        order:[['1', 'desc']],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 3, 4, 5, 6, 7]
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
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
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        rowId: 'ObjectID',
        buttons: [
            {
                extend: 'pdf',
                text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                }
            },
            {
                extend: 'csv',
                text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                }
            },
            {
                extend: 'print',
                text: '<i title="print" class="fa fa-print"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: '<i title="column visibility" class="fa fa-eye"></i>',
                columns: ':gt(0)'
            },
        ]
    });
    //retreiving purchase table data
    $('#purchase-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url:"purchase-history-data",
            data:{
                product_id: product_id,
                starting_date: starting_date,
                ending_date: ending_date,
                warehouse_id: warehouse_id
            },
            dataType: "json",
            type:"post"
        },
        "columns": [
            {"data": "key"},
            {"data": "date"},
            {"data": "reference_no"},
            {"data": "warehouse"},
            {"data": "supplier"},
            {"data": "qty"},
            {"data": "unit_cost"},
            {"data": "sub_total"}
        ],
        'language': {

            'lengthMenu': '_MENU_ <?php echo e(trans("file.records per page")); ?>',
             "info":      '<small><?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)</small>',
            "search":  '<?php echo e(trans("file.Search")); ?>',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        order:[['1', 'desc']],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 3, 4, 5, 6, 7]
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
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
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        rowId: 'ObjectID',
        buttons: [
            {
                extend: 'pdf',
                text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-purchase)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_purchase(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_purchase(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-purchase)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_purchase(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_purchase(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                text: '<i title="print" class="fa fa-print"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-purchase)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_purchase(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum_purchase(dt, false);
                },
                footer:true
            },
            {
                extend: 'colvis',
                text: '<i title="column visibility" class="fa fa-eye"></i>',
                columns: ':gt(0)'
            },
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum_purchase(api, false);
        }
    });
    
    function datatable_sum_purchase(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(<?php echo e($general_setting->decimal); ?>));
        }
        else {
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(<?php echo e($general_setting->decimal); ?>));
        }
    }

    //retreiving sale return table data
    $('#sale-return-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url:"sale-return-history-data",
            data:{
                product_id: product_id,
                starting_date: starting_date,
                ending_date: ending_date,
                warehouse_id: warehouse_id
            },
            dataType: "json",
            type:"post"
        },
        "columns": [
            {"data": "key"},
            {"data": "date"},
            {"data": "reference_no"},
            {"data": "warehouse"},
            {"data": "customer"},
            {"data": "qty"},
            {"data": "unit_price"},
            {"data": "sub_total"}
        ],
        'language': {

            'lengthMenu': '_MENU_ <?php echo e(trans("file.records per page")); ?>',
             "info":      '<small><?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)</small>',
            "search":  '<?php echo e(trans("file.Search")); ?>',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        order:[['1', 'desc']],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 3, 4, 5, 6, 7]
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
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
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        rowId: 'ObjectID',
        buttons: [
            {
                extend: 'pdf',
                text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale-return)',
                    rows: ':visible'
                }
            },
            {
                extend: 'csv',
                text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale-return)',
                    rows: ':visible'
                }
            },
            {
                extend: 'print',
                text: '<i title="print" class="fa fa-print"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale-return)',
                    rows: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: '<i title="column visibility" class="fa fa-eye"></i>',
                columns: ':gt(0)'
            },
        ]
    });
    //retreiving purchase return table data
    $('#purchase-return-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url:"purchase-return-history-data",
            data:{
                product_id: product_id,
                starting_date: starting_date,
                ending_date: ending_date,
                warehouse_id: warehouse_id
            },
            dataType: "json",
            type:"post"
        },
        "columns": [
            {"data": "key"},
            {"data": "date"},
            {"data": "reference_no"},
            {"data": "warehouse"},
            {"data": "supplier"},
            {"data": "qty"},
            {"data": "unit_cost"},
            {"data": "sub_total"}
        ],
        'language': {

            'lengthMenu': '_MENU_ <?php echo e(trans("file.records per page")); ?>',
             "info":      '<small><?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)</small>',
            "search":  '<?php echo e(trans("file.Search")); ?>',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        order:[['1', 'desc']],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 3, 4, 5, 6, 7]
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
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
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        rowId: 'ObjectID',
        buttons: [
            {
                extend: 'pdf',
                text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-purchase-return)',
                    rows: ':visible'
                }
            },
            {
                extend: 'csv',
                text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-purchase-return)',
                    rows: ':visible'
                }
            },
            {
                extend: 'print',
                text: '<i title="print" class="fa fa-print"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-purchase-return)',
                    rows: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: '<i title="column visibility" class="fa fa-eye"></i>',
                columns: ':gt(0)'
            },
        ]
    });
</script>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\PFL\pfl\resources\views/backend/product/history.blade.php ENDPATH**/ ?>