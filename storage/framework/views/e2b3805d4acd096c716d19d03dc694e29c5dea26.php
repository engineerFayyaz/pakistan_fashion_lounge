
<?php $__env->startSection('content'); ?>
<section>
	<h3 class="text-center"><?php echo e(trans('file.Summary Report')); ?></h3>
	<?php echo Form::open(['route' => 'report.profitLoss', 'method' => 'post']); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3 mt-4">
                <div class="form-group">
                    <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Your Date')); ?></strong> &nbsp;</label>
                    <div class="d-tc">
                        <div class="input-group">
                            <input type="text" class="daterangepicker-field form-control" value="<?php echo e($start_date); ?> To <?php echo e($end_date); ?>" required />
                            <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>" />
                            <input type="hidden" name="end_date" value="<?php echo e($end_date); ?>" />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><?php echo e(trans('file.submit')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php echo e(Form::close()); ?>

	<div class="container-fluid">
		<div class="row mt-4">
			<div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3><i class="fa fa-heart"></i> <?php echo e(trans('file.Purchase')); ?></h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$purchase[0]->grand_total, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Purchase')); ?> <span class="float-right"><?php echo e($total_purchase); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Paid')); ?> <span class="float-right"><?php echo e(number_format((float)$purchase[0]->paid_amount, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Tax')); ?> <span class="float-right"><?php echo e(number_format((float)$purchase[0]->tax, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Discount')); ?> <span class="float-right"><?php echo e(number_format((float)$purchase[0]->discount, $general_setting->decimal, '.', '')); ?></span></p>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-md-3">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-shopping-cart"></i> <?php echo e(trans('file.Sale')); ?></h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$sale[0]->grand_total, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Sale')); ?> <span class="float-right"><?php echo e($total_sale); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Paid')); ?> <span class="float-right"><?php echo e(number_format((float)$sale[0]->paid_amount, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Tax')); ?> <span class="float-right"><?php echo e(number_format((float)$sale[0]->tax, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Discount')); ?> <span class="float-right"><?php echo e(number_format((float)$sale[0]->discount, $general_setting->decimal, '.', '')); ?></span></p>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-md-3">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-random "></i> <?php echo e(trans('file.Sale Return')); ?></h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$return[0]->grand_total, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Return')); ?> <span class="float-right"><?php echo e($total_return); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Tax')); ?> <span class="float-right"><?php echo e(number_format((float)$return[0]->tax, $general_setting->decimal, '.', '')); ?></span></p>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-md-3">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-random "></i> <?php echo e(trans('file.Purchase Return')); ?></h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$purchase_return[0]->grand_total, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Return')); ?> <span class="float-right"><?php echo e($total_purchase_return); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Tax')); ?> <span class="float-right"><?php echo e(number_format((float)$purchase_return[0]->tax, $general_setting->decimal, '.', '')); ?></span></p>
                        </div>
                    </div>
                </div>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-4">
                <div class="card"> 
                    <div class="card-body">

                        <h3><i class="fa fa-money"></i> <?php echo e(trans('file.profit')); ?> / <?php echo e(trans('file.Loss')); ?></h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2"><?php echo e(trans('file.Sale')); ?> <span class="float-right"><?php echo e(number_format((float)$sale[0]->grand_total, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Product Cost')); ?> <span class="float-right">- <?php echo e(number_format((float)$product_cost, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.profit')); ?> <span class="float-right"> <?php echo e(number_format((float)($sale[0]->grand_total - $product_cost), $general_setting->decimal, '.', '')); ?></span></p>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-md-4">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-money"></i> <?php echo e(trans('file.profit')); ?> / <?php echo e(trans('file.Loss')); ?></h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2"><?php echo e(trans('file.Sale')); ?> <span class="float-right"><?php echo e(number_format((float)$sale[0]->grand_total, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Product Cost')); ?> <span class="float-right">- <?php echo e(number_format((float)$product_cost, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Sale Return')); ?> <span class="float-right">- <?php echo e(number_format((float)$return[0]->grand_total, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Purchase Return')); ?> <span class="float-right"> <?php echo e(number_format((float)$purchase_return[0]->grand_total, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.profit')); ?> <span class="float-right"> <?php echo e(number_format((float)($sale[0]->grand_total - $product_cost - $return[0]->grand_total + $purchase_return[0]->grand_total), $general_setting->decimal, '.', '')); ?></span></p>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-md-4">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-money "></i> <?php echo e(trans('file.Net Profit')); ?> / <?php echo e(trans('file.Net Loss')); ?></h3>
                        <hr>
                        <h4 class="text-center"><?php echo e(number_format((float)(($sale[0]->grand_total-$sale[0]->tax) - ($product_cost-$product_tax) - ($return[0]->grand_total-$return[0]->tax) + ($purchase_return[0]->grand_total-$purchase_return[0]->tax) - $expense), $general_setting->decimal, '.', '')); ?></h4>
                        <p class="text-center">
                            (<?php echo e(trans('file.Sale')); ?> <?php echo e(number_format((float)($sale[0]->grand_total), $general_setting->decimal, '.', '')); ?> - <?php echo e(trans('file.Tax')); ?> <?php echo e(number_format((float)($sale[0]->tax), $general_setting->decimal, '.', '')); ?>) - (<?php echo e(trans('file.Product Cost')); ?> <?php echo e(number_format((float)($product_cost), $general_setting->decimal, '.', '')); ?> - <?php echo e(trans('file.Tax')); ?> <?php echo e(number_format((float)($product_tax), $general_setting->decimal, '.', '')); ?>) - (<?php echo e(trans('file.Return')); ?> <?php echo e(number_format((float)($return[0]->grand_total), $general_setting->decimal, '.', '')); ?> - <?php echo e(trans('file.Tax')); ?> <?php echo e(number_format((float)($return[0]->tax), $general_setting->decimal, '.', '')); ?>) + (<?php echo e(trans('file.Purchase Return')); ?> <?php echo e(number_format((float)($purchase_return[0]->grand_total), $general_setting->decimal, '.', '')); ?> - <?php echo e(trans('file.Tax')); ?> <?php echo e(number_format((float)($purchase_return[0]->tax), $general_setting->decimal, '.', '')); ?>) - (<?php echo e(trans('file.Expense')); ?> <?php echo e(number_format((float)($expense), $general_setting->decimal, '.', '')); ?>)
                        </p>
                    </div>
                </div>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-3">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-dollar"></i> <?php echo e(trans('file.Payment Recieved')); ?></h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$payment_recieved, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Recieved')); ?> <span class="float-right"><?php echo e($payment_recieved_number); ?></span></p>
                            <p class="mt-2">Cash <span class="float-right"><?php echo e(number_format((float)$cash_payment_sale, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2">Cheque <span class="float-right"><?php echo e(number_format((float)$cheque_payment_sale, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2">Credit Card <span class="float-right"><?php echo e(number_format((float)$credit_card_payment_sale, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2">Gift Card <span class="float-right"><?php echo e(number_format((float)$gift_card_payment_sale, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2">Paypal <span class="float-right"><?php echo e(number_format((float)$paypal_payment_sale, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2">Deposit <span class="float-right"><?php echo e(number_format((float)$deposit_payment_sale, $general_setting->decimal, '.', '')); ?></span></p>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-md-3">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-dollar"></i> <?php echo e(trans('file.Payment Sent')); ?></h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$payment_sent, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Recieved')); ?> <span class="float-right"><?php echo e($payment_sent_number); ?></span></p>
                            <p class="mt-2">Cash <span class="float-right"><?php echo e(number_format((float)$cash_payment_purchase, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2">Cheque <span class="float-right"><?php echo e(number_format((float)$cheque_payment_purchase, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2">Credit Card <span class="float-right"><?php echo e(number_format((float)$credit_card_payment_purchase, $general_setting->decimal, '.', '')); ?></span></p>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-md-3">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-dollar"></i> <?php echo e(trans('file.Expense')); ?></h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$expense, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Expense')); ?> <span class="float-right"><?php echo e($total_expense); ?></span></p>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-md-3">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-dollar"></i> <?php echo e(trans('file.Payroll')); ?></h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$payroll, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Payroll')); ?> <span class="float-right"><?php echo e($total_payroll); ?></span></p>
                        </div>
                    </div>
                </div>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-4 offset-md-4">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-dollar"></i> <?php echo e(trans('file.Cash in Hand')); ?></h3>
                        <hr>
                        <div class="mt-3">
                            <p class="mt-2"><?php echo e(trans('file.Recieved')); ?> <span class="float-right"> <?php echo e(number_format((float)($payment_recieved), $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Sent')); ?> <span class="float-right">- <?php echo e(number_format((float)($payment_sent), $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Sale Return')); ?> <span class="float-right">- <?php echo e(number_format((float)$return[0]->grand_total, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Purchase Return')); ?> <span class="float-right"> <?php echo e(number_format((float)$purchase_return[0]->grand_total, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Expense')); ?> <span class="float-right">- <?php echo e(number_format((float)$expense, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.Payroll')); ?> <span class="float-right">- <?php echo e(number_format((float)$payroll, $general_setting->decimal, '.', '')); ?></span></p>
                            <p class="mt-2"><?php echo e(trans('file.In Hand')); ?> <span class="float-right"><?php echo e(number_format((float)($payment_recieved - $payment_sent - $return[0]->grand_total + $purchase_return[0]->grand_total - $expense - $payroll), $general_setting->decimal, '.', '')); ?></span></p>
                        </div>
                    </div>
                </div>
			</div>
		</div>
		<div class="row mt-2">
			<?php $__currentLoopData = $warehouse_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="col-md-4">
                    <div class="card">
                        <div class="card-body">

                            <h3><i class="fa fa-money"></i> <?php echo e($name); ?></h3>
                            <h4 class="text-center mt-3"><?php echo e(number_format((float)($warehouse_sale[$key][0]->grand_total - $warehouse_purchase[$key][0]->grand_total - $warehouse_return[$key][0]->grand_total + $warehouse_purchase_return[$key][0]->grand_total), $general_setting->decimal, '.', '')); ?></h4>
                            <p class="text-center">
                                <?php echo e(trans('file.Sale')); ?> <?php echo e(number_format((float)($warehouse_sale[$key][0]->grand_total), $general_setting->decimal, '.', '')); ?> - <?php echo e(trans('file.Purchase')); ?> <?php echo e(number_format((float)($warehouse_purchase[$key][0]->grand_total), $general_setting->decimal, '.', '')); ?> - <?php echo e(trans('file.Sale Return')); ?> <?php echo e(number_format((float)($warehouse_return[$key][0]->grand_total), $general_setting->decimal, '.', '')); ?> + <?php echo e(trans('file.Purchase Return')); ?> <?php echo e(number_format((float)($warehouse_purchase_return[$key][0]->grand_total), $general_setting->decimal, '.', '')); ?>

                            </p>
                            <hr style="border-color: rgba(0, 0, 0, 0.2);">
                            <h4 class="text-center"><?php echo e(number_format((float)(($warehouse_sale[$key][0]->grand_total - $warehouse_sale[$key][0]->tax) - ($warehouse_purchase[$key][0]->grand_total - $warehouse_purchase[$key][0]->tax) - ($warehouse_return[$key][0]->grand_total - $warehouse_return[$key][0]->tax) + ($warehouse_purchase_return[$key][0]->grand_total - $warehouse_purchase_return[$key][0]->tax) ), $general_setting->decimal, '.', '')); ?></h4>
                            <p class="text-center">
                                <?php echo e(trans('file.Net Sale')); ?> <?php echo e(number_format((float)($warehouse_sale[$key][0]->grand_total - $warehouse_sale[$key][0]->tax), $general_setting->decimal, '.', '')); ?> -  <?php echo e(trans('file.Net Purchase')); ?> <?php echo e(number_format((float)($warehouse_purchase[$key][0]->grand_total - $warehouse_purchase[$key][0]->tax), $general_setting->decimal, '.', '')); ?> - <?php echo e(trans('file.Net Sale Return')); ?> <?php echo e(number_format((float)($warehouse_return[$key][0]->grand_total - $warehouse_return[$key][0]->tax), $general_setting->decimal, '.', '')); ?> + <?php echo e(trans('file.Net Purchase Return')); ?> <?php echo e(number_format((float)($warehouse_purchase_return[$key][0]->grand_total - $warehouse_purchase_return[$key][0]->tax), $general_setting->decimal, '.', '')); ?>

                            </p>
                            <hr style="border-color: rgba(0, 0, 0, 0.2);">
                            <h4 class="text-center"><?php echo e(number_format((float)$warehouse_expense[$key], $general_setting->decimal, '.', '')); ?></h4>
                            <p class="text-center"><?php echo e(trans('file.Expense')); ?></p>
                        </div>
                    </div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\5TechSol\Projects\PFL\pakistan_fashion_lounge\pakistan_fashion_lounge\resources\views/backend/report/profit_loss.blade.php ENDPATH**/ ?>