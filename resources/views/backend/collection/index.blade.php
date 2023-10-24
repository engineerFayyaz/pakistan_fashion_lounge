@extends('backend.layout.main') 
@section('content')

<section>
    <!-- <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center">{{trans('file.Collections')}}</h3>
            </div>
        </div> 
    </div> -->
    <div class="container-fluid">
        <div class="table-responsive">
            <table id="collection-table" class="table return-list" style="width: 100%">
                <thead>
                    <tr>
                        <th>{{trans('id')}}</th>
                        <th>{{trans('Title')}}</th>
                        <th>{{trans('Collection Id')}}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>


@endsection

@push('scripts')
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
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
            "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
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
@endpush