@extends('backend.layout.main') @section('content')
<?php
$grand_t_cr=0;
$grand_t_ch=0;
$grand_tax_cr=0;
$grand_tax_ch=0;
$grand_tax=0;

?>
@foreach($sales as $sale)
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
                 
@endforeach
               


<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
            <div class="row mt-2">
			<div class="col-4">
                <div class="card"> 
                    <div class="card-body">

                        <h3>Sale Amount  <span class="float-right">{{$total_sale_amount}}</span></h3>
                       
                    </div>
                </div>
			</div>
            <div class="col-4">
                <div class="card"> 
                    <div class="card-body">

                    
                        <h3>Product Tax Amount  <span class="float-right">{{$total_product_tax}}</span></h3>
                        
                    </div>
                </div>
			</div>
            <div class="col-4">
                <div class="card"> 
                    <div class="card-body">

                        <h3>Order Tax Amount  <span class="float-right">{{$total_order_tax}}</span></h3>
                        
                    </div>
                </div>
			</div>
           
			</div>
                <h3 class="text-center">Purchase Tax Report</h3>
            </div>
            {!! Form::open(['route' => 'report.purchase-tax-report', 'method' => 'post']) !!}
            <div class="row mb-3">
                <div class="col-md-4 offset-md-1 mt-4">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong>{{trans('file.Choose Your Date')}}</strong> &nbsp;</label>
                        <div class="d-tc">
                            <div class="input-group">
                                <input type="text" class="daterangepicker-field form-control" value="{{$start_date}} To {{$end_date}}" required />
                                <input type="hidden" name="start_date" value="{{$start_date}}" />
                                <input type="hidden" name="end_date" value="{{$end_date}}" />
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-3 mt-4">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{trans('file.submit')}}</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

        <div class="row">
            <div class="col">
                <div class="card p-4">
                    {!! Form::open(['route' => 'report.tax-report', 'method' => 'post', 'id' => 'tax-report-form']) !!}
                            <input type="hidden" name="start_date" />
                            <input type="hidden" name="end_date" />
                            
                            <a class="btn btn-primary" id="tax-report-form-link" href="javascript:{}" onclick="document.getElementById('tax-report-form').submit();">Sales</a>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col">
                <div class="card p-4">
                    {!! Form::open(['route' => 'report.purchase-tax-report', 'method' => 'post', 'id' => 'purchase-tax-report-form']) !!}
                            <input type="hidden" name="start_date" />
                            <input type="hidden" name="end_date" />
                            
                            <a class="btn btn-primary" id="tax-report-form-link" href="javascript:{}" onclick="document.getElementById('purchase-tax-report-form').submit();">Purchases</a>
                    {!! Form::close() !!}
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
                @foreach($sales as $sale)
                <tr>
                  <td class="not-exported">{{$loop->iteration}}</td>
                  
                
                  <td>{{$sale->total_quantity}}</td>
                  <td>{{$sale->product?->category?->name}}</td>
                  <td>{{$sale->biller?->name}}</td>
                 
                  
                  <td>{{$sale->total_tax}} {{$sale->currency?->code}}</td>
                  <td>{{$sale->total_grand}} {{$sale->currency?->code}}</td>
                 
                  
                  </tr>
                @endforeach
               
            </tbody>
           
        </table>
            </div>
            
          </div>
       
    </div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #sale-report-menu").addClass("active");

    $('#warehouse_id').val($('input[name="warehouse_id_hidden"]').val());
    $('.selectpicker').selectpicker('refresh');

    $('#report-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
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

            $( dt_selector.column( 2 ).footer() ).html(dt_selector.cells( rows, 2, { page: 'current' } ).data().sum().toFixed({{$general_setting->decimal}}));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.cells( rows, 3, { page: 'current' } ).data().sum());
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed({{$general_setting->decimal}}));
        }
        else {
            $( dt_selector.column( 2 ).footer() ).html(dt_selector.column( 2, {page:'current'} ).data().sum().toFixed({{$general_setting->decimal}}));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.column( 3, {page:'current'} ).data().sum());
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed({{$general_setting->decimal}}));
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
@endpush
