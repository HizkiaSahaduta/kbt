<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class MaterialAvailabilityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		
		if(!Session::has('mnuMaterialAvailability'))
        {
            return view('layouts.PageNotFound');
        }

        if (Session::has('MILLID')){

            $millname = DB::connection('sqlsrv3')
                            ->table('mill')
                            ->select('mill_id', 'mill_name')
                            ->where('mill_id', '=', Session::get('MILLID'))
                            ->where('active_flag', '=', 'Y')
                            ->where('mill_type', '=', 'M')
                            ->orderBy('mill_type', 'desc')
                            ->get();
        }
        else {

            $millname = DB::connection('sqlsrv3')
                            ->table('mill')
                            ->select('mill_id', 'mill_name')
                            ->where('active_flag', '=', 'Y')
                            ->where('mill_type', '=', 'M')
                            ->orderBy('mill_type', 'desc')
                            ->get();

        }

        $material = DB::connection('sqlsrv3')
                        ->table('raw_mat_kka')
                        ->select('jenis')
                        ->distinct()
                        ->orderBy('jenis', 'asc')
                        ->get();
                                
        $grade = DB::connection('sqlsrv3')
                    ->table('raw_mat_kka')
                    ->select('grade_id')
                    ->distinct()
                    ->orderBy('grade_id', 'desc')
                    ->get();
                                
        $color = DB::connection('sqlsrv3')
                    ->table('raw_mat_kka')
                    ->select('NamaWarna')
                    ->distinct()
                    ->orderBy('NamaWarna', 'asc')
                    ->get();

        $thickness = DB::connection('sqlsrv3')
                        ->table('raw_mat_kka')
                        ->selectRaw("format(thick, 'N2') as thick")
                        ->distinct()
                        ->orderBy('thick', 'asc')
                        ->get();
            
        $width = DB::connection('sqlsrv3')
                    ->table('raw_mat_kka')
                    ->selectRaw('CONVERT(DECIMAL(10,0),width) as width')
                    ->distinct()
                    ->orderBy('width', 'desc')
                    ->get();

        $quality = DB::connection('sqlsrv3')
                    ->table('raw_mat_kka')
                    ->select('quality_id')
                    ->distinct()
                    ->orderBy('quality_id', 'asc')
                    ->get();

        return view('layouts.MaterialAvailability', ['millname' => $millname, 'material' => $material, 'grade' => $grade, 'color' => $color, 'thickness' => $thickness, 'width' => $width, 'quality' => $quality]);

    }

    public function find_mats(Request $request)
    {

        $sqlWhere = "1=1";

        if($request->txtMillID != null)
        {
            $txtMillID = $request->txtMillID;
        }
        else
        {
            $txtMillID = '';
        }

        if($request->txtMaterial != null)
        {
            $txtMaterial = $request->txtMaterial;
        }
        else
        {
            $txtMaterial = '';
        }
        
        if($request->txtGrade != null)
        {
            $txtGrade = $request->txtGrade;
        }
        else
        {
            $txtGrade = '';
        }

        if($request->txtColor != null)
        {
            $txtColor = $request->txtColor;
        }
        else
        {
            $txtColor = '';
        }

        if($request->txtThickness != null)
        {
            $txtThickness = $request->txtThickness;
        }
        else
        {
            $txtThickness = '';
        }

        if($request->txtWidth != null)
        {
            $txtWidth = $request->txtWidth;
        }
        else
        {
            $txtWidth = '';
        }

        if($request->txtQuality != null)
        {
            $txtQuality = $request->txtQuality;
        }
        else
        {
            $txtQuality = '';
        }

        if($request->txtProduct != null)
        {
            $txtProduct = $request->txtProduct;
        }
        else
        {
            $txtProduct = '';
        }



        if (!empty($txtMillID))
        {
            $sqlWhere = " mill_id = ". "LTRIM(RTRIM('" . $txtMillID . "'))";
        }

        if (!empty($txtMaterial))
        {
            $sqlWhere = $sqlWhere . " and jenis = " . "'" . $txtMaterial . "'";
        }

        if (!empty($txtGrade))
        {
            $sqlWhere = $sqlWhere . " and grade_id = " . "'" . $txtGrade . "'";
        }

        if (!empty($txtColor))
        {
            $sqlWhere = $sqlWhere . " and NamaWarna = " . "'" . $txtColor . "'";
        }

        if (!empty($txtThickness))
        {
            $sqlWhere = $sqlWhere . " and thick  = " . "'" . $txtThickness . "'";
        }

        if (!empty($txtWidth))
        {
            $sqlWhere = $sqlWhere . " and width = " . "'" . $txtWidth . "'";
        }

        if (!empty($txtQuality))
        {
            $sqlWhere = $sqlWhere . " and quality_id = " . "'" . $txtQuality . "'";
        }

        if (!empty($txtProduct))
        {
            if($txtProduct == 'atap')
            {
                $sqlWhere = $sqlWhere . " and width >= 450 ";
            }
            else
            {
                $sqlWhere = $sqlWhere . " and width <= 450 ";
            }

        }

        $RawMatsResult = DB::connection('sqlsrv3')
                                ->table('raw_mat_kka')
                                ->selectRaw("mill_id, 
                                            trim(jenis) as jenis, 
                                            grade_id, 
                                            NamaWarna, 
                                            format(thick, 'N2', 'id-ID') as thick,
                                            format(width, 'N0', 'id-ID') as width, 
                                            format(Length_OnHand, 'N0', 'id-ID') as Length_OnHand,
                                            format(Wgt_OnHand, 'N0', 'id-ID') as Wgt_OnHand, 
                                            format(Length_Reserve, 'N0', 'id-ID') as Length_Reserve,
                                            format(Wgt_Kontrak, 'N0', 'id-ID') as Wgt_Kontrak,
                                            format(Length_unrelease, 'N0', 'id-ID') as Length_unrelease,
                                            format(Wgt_unrelease, 'N0', 'id-ID') as Wgt_unrelease,
                                            format(Length_Avail, 'N0', 'id-ID') as Length_Avail,
                                            format(Wgt_Avail, 'N0', 'id-ID') as Wgt_Avail, 
                                            format(Length_PO, 'N0', 'id-ID') as Length_PO,
                                            format(Wgt_po, 'N0', 'id-ID') as Wgt_po,
                                            trim(quality_id) as quality_id")
                                ->whereRaw($sqlWhere)
                                ->get();

        return \DataTables::of($RawMatsResult)
                            ->make(true);  


    }



}
