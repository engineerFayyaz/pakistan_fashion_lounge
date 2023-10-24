 <?php $__env->startSection('content'); ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div>
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.Add Customer')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['route' => 'customer.store', 'method' => 'post', 'files' => true]); ?>

                        <div class="row">
                            <div class="col-md-4 mt-4">
                                <div class="form-group">
                                    <input type="checkbox" name="both" value="1" />&nbsp;
                                    <label><?php echo e(trans('file.Both Customer and Supplier')); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Customer Group')); ?> *</strong> </label>
                                    <select required class="form-control selectpicker" id="customer-group-id" name="customer_group_id">
                                        <?php $__currentLoopData = $lims_customer_group_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($customer_group->id); ?>"><?php echo e($customer_group->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.name')); ?> *</strong> </label>
                                    <input type="text" id="name" name="customer_name" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Company Name')); ?> <span class="asterisk">*</span></label>
                                    <input type="text" name="company_name" class="form-control">
                                    <?php if($errors->has('company_name')): ?>
                                   <span>
                                       <strong><?php echo e($errors->first('company_name')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Email')); ?> <span class="asterisk">*</span></label>
                                    <input type="email" name="email" placeholder="example@example.com" class="form-control">
                                    <?php if($errors->has('email')): ?>
                                   <span>
                                       <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Phone Number')); ?> *</label>
                                    <input type="text" name="phone_number" required class="form-control">
                                    <?php if($errors->has('phone_number')): ?>
                                   <span>
                                       <strong><?php echo e($errors->first('phone_number')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Tax Number')); ?></label>
                                    <input type="text" name="tax_no" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Address')); ?> *</label>
                                    <input type="text" name="address" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.City')); ?> *</label>
                                    <input type="text" name="city" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.State')); ?></label>
                                    <input type="text" name="state" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Postal Code')); ?></label>
                                    <input type="text" name="postal_code" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Country')); ?></label>
                                    <input type="text" name="country" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Credit Limit</label>
                                    <input type="text" name="credit_limit" class="form-control">
                                </div>
                            </div>
                            <?php $__currentLoopData = $custom_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!$field->is_admin): ?>
                                    <div class="<?php echo e('col-md-'.$field->grid_value); ?>">
                                        <div class="form-group">
                                            <label><?php echo e($field->name); ?></label>
                                            <?php if($field->type == 'text'): ?>
                                                <input type="text" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                            <?php elseif($field->type == 'number'): ?>
                                                <input type="number" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                            <?php elseif($field->type == 'textarea'): ?>
                                                <textarea rows="5" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>></textarea>
                                            <?php elseif($field->type == 'checkbox'): ?>
                                                <br>
                                                <?php $option_values = explode(",", $field->option_value); ?>
                                                <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label>
                                                        <input type="checkbox" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>[]" value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('checked'); ?><?php endif; ?> <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>> <?php echo e($value); ?>

                                                    </label>
                                                    &nbsp;
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php elseif($field->type == 'radio_button'): ?>
                                                <br>
                                                <?php $option_values = explode(",", $field->option_value); ?>
                                                <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('checked'); ?><?php endif; ?> <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>> <?php echo e($value); ?>

                                                    </label>
                                                    &nbsp;
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php elseif($field->type == 'select'): ?>
                                                <?php $option_values = explode(",", $field->option_value); ?>
                                                <select class="form-control" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                                    <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('selected'); ?><?php endif; ?>><?php echo e($value); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            <?php elseif($field->type == 'multi_select'): ?>
                                                <?php $option_values = explode(",", $field->option_value); ?>
                                                <select class="form-control" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>[]" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?> multiple>
                                                    <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('selected'); ?><?php endif; ?>><?php echo e($value); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            <?php elseif($field->type == 'date_picker'): ?>
                                                <input type="text" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control date" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php elseif(\Auth::user()->role_id == 1): ?>
                                    <div class="<?php echo e('col-md-'.$field->grid_value); ?>">
                                        <div class="form-group">
                                            <label><?php echo e($field->name); ?></label>
                                            <?php if($field->type == 'text'): ?>
                                                <input type="text" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                            <?php elseif($field->type == 'number'): ?>
                                                <input type="number" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                            <?php elseif($field->type == 'textarea'): ?>
                                                <textarea rows="5" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>></textarea>
                                            <?php elseif($field->type == 'checkbox'): ?>
                                                <br>
                                                <?php $option_values = explode(",", $field->option_value); ?>
                                                <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label>
                                                        <input type="checkbox" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>[]" value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('checked'); ?><?php endif; ?> <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>> <?php echo e($value); ?>

                                                    </label>
                                                    &nbsp;
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php elseif($field->type == 'radio_button'): ?>
                                                <br>
                                                <?php $option_values = explode(",", $field->option_value); ?>
                                                <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('checked'); ?><?php endif; ?> <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>> <?php echo e($value); ?>

                                                    </label>
                                                    &nbsp;
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php elseif($field->type == 'select'): ?>
                                                <?php $option_values = explode(",", $field->option_value); ?>
                                                <select class="form-control" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                                    <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('selected'); ?><?php endif; ?>><?php echo e($value); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            <?php elseif($field->type == 'multi_select'): ?>
                                                <?php $option_values = explode(",", $field->option_value); ?>
                                                <select class="form-control" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>[]" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?> multiple>
                                                    <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('selected'); ?><?php endif; ?>><?php echo e($value); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            <?php elseif($field->type == 'date_picker'): ?>
                                                <input type="text" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control date" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mt-4">
                                <div class="form-group">
                                    <input type="checkbox" name="user" value="1" />&nbsp;
                                    <label><?php echo e(trans('file.Add User')); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4 user-input">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.UserName')); ?> *</label>
                                    <input type="text" name="name" class="form-control">
                                    <?php if($errors->has('name')): ?>
                                   <span>
                                       <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4 user-input">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Password')); ?> *</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="pos" value="0">
                            <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    $("ul#people").siblings('a').attr('aria-expanded','true');
    $("ul#people").addClass("show");
    $("ul#people #customer-create-menu").addClass("active");

    $('.asterisk').hide();
    $(".user-input").hide();

    $('input[name="both"]').on('change', function() {
        if ($(this).is(':checked')) {
            $('.asterisk').show();
            $('input[name="company_name"]').prop('required',true);
            $('input[name="email"]').prop('required',true);
        }
        else{
            $('.asterisk').hide();
            $('input[name="company_name"]').prop('required',false);
            $('input[name="email"]').prop('required',false);
        }
    });

    $('input[name="user"]').on('change', function() {
        if ($(this).is(':checked')) {
            $('.user-input').show(300);
            $('input[name="name"]').prop('required',true);
            $('input[name="password"]').prop('required',true);
        }
        else{
            $('.user-input').hide(300);
            $('input[name="name"]').prop('required',false);
            $('input[name="password"]').prop('required',false);
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\5TechSol\Projects\PFL\pakistan_fashion_lounge\pakistan_fashion_lounge\resources\views/backend/customer/create.blade.php ENDPATH**/ ?>