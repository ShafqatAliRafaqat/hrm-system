<?php

namespace App\Http\Controllers;

use App\Models\CompanyNote;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class CompanyNoteController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the CompanyNotes
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = CompanyNote::with(['companyId'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"notes",$oQb);
        $oQb = QB::whereLike($oInput,"undertaking_notes",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        
        $oCompanyNotes = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Company Notes"]), $oCompanyNotes, false);
        $this->urlRec(32, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'notes'   => 'required|max:500',
            'undertaking_notes' => 'required|max:500',
            'company_id' => 'required|exists:companies,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oCompanyNote = CompanyNote::create([
            'notes'             =>  $oInput['notes'],
            'undertaking_notes' =>  $oInput['undertaking_notes'],
            'company_id'        =>  $oInput['company_id'],
            'created_at'        =>  Carbon::now()->toDateTimeString(),
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);

        $oCompanyNote= CompanyNote::with(['companyId'])->findOrFail($oCompanyNote->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Company Notes"]), $oCompanyNote, false);
        $this->urlRec(32, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oCompanyNote= CompanyNote::with(['companyId'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Company Notes"]), $oCompanyNote, false);
        $this->urlRec(32, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'notes'   => 'required|max:500',
            'undertaking_notes'   => 'required|max:500',
            'company_id' => 'required|exists:companies,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oCompanyNote = CompanyNote::findOrFail($id); 

        $oCompanyNotes = $oCompanyNote->update([
            'notes'             =>  $oInput['notes'],
            'undertaking_notes' =>  $oInput['undertaking_notes'],
            'company_id'        =>  $oInput['company_id'],
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);
        $oCompanyNote = CompanyNote::with(['companyId'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Company Notes"]), $oCompanyNote, false);
        
        $this->urlRec(32, 3, $oResponse);
        
        return $oResponse;
    }

    // Soft Delete country 

    public function destroy(Request $request)
    {
        $oInput = $request->all();
        $oValidator = Validator::make($oInput,[
            'ids'        => 'required',
        ]);
        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $aIds = $request->ids;
        if(is_array($aIds)){
            foreach($aIds as $id){
                $oCompanyNote = CompanyNote::find($id);
                if($oCompanyNote){
                    $oCompanyNote->delete();
                }
            }
        }else{
            $oCompanyNote = CompanyNote::findOrFail($aIds);
            $oCompanyNote->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Company Notes"]));
        $this->urlRec(32, 4, $oResponse);
        return $oResponse;
    }
}
