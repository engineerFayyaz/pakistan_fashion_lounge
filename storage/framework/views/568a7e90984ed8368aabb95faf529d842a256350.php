
<?php $__env->startSection('content'); ?>
<section>
	<div class="container-fluid">
		<div class="card">
			<div class="card-body">
			<form action="/report/daily_sale" method="get">
            <div class="row mb-3">
                <div class="col-md-4 offset-md-1 mt-4">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Your Date')); ?></strong> &nbsp;</label>
                        <input type="date" name="date" value="<?php echo e($date); ?>" class="form-control" id="">
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong>Choose Biller </strong> &nbsp;</label>
                        <div class="d-tc">
                           
                            <select id="biller" name="biller_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                <option value="">All Billers</option>
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
						<?php $__currentLoopData = $sale_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td class="not-exported"><?php echo e($loop->iteration); ?></td>
                  <td><?php echo e($sale->sale_date); ?></td>
             
                  <td><?php echo e($sale->total_quantity); ?></td>
				  <td><?php echo e($sale->biller?->name); ?></td>
                
                 
                  <td><?php echo e($sale->total_tax); ?><?php echo e($sale->currency?->code); ?></td>
                  <td><?php echo e($sale->total_grand); ?> <?php echo e($sale->currency?->code); ?></td>
                  
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						   
						   
					    </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\5TechSol\Projects\PFL\pakistan_fashion_lounge\pakistan_fashion_lounge\resources\views/backend/report/daily_sale_new.blade.php ENDPATH**/ ?>