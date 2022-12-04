<?php

namespace App\Http\Controllers;

use App\Events\SendEmail;
use App\Models\ContactLead;
use App\Exports\LeadsExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App\Mail\ContactLead as ContactLeadMail;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Mail\ContactLeadConfirmation;
use Exception;

class ContactLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactLeads = ContactLead::orderBy('created_at', 'DESC')->get();
        $contactLeadsFilter = [];

        foreach ($contactLeads as $contactLead) {
            if(array_search(json_decode($contactLead->json)->target_lead, $contactLeadsFilter)===false){
                $contactLeadsFilter = array_merge($contactLeadsFilter, [json_decode($contactLead->json)->target_lead]);
            }
            $contactLead->json = json_decode($contactLead->json);
        }

        return view('Admin.cruds.contactLead.index', [
            'contactLeads' => $contactLeads,
            'contactLeadsFilter' => $contactLeadsFilter
        ]);
    }

    /**
     * Filter leads
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function filterLeads($request)
    {
        $contactLeads = ContactLead::whereNotNull('json');

        if($request->date_start<>'' && $request->date_end==''){
            $contactLeads = $contactLeads->where('created_at', '>', $request->date_start);
        }

        if($request->date_start=='' && $request->date_end<>''){
            $contactLeads = $contactLeads->where('created_at', '>', $request->date_end);
        }

        if($request->date_start<>'' && $request->date_end<>''){
            $contactLeads = $contactLeads->whereBetween('created_at', [$request->date_start, $request->date_end]);
        }

        if($request->target_lead <> ''){
            $contactLeads = $contactLeads->where('json', 'LIKE', '%'.$request->target_lead.'%');
        }

        $contactLeads = $contactLeads->orderBy('created_at', 'DESC')->get();

        return $contactLeads;
    }

    public function filter(Request $request)
    {
        $contactLeads = self::filterLeads($request);

        $contactLeadsFilter = [];
        foreach ($contactLeads as $contactLead) {
            if(array_search(json_decode($contactLead->json)->target_lead, $contactLeadsFilter)===false){
                $contactLeadsFilter = array_merge($contactLeadsFilter, [json_decode($contactLead->json)->target_lead]);
            }
            $contactLead->json = json_decode($contactLead->json);
        }

        return view('Admin.cruds.contactLead.index', [
            'contactLeads' => $contactLeads,
            'contactLeadsFilter' => $contactLeadsFilter,
            'request' => $request
        ]);
    }

    public function export(Request $request)
    {
        $contactLeads = self::filterLeads($request);
        foreach ($contactLeads as $contactLead) {
            $contactLead->json = json_decode($contactLead->json);
        }

        switch ($request->extension) {
            case 'csv':
                $extension = ['.csv', \Maatwebsite\Excel\Excel::CSV];
            break;
            case 'tsv':
                $extension = ['.csv', \Maatwebsite\Excel\Excel::TSV];
            break;
            case 'ods':
                $extension = ['.ods', \Maatwebsite\Excel\Excel::ODS];
            break;
            case 'xls':
                $extension = ['.xls', \Maatwebsite\Excel\Excel::XLS];
            break;
            default:
                $extension = ['.xlsx', \Maatwebsite\Excel\Excel::XLSX];
            break;
        }

        $name = 'leads_'.date('d_m_Y').$extension[0];
        return Excel::download(new LeadsExport($contactLeads), $name, $extension[1]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);

        $arrayInsert = [];
        $emailSet = false;
        foreach ($data as $key => $value) {
            $array = explode('_', $key);
            $requestFile = null;
            if(COUNT($array) >= 3 ){
                $type = end($array);
                $name = str_replace('_'.$type, '', $key);
                if($type == 'file'){
                    $helperArchive = new HelperArchive();
                    $nameFile = $helperArchive->uploadArchive($request, $key, 'uploads/leads/archives/');
                    $value = $nameFile;
                    $requestFile = $request->file($key);
                }

                $arrayInsert = array_merge($arrayInsert, [$data[$name] => ['value' => $value, 'type' => $type, 'requestFile' => $requestFile]]);
                if($type=='email'){
                    $emailSet = true;
                }
            }
        }

        if($request->has('target_lead')){
            $arrayInsert = array_merge($arrayInsert, ['target_lead' => $request->target_lead]);
        }

        if($request->has('target_send')){
            $emailRecipient = base64_decode($request->target_send);
        }

        $contactLead = ContactLead::create(['json' => json_encode($arrayInsert)]);

        try {
            Mail::send(new ContactLeadMail($arrayInsert, $emailRecipient));
            Mail::send(new ContactLeadConfirmation($contactLead));
        } catch (Exception $e) {}

        return Response::json([
            'status' => 'success',
            'redirect' => route('lead.confirmation')
        ]);
    }


    public function confirmation()
    {
        dd('sdasdasd');
    }
}
