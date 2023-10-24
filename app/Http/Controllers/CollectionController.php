<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collection;
use DataTables;

class CollectionController extends Controller
{
    public function index(){
        return view('backend.collection.index');
    }

    public function collectionData(Request $request)
    {
        // Get the request parameters
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
        $orderColumn = $request->input('columns')[$request->input('order.0.column')]['data'];
        $orderDir = $request->input('order.0.dir');

        // Query your database to get the data (customize as needed)
        $query = Collection::select('id', 'title', 'collection_id')
            ->where('title', 'like', '%' . $searchValue . '%')
            ->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length);

        $recordsTotal = Collection::count(); // Get total records
        $recordsFiltered = $query->count(); // Get filtered records

        $data = $query->get();

        // Prepare the JSON response for DataTables
        $response = [
            "draw" => $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ];

        return response()->json($response);
    }

    // public function collectionData(Request $request){
    //     $collections = Collection::all();
    //     $totalData = count($collections);
    //     if ($request->input('length') != -1)
    //         $limit = $request->input('length');
    //     else
    //         $limit = $totalData;
        
    //     $start = $request->input('start');
    //     $json_data = array(
    //         "draw"            => intval($request->input('draw')),
    //         "recordsTotal"    => intval($totalData),
    //         "data"            => $collections
    //     );
    //     echo json_encode($json_data);
    // }
}
