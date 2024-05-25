<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Auth;
use Date;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class ReportController extends Controller
{
    /**
     * Display a listing of the Document.
     *
     * @return Response
     */
    public function index()
    {
        $input = Request::validate(['start_at' => 'nullable|date', 'end_at' => 'nullable|date', 'sh_type' => 'nullable|array']);
        $cols =   implode(',', $input['sh_type'] ?? ['branch_name']);
        $input['sh_type'] = $input['sh_type'] ?? ['branch_name'];
        $input['start_at'] = $input['start_at'] ?? '';

        $order = $input['sh_type'] ?? ['branch_name'];
        $order =   $input['sh_type'] ?? ['branch_name'];
        foreach ($order as $key => $value) {
            if (str_ends_with($value, 'name')) {
                $order[$key] = "substr($value, instr($value, '.') + 1)";
            }
        }

        $order =   implode(',', $order);
        $where = " WHERE 1=1 ";
        if ($input['start_at'])
            $where .= "  AND   DATE_FORMAT(r.created_at,'%Y-%m-%d') <= '" . $input['start_at'] . "' ";


        $status_infos = DB::select("select $cols,  sum(cnt) niit
            from (
                select 
                b.name branch_name,p.name product_name,pc.name categoy_name,pr.name provider_name,sum(r.pcount)   cnt
                 from branche_have_products r
                 inner join branches b on b.id = r.branch_id
                 inner join products p on p.id= r.product_id
                 inner join product_categories pc on pc.id= p.product_category_id
                 inner join providers pr on pr.id= p.provider_id
                 $where
                 group by  b.name,p.name,pc.name,pr.name
                ) ss
                group by $cols
                ORDER BY $order");


        return Inertia::render('Admin/report/Index', [
            'filters' =>  $input,
            'datas' => $status_infos,
            'host' => config('app.url'),
        ]);
    }
}
