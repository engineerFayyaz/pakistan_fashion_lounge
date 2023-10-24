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

                        <h3>{{$grand_t_cr}}</h3>
                        <hr>
                        <h3>Tax  <span class="float-right">{{$grand_tax_cr}}</span></h3>
                        <hr>
                        <div class="mt-3">
                          
                            <p class="mt-2">Total By Credit Crad<span class="float-right"></span></p>
                           
                        </div>
                    </div>
                </div>
			</div>
            <div class="col-4">
                <div class="card"> 
                    <div class="card-body">

                    <h3>{{$grand_t_ch}} </h3>
                    <hr>
                        <h3>Tax  <span class="float-right">{{$grand_tax_ch}}</span></h3>
                        <hr>
                        <div class="mt-3">
                          
                        <p class="mt-2">Total By Cash <span class="float-right"></span></p>
                           
                        </div>
                    </div>
                </div>
			</div>
            <div class="col-4">
                <div class="card"> 
                    <div class="card-body">

                   
                        <h3>Tax  <span class="float-right">{{$grand_tax}}</span></h3>
                        <hr>
                        <div class="mt-3">
                          
                        <p class="mt-2">Total Tax <span class="float-right"></span></p>
                           
                        </div>
                    </div>
                </div>
			</div>
			</div>
                <h3 class="text-center">Sales By Category</h3>
            </div>
            {!! Form::open(['route' => 'report.sale-cat', 'method' => 'post']) !!}
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
                <div class="col-md-4 mt-4">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong>Choose Biller </strong> &nbsp;</label>
                        <div class="d-tc">
                           
                            <select id="biller" name="biller_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                <option value="">All</option>
                                @foreach($lims_biller_all as $biller)
                                <option value="{{$biller->id}}" <?php if($biller->id==$biller_id){ echo 'selected';}?>>{{$biller->name}}</option>
                                @endforeach
                            </select>
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
    </div>
    <div class="table-responsive">
          <div class="row">
            <div class="col-8">
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
            <div class="col-4">
            {!! Form::open(['route' => 'report.sale-cat', 'method' => 'post']) !!}
            <div class="row mb-3 card mt-4 p-3">
            <label class=" mt-2"><strong>Choose Category </strong> &nbsp;</label>
                <div class="col-12">
                  
                        
                       
                           
                           
                                @foreach($categories as $cat)
                               
                                <div class="row">
                                    <div class="col-1"> <input id="ch{{$cat->id}}" type="checkbox" class="" name="cat_id[{{$cat->id}}]" <?php if(in_array($cat->id, $cats)){ echo 'checked';}?>></div>
                                    <div class="col-5"><label for="ch{{$cat->id}}">{{$cat->name}}</label></div>
                               
                                
                                </div>
                                @endforeach
                            
                      
                  
                </div>
                <input type="hidden" name="start_date" value="{{$start_date}}" />
                <input type="hidden" name="end_date" value="{{$end_date}}" />
                <input type="hidden" name="biller_id" value="{{$biller_id}}" />
                
                <div class="col-md-3 mt-4">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{trans('file.submit')}}</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
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
