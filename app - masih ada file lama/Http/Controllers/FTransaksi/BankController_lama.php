<?php

namespace App\Http\Controllers\FTransaksi;

use App\Http\Controllers\Controller;
// ganti 1

use App\Models\FTransaksi\Bank;
use App\Models\FTransaksi\BankDetail;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;

include_once base_path()."/vendor/simitgroup/phpjasperxml/version/1.1/PHPJasperXML.inc.php";
use PHPJasperXML;

// ganti 2
class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
// ganti 3
        return view('ftransaksi_bank.index');
    }

// ganti 4

    public function getBank(Request $request)
    {
// ganti 5

        if ($request->session()->has('periode')) 
		{
			$periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		} else
		{
			$periode = '';
		}

        //   $po = DB::table('po')->select('*')->where('PER', $periode)->where('GOL', 'Y')->orderBy('NO_PO', 'ASC')->get();
           $bank = DB::table('bank')->select('*')->where('TYPE', 'BBM')->where('PER', $periode)->orderBy('NO_BUKTI', 'ASC')->get();
		
// ganti 6
		
        return Datatables::of($bank)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    if (Auth::user()->hasRole("superadmin") || Auth::user()->hasRole("operational"))
                    {
                       $btnPrivilege =

                        $btnEdit = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="bank/edit/' . $row->NO_ID . '" ';
                    $btnDelete = ($row->POSTED == 1) ? ' onclick= "alert(\'Transaksi ' . $row->NO_BUKTI . ' sudah diposting!\')" href="#" ' : ' href="bank/delete/' . $row->NO_ID . '" ';

                    $btnPrivilege =
                        '
                                <a class="dropdown-item" ' . $btnEdit . '>
                                <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item btn btn-danger" href="jasper-bank-trans/' . $row->NO_ID . '">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Print
                                </a> 	
                                <hr></hr>
                                <a class="dropdown-item btn btn-danger" ' . $btnDelete . '>
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Delete
                                </a> 
                        ';
                } else {
                    $btnPrivilege = '';
                }

                    $actionBtn = 
                    '
                    <div class="dropdown show" style="text-align: center">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="bank/show/'. $row->NO_ID .'">
                            <i class="fas fa-eye"></i>
                                Lihat
                            </a>

                            '.$btnPrivilege.'
                        </div>
                    </div>
                    ';
                    
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
 // ganti 8
        return view('ftransaksi_bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        $this->validate($request,
// GANTI 9

        [
                'NO_BUKTI'       => 'required',
                'TGL'      => 'required',
                'BACNO'       => 'required'

            ]
        );

        // Insert Header

// ganti 10

//////     nomer otomatis

        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
		
        $bulan	= session()->get('periode')['bulan'];
		$tahun	= substr(session()->get('periode')['tahun'],-2);
		$query = DB::table('bank')->select('NO_BUKTI')->where('PER', $periode)->where('TYPE', 'BBM')->orderByDesc('NO_BUKTI')->limit(1)->get();
		
		if ($query != '[]')
        {
            $query = substr($query[0]->NO_BUKTI, -4);
            $query = str_pad($query + 1, 4, 0, STR_PAD_LEFT);
            $no_bukti = 'BBM'.$tahun.$bulan.'-'.$query;
        } else {
            $no_bukti = 'BBM'.$tahun.$bulan.'-0001';
        }



        // Insert Header

// ganti 10

        $bank = Bank::create(
            [
                'NO_BUKTI'         => $no_bukti,
                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'PER'              => $periode,
                'BACNO'            => ($request['BACNO']==null) ? "" : $request['BACNO'],			
                'BNAMA'            => ($request['BNAMA']==null) ? "" : $request['BNAMA'],
				'BG'		       =>($request['BG']==null) ? "" : $request['BG'],
				'JTEMPO'           => date('Y-m-d', strtotime($request['JTEMPO'])),
				'KET'              =>($request['KET']==null) ? "" : $request['KET'],
				'FLAG'             => 'B',
                'TYPE'		       => 'BBM',	
                'JUMLAH'           => (float) str_replace(',', '', $request['TJUMLAH']),
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );
		
		// Insert Detail
		$REC	= $request->input('REC');
		$ACNO	= $request->input('ACNO');
		$NACNO	= $request->input('NACNO');
		$URAIAN	= $request->input('URAIAN');
		$JUMLAH	= $request->input('JUMLAH');

		// Check jika value detail ada/tidak
		if ($REC) {
			foreach ($REC as $key => $value) {
				// Declare new data di Model
				$detail	= new BankDetail;
				
				// Insert ke Database
				$detail->NO_BUKTI = $no_bukti;			
				$detail->REC	= $REC[$key];
				$detail->PER	= $periode;
				$detail->FLAG	= 'B';
				$detail->TYPE	= 'BBM';
				$detail->ACNO	= $ACNO[$key];
				$detail->NACNO	= $NACNO[$key];
				$detail->URAIAN	= $URAIAN[$key];
				$detail->JUMLAH	= (float) str_replace(',', '', $JUMLAH[$key]);
				$detail->DEBET	= (float) str_replace(',', '', $JUMLAH[$key]);				
				$detail->save();
			}
		}

//  ganti 11
		$variablell = DB::select('call bankins(?)',array($no_bukti));
        return redirect('/bank')->with('statusInsert', 'Data baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 12
	 


    public function show(Bank $bank)
    {

        $no_bukti = $bank->NO_BUKTI;
        $bankDetail = DB::table('bankd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $bank,
			'detail'		=> $bankDetail
		];        
		
		return view('ftransaksi_bank.show', $data);
    }

		
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 15

    public function edit(Bank $bank)
    {

        $no_bukti = $bank->NO_BUKTI;
        $bankDetail = DB::table('bankd')->where('NO_BUKTI', $no_bukti)->get();
		$data = [
			'header'		=> $bank,
			'detail'		=> $bankDetail
		];        
		
		return view('ftransaksi_bank.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */

// ganti 18
    public function update(Request $request, Bank $bank )
    {
		
        $this->validate($request,
        [
		
// ganti 19
		
                'TGL'      => 'required',
                'BACNO'       => 'required'
            ]
        );
		
// ganti 20
		$variablell = DB::select('call bankdel(?)',array($bank['NO_BUKTI']));


        $periode = $request->session()->get('periode')['bulan']. '/' . $request->session()->get('periode')['tahun'];
	
	
        $bank->update(
            [

                'TGL'              => date('Y-m-d', strtotime($request['TGL'])),		
                'BACNO'            => ($request['BACNO']==null) ? "" : $request['BACNO'],
                'BNAMA'            => ($request['BNAMA']==null) ? "" : $request['BNAMA'],
				'BG'		       =>($request['BG']==null) ? "" : $request['BG'],
				'JTEMPO'           => date('Y-m-d', strtotime($request['JTEMPO'])),
				'KET'              =>($request['KET']==null) ? "" : $request['KET'],					
                'JUMLAH'           => (float) str_replace(',', '', $request['TJUMLAH']),	
				'USRNM'            => Auth::user()->username,
				'TG_SMP'           => Carbon::now()
            ]
        );


        // Update Detail
        $length = sizeof($request->input('REC'));
		$NO_ID  = $request->input('NO_ID');
				
        $REC    = $request->input('REC');
        $ACNO   = $request->input('ACNO');
        $NACNO  = $request->input('NACNO');
        $URAIAN = $request->input('URAIAN');
        $JUMLAH = $request->input('JUMLAH');
       
        // Delete yang NO_ID tidak ada di input
        $query = DB::table('bankd')->where('NO_BUKTI', $request->NO_BUKTI)->whereNotIn('NO_ID',  $NO_ID)->delete();

        // Update / Insert
        for ($i=0;$i<$length;$i++) {
            // Insert jika NO_ID baru
            if ($NO_ID[$i] == 'new') {
                $insert = BankDetail::create(
                    [
                        'NO_BUKTI'   => $request->NO_BUKTI,
                        'REC'        => $REC[$i],
				        'PER'        => $periode,
                        'FLAG'       => 'B',	
                        'TYPE'       => 'BBM',  							
                        'ACNO'       => ($ACNO[$i]==null) ? "" :  $ACNO[$i],
                        'NACNO'      => ($NACNO[$i]==null) ? "" : $NACNO[$i],	
                        'URAIAN'     => ($URAIAN[$i]==null) ? "" : $URAIAN[$i],
                        'JUMLAH'     => (float) str_replace(',', '', $JUMLAH[$i]),
                        'DEBET'      => (float) str_replace(',', '', $JUMLAH[$i])
                    ]
                );
            } else {
                // Update jika NO_ID sudah ada
                $update = BankDetail::updateOrCreate(
                    [
                        'NO_BUKTI'  => $request->NO_BUKTI,
                        'NO_ID'     => (int) str_replace(',', '', $NO_ID[$i])	
                    ],
    
                    [
                        'REC'        => $REC[$i],
                        'ACNO'       => ($ACNO[$i]==null) ? "" :  $ACNO[$i],
                        'NACNO'      => ($NACNO[$i]==null) ? "" : $NACNO[$i],	
                        'URAIAN'     => ($URAIAN[$i]==null) ? "" : $URAIAN[$i],
                        'JUMLAH'     => (float) str_replace(',', '', $JUMLAH[$i]),
                        'DEBET'      => (float) str_replace(',', '', $JUMLAH[$i])
                    ]
                );
            }
        }



//  ganti 21
		$variablell = DB::select('call bankins(?)',array($bank['NO_BUKTI']));
		
        return redirect('/bank')->with('status', 'Data baru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Rute  $rute
     * @return \Illuminate\Http\Response
     */
	 
// ganti 22
	 
    public function destroy(Bank $bank)
    {
		
		$variablell = DB::select('call bankdel(?)',array($bank['NO_BUKTI']));
		
		
// ganti 23
        $deleteBank = Bank::find($bank->NO_ID);

// ganti 24

        $deleteBank->delete();

// ganti 
        return redirect('/bank')->with('status', 'Data berhasil dihapus');
		
		
    }
    
    public function jasperBankTrans(Bank $bank)
    {
        $no_bukti = $bank->NO_BUKTI;
        
		$file 	= 'bankc';
		$PHPJasperXML = new PHPJasperXML();
		$PHPJasperXML->load_xml_file(base_path().('/app/reportc01/phpjasperxml/'.$file.'.jrxml'));
		
		$query = DB::SELECT("
			SELECT bank.NO_BUKTI,bank.TGL,bank.KET,bank.BNAMA,
            bankd.REC,bankd.ACNO,bankd.NACNO,bankd.URAIAN,if(bankd.DEBET>=0,bankd.DEBET,bankd.KREDIT) as JUMLAH 
			FROM bank, bankd 
			WHERE bank.NO_BUKTI=bankd.NO_BUKTI and bank.NO_BUKTI='$no_bukti' 
			ORDER BY bank.NO_BUKTI;
		");

		$data=[];
		foreach ($query as $key => $value)
		{
			array_push($data, array(
				'NO_BUKTI' => $query[$key]->NO_BUKTI,
				'TGL' => $query[$key]->TGL,
				'KET' => $query[$key]->KET,
				'BNAMA' => $query[$key]->BNAMA,
				'REC' => $query[$key]->REC,
				'ACNO' => $query[$key]->ACNO,
				'NACNO' => $query[$key]->NACNO,
				'URAIAN' => $query[$key]->URAIAN,
				'JUMLAH' => $query[$key]->JUMLAH,
			));
		}
		$PHPJasperXML->setData($data);
		ob_end_clean();
		$PHPJasperXML->outpage("I");
    }
}
