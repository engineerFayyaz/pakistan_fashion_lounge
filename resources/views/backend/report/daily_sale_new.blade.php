@extends('backend.layout.main')
@section('content')
<section>
	<div class="container-fluid">
		<div class="card">
			<div class="card-body">
			<form action="/report/daily_sale" method="get">
            <div class="row mb-3">
                <div class="col-md-4 offset-md-1 mt-4">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong>{{trans('file.Choose Your Date')}}</strong> &nbsp;</label>
                        <input type="date" name="date" value="{{$date}}" class="form-control" id="">
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong>Choose Biller </strong> &nbsp;</label>
                        <div class="d-tc">
                           
                            <select id="biller" name="biller_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                <option value="">All Billers</option>
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
            </form>
				<div class="table-responsive mt-4">
					<table class="table table-bordered" style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
					<thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>Date</th>
                    <th>No.Of Sales</th>
                    <th>Biller</th>
                    <th>Order Tax</th>
                    <th>Grand Total</th>
                </tr>
            </thead>
					    <tbody>
						@foreach($sale_data as $sale)
                <tr>
                  <td class="not-exported">{{$loop->iteration}}</td>
                  <td>{{$sale->sale_date}}</td>
             
                  <td>{{$sale->total_quantity}}</td>
				  <td>{{$sale->biller?->name}}</td>
                
                 
                  <td>{{$sale->total_tax}}{{$sale->currency?->code}}</td>
                  <td>{{$sale->total_grand}} {{$sale->currency?->code}}</td>
                  
                  </tr>
                @endforeach
						   
						   
					    </tbody>
					</table>
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
    $("ul#report #daily-sale-report-menu").addClass("active");

	$('#warehouse_id').val($('input[name="warehouse_id_hidden"]').val());
	$('.selectpicker').selectpicker('refresh');

	$('#warehouse_id').on("change", function(){
		$('#report-form').submit();
	});
</script>
@endpush
