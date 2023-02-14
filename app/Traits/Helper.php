<?php

namespace App\Traits;

use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

trait Helper
{
    public function getDataTables($query)
    {
        return DataTables::of($query)
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('jS M, Y');
                return $formatedDate;
            })
            ->editColumn('updated_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->format('jS M, Y');
                return $formatedDate;
            })
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-outline-primary btn-sm edit-btn" data-id="' . $row->id . '"> <i class="fa fa-edit"></i> </button>&nbsp<button data-id="' . $row->id . '" class="btn btn-outline-danger btn-sm delete-btn"> <i class="fa fa-trash"></i> </button>';
                return $btn;
            })->rawColumns(['action'])->toJson();
    }

    protected function getImageExtensionFromBase64String($base64ImageString)
    {
        $prefix = "data:image/";
        $suffix = ";base64,";

        $start = strpos($base64ImageString, $prefix) + strlen($prefix);
        $end = strpos($base64ImageString, $suffix);

        return substr($base64ImageString, $start, $end - $start);
    }
}
