 <?php $__env->startSection('content'); ?>
<section class="forms">
    <div class="container-fluid">
    	<div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center"><?php echo e(trans('file.Sale Report Chart')); ?></h3>
            </div>
            <?php echo Form::open(['route' => 'report.saleChart', 'method' => 'post']); ?>

            <div class="row ml-2">
                <div class="col-md-3">
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Choose Your Date')); ?></strong></label>
                        <input type="text" class="daterangepicker-field form-control" value="<?php echo e($start_date); ?> To <?php echo e($end_date); ?>" required />
                        <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>" />
                        <input type="hidden" name="end_date" value="<?php echo e($end_date); ?>" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Warehouse')); ?></strong> &nbsp;</label>
                        <input type="hidden" name="warehouse_id_hidden" value="<?php echo e($warehouse_id); ?>" />
                        <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                            <option value="0"><?php echo e(trans('file.All Warehouse')); ?></option>
                            <?php $__currentLoopData = $lims_warehouse_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($warehouse->id); ?>"><?php echo e($warehouse->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Time Period')); ?></strong></label>
                        <select class="form-control" name="time_period">
                            <?php if($time_period == 'weekly'): ?>
                                <option value="weekly" selected>Weekly</option>
                                <option value="monthly">Monthly</option>
                            <?php else: ?>
                                <option value="weekly">Weekly</option>
                                <option value="monthly" selected>Monthly</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.product_list')); ?></strong></label>
                        <input type="text" name="product_list" class="form-control" placeholder="Type product code seperated by comma">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit"><?php echo e(trans('file.submit')); ?></button>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
        <?php 
            $color = '#733686';
            $color_rgba = 'rgba(115, 54, 134, 0.8)';
        ?>
        <div class="col-md-12">
            <div class="card-body">
                <canvas id="sale-report-chart" data-color="<?php echo e($color); ?>" data-color_rgba="<?php echo e($color_rgba); ?>" data-soldqty="<?php echo e(json_encode($sold_qty)); ?>" data-datepoints="<?php echo e(json_encode($date_points)); ?>" data-label1="<?php echo e(trans('file.Sold Qty')); ?>"></canvas>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #sale-report-chart-menu").addClass("active");

	$('#warehouse_id').val($('input[name="warehouse_id_hidden"]').val());
	$('.selectpicker').selectpicker('refresh');

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

<?php echo $__env->make('backend.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\5TechSol\Projects\PFL\pakistan_fashion_lounge\pakistan_fashion_lounge\resources\views/backend/report/sale_report_chart.blade.php ENDPATH**/ ?>