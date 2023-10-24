@extends('backend.layout.main')
@section('content')
<section>
	<h3 class="text-center">Profit And Loss</h3>
	{!! Form::open(['route' => 'report.profitLossNew', 'method' => 'post']) !!}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3 mt-4">
                <div class="form-group">
                    <label class="d-tc mt-2"><strong>{{trans('file.Choose Your Date')}}</strong> &nbsp;</label>
                    <div class="d-tc">
                        <div class="input-group">
                            <input type="text" class="daterangepicker-field form-control" value="{{$start_date}} To {{$end_date}}" required />
                            <input type="hidden" name="start_date" value="{{$start_date}}" />
                            <input type="hidden" name="end_date" value="{{$end_date}}" />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">{{trans('file.submit')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	{{Form::close()}}
	<div class="container-fluid">
		
		<div class="row mt-2">
			<div class="col-6">
                <div class="card"> 
                    <div class="card-body">

                        <h3><i class="fa fa-money"></i>Purchases</h3>
                        <hr>
                        <div class="mt-3">
                          
                            <p class="mt-2">{{trans('file.Product Cost')}} <span class="float-right">- {{number_format((float)$product_cost, $general_setting->decimal, '.', '')}}</span></p>
                           
                        </div>
                    </div>
                </div>
			</div>
            <div class="col-6">
                <div class="card"> 
                    <div class="card-body">

                        <h3><i class="fa fa-money"></i>Sales</h3>
                        <hr>
                        <div class="mt-3">
                          
                        <p class="mt-2">{{trans('file.Sale')}} <span class="float-right">{{number_format((float)$sale[0]->grand_total, $general_setting->decimal, '.', '')}}</span></p>
                           
                        </div>
                    </div>
                </div>
			</div>
            
			<div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-money"></i> {{trans('file.profit')}} / {{trans('file.Loss')}}</h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2">{{trans('file.Sale')}} <span class="float-right">{{number_format((float)$sale[0]->grand_total, $general_setting->decimal, '.', '')}}</span></p>
                            <p class="mt-2">{{trans('file.Product Cost')}} <span class="float-right">- {{number_format((float)$product_cost, $general_setting->decimal, '.', '')}}</span></p>
                            <p class="mt-2">{{trans('file.Sale Return')}} <span class="float-right">- {{number_format((float)$return[0]->grand_total, $general_setting->decimal, '.', '')}}</span></p>
                            <p class="mt-2">{{trans('file.Purchase Return')}} <span class="float-right"> {{number_format((float)$purchase_return[0]->grand_total, $general_setting->decimal, '.', '')}}</span></p>
                            <p class="mt-2">{{trans('file.profit')}} <span class="float-right"> {{number_format((float)($sale[0]->grand_total - $product_cost - $return[0]->grand_total + $purchase_return[0]->grand_total), $general_setting->decimal, '.', '')}}</span></p>
                        </div>
                    </div>
                </div>
			</div>
			
		</div>
		
		
		
	</div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">

	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #profit-loss-report-menu").addClass("active");

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
