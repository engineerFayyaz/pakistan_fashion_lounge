 
<?php $__env->startSection('content'); ?>

<section>
    <!-- <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center"><?php echo e(trans('file.Collections')); ?></h3>
            </div>
        </div> 
    </div> -->
    <div class="container-fluid">
        <div class="table-responsive">
            <table id="collection-table" class="table return-list" style="width: 100%">
                <thead>
                    <tr>
                        <th><?php echo e(trans('id')); ?></th>
                        <th><?php echo e(trans('Title')); ?></th>
                        <th><?php echo e(trans('Collection Id')); ?></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#collection-table').DataTable( {
        // "processing": true,
        "serverSide": true,
        "ajax":{
            url:"get-collection",
            type:"post"
        },
        "columns": [
            {"data": "id"},
            {"data": "title"},
            {"data": "collection_id"},
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
        order:[['1', 'asc']],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 2]
            }
            // {
            //     'render': function(data, type, row, meta){
            //         if(type === 'display'){
            //             data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
            //         }

            //        return data;
            //     },
            //     'checkboxes': {
            //        'selectRow': true,
            //        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
            //     },
            //     'targets': [0]
            // }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        rowId: 'ObjectID',
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Development-Software\IDE\wamp64\www\pakistan_fashion_lounge\resources\views/backend/collection/index.blade.php ENDPATH**/ ?>