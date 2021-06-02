<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Session;
use Illuminate\Support\Facades\Validator;

class SessionController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Sessions
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Session::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::where($oInput,"cin",$oQb);
        $oQb = QB::where($oInput,"cout",$oQb);
        $oQb = QB::where($oInput,"begin",$oQb);
        $oQb = QB::where($oInput,"end",$oQb);
        
        $oSessions = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Sessions"]), $oSessions, false);
        $this->urlRec(20, 0, $oResponse);
        return $oResponse;
    }

    // Store new Session

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'begin'     => 'required|time',
            'cin'       => 'required|time',
            'cout'      => 'required|time',
            'end'       => 'required|time',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oSession = Session::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'begin'         =>  $oInput['begin'],
            'cin'           =>  $oInput['cin'],
            'cout'          =>  $oInput['cout'],
            'end'           =>  $oInput['end'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oSession= Session::findOrFail($oSession->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Session"]), $oSession, false);

        $this->urlRec(20, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oSession= Session::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Session"]), $oSession, false);

        $this->urlRec(20, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'begin'     => 'required|time',
            'cin'       => 'required|time',
            'cout'      => 'required|time',
            'end'       => 'required|time',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oSession = Session::findOrFail($id); 

        $oSessions = $oSession->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'begin'         =>  $oInput['begin'],
            'cin'           =>  $oInput['cin'],
            'cout'          =>  $oInput['cout'],
            'end'           =>  $oInput['end'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oSession = Session::find($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Session"]), $oSession, false);

        $this->urlRec(20, 3, $oResponse);
        return $oResponse;
    }

    // Soft Delete city 

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
                $oSession = Session::find($id);
                if($oSession){
                    $oSession->delete();
                }
            }
        }else{
            $oSession = Session::findOrFail($aIds);
            $oSession->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Session"]));
        $this->urlRec(20, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oSession = Session::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Session"]), $oSession, false);
        
        $this->urlRec(20, 5, $oResponse);
        return $oResponse;
    }
    // Restore any deleted data
    public function restore(Request $request)
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
                
                $oSession = Session::onlyTrashed()->find($id);
                if($oSession){
                    $oSession->restore();
                }
            }
        }else{
            $oSession = Session::onlyTrashed()->findOrFail($aIds);
            $oSession->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Session"]));

        $this->urlRec(20, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oSession = Session::onlyTrashed()->findOrFail($id);
        
        $oSession->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Session"]));
        $this->urlRec(20, 7, $oResponse);
        return $oResponse;
    }
}
