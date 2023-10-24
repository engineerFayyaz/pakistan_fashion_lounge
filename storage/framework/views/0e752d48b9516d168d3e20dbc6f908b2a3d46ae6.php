 <?php $__env->startSection('content'); ?>
<?php
$grand_t_cr=0;
$grand_t_ch=0;
$grand_tax_cr=0;
$grand_tax_ch=0;
$grand_tax=0;

?>
<?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
if($sale->payment?->paying_method && $sale->payment?->paying_method=='Cash'){
    $grand_t_ch+=$sale->total_grand;
    $grand_tax_ch+=$sale->total_tax;
}
if($sale->payment?->paying_method && $sale->payment?->paying_method=='Credit Card'){
    $grand_t_cr+=$sale->total_grand;

    $grand_tax_cr+=$sale->total_tax;
} 

$grand_tax+=$sale->total_tax;

?>             
                 
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               


<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
            <div class="row mt-2">
			<div class="col-4">
                <div class="card"> 
                    <div class="card-body">

                        <h3>Sale Amount  <span class="float-right"><?php echo e($total_sale_amount); ?></span></h3>
                       
                    </div>
                </div>
			</div>
            <div class="col-4">
                <div class="card"> 
                    <div class="card-body">

                    
                        <h3>Product Tax Amount  <span class="float-right"><?php echo e($total_product_tax); ?></span></h3>
                        
                    </div>
                </div>
			</div>
            <div class="col-4">
                <div class="card"> 
                    <div class="card-body">

                        <h3>Order Tax Amount  <span class="float-right"><?php echo e($total_order_tax); ?></span></h3>
                        
                    </div>
                </div>
			</div>
           
			</div>
                <h3 class="text-center">Sales Tax Report</h3>
            </div>
            <?php echo Form::open(['route' => 'report.tax-report', 'method' => 'post']); ?>

            <div class="row mb-3">
                <div class="col-md-4 offset-md-1 mt-4">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Your Date')); ?></strong> &nbsp;</label>
                        <div class="d-tc">
                            <div class="input-group">
                                <input type="text" class="daterangepicker-field form-control" value="<?php echo e($start_date); ?> To <?php echo e($end_date); ?>" required />
                                <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>" />
                                <input type="hidden" name="end_date" value="<?php echo e($end_date); ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong>Choose Biller </strong> &nbsp;</label>
                        <div class="d-tc">
                           
                            <select id="biller" name="biller_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                <option value="">All</option>
                                <?php $__currentLoopData = $lims_biller_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $biller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($biller->id); ?>" <?php if($biller->id==$biller_id){ echo 'selected';}?>><?php echo e($biller->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mt-4">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit"><?php echo e(trans('file.submit')); ?></button>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>

        <div class="row">
            <div class="col">
                <div class="card p-4">
                    <?php echo Form::open(['route' => 'report.tax-report', 'method' => 'post', 'id' => 'tax-report-form']); ?>

                            <input type="hidden" name="start_date" />
                            <input type="hidden" name="end_date" />
                            <input type="hidden" name="biller_id" value="" />
                            <a class="btn btn-primary" id="tax-report-form-link" href="javascript:{}" onclick="document.getElementById('tax-report-form').submit();">Sales</a>
                    <?php echo Form::close(); ?>

                </div>
            </div>
            <div class="col">
                <div class="card p-4">
                    <?php echo Form::open(['route' => 'report.purchase-tax-report', 'method' => 'post', 'id' => 'purchase-tax-report-form']); ?>

                            <input type="hidden" name="start_date" />
                            <input type="hidden" name="end_date" />
                            <input type="hidden" name="biller_id" value="" />
                            <a class="btn btn-primary" id="tax-report-form-link" href="javascript:{}" onclick="document.getElementById('purchase-tax-report-form').submit();">Purchases</a>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>

    </div>

    
    

    <div class="table-responsive">
          <div class="row">
            <div class="col-12">
            <table id="report-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                  <th>Sales</th>
                  <th>Category</th>
                  <th>Biller</th>
                  <th>Order Tax</th>
                  <th>Grand total</th>
                  
                  <!-- <th>Paid By</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td class="not-exported"><?php echo e($loop->iteration); ?></td>
                  
                
                  <td><?php echo e($sale->total_quantity); ?></td>
                  <td><?php echo e($sale->product?->category?->name); ?></td>
                  <td><?php echo e($sale->biller?->name); ?></td>
                 
                  
                  <td><?php echo e($sale->total_tax); ?> <?php echo e($sale->currency?->code); ?></td>
                  <td><?php echo e($sale->total_grand); ?> <?php echo e($sale->currency?->code); ?></td>
                 
                  
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
            </tbody>
           
        </table>
            </div>
            
          </div>
       
    </div>
</section>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #sale-report-menu").addClass("active");

    $('#warehouse_id').val($('input[name="warehouse_id_hidden"]').val());
    $('.selectpicker').selectpicker('refresh');

    $('#report-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ <?php echo e(trans("file.records per page")); ?>',
             "info":      '<small><?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)</small>',
            "search":  '<?php echo e(trans("file.Search")); ?>',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': 0
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
        buttons: [
            {
                extend: 'pdf',
                text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'excel',
                text: '<i title="export to excel" class="fa fa-file-text-o"></i>',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                text: '<i title="print" class="fa fa-print"></i>',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'colvis',
                text: '<i title="column visibility" class="fa fa-eye"></i>',
                columns: ':gt(0)'
            }
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 2 ).footer() ).html(dt_selector.cells( rows, 2, { page: 'current' } ).data().sum().toFixed(<?php echo e($general_setting->decimal); ?>));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.cells( rows, 3, { page: 'current' } ).data().sum());
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(<?php echo e($general_setting->decimal); ?>));
        }
        else {
            $( dt_selector.column( 2 ).footer() ).html(dt_selector.column( 2, {page:'current'} ).data().sum().toFixed(<?php echo e($general_setting->decimal); ?>));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.column( 3, {page:'current'} ).data().sum());
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed(<?php echo e($general_setting->decimal); ?>));
        }
    }

$(".daterangepicker-field").daterangepicker({
  callback: function(startDate, endDate, period){
    var start_date = startDate.format('YYYY-MM-DD');
    var end_date = endDate.format('YYYY-MM-DD');
    var title = start_date + ' To ' + end_date;
    $(this).val(title);
    $('input[name="start_date"]').val(start_date);
    $('input[name="end_date"]').val(end_date);
  }
});

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\BHAI LOG\More Projects\reports making\pakistan_fashion_lounge\resources\views/backend/report/tax_report.blade.php ENDPATH**/ ?>