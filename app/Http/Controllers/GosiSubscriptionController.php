<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\GosiSubscription;
use Illuminate\Support\Facades\Validator;

class GosiSubscriptionController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the GosiSubscriptions
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = GosiSubscription::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        
        $oGosiSubscriptions = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"GosiSubscriptions"]), $oGosiSubscriptions, false);
        $this->urlRec(21, 0, $oResponse);
        return $oResponse;
    }

    // Store new GosiSubscription

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oGosiSubscription = GosiSubscription::create([
            'en_name'          =>  $oInput['en_name'],
            'ar_name'          =>  $oInput['ar_name'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oGosiSubscription= GosiSubscription::findOrFail($oGosiSubscription->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"GosiSubscription"]), $oGosiSubscription, false);

        $this->urlRec(21, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oGosiSubscription= GosiSubscription::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"GosiSubscription"]), $oGosiSubscription, false);

        $this->urlRec(21, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oGosiSubscription = GosiSubscription::findOrFail($id); 

        $oGosiSubscriptions = $oGosiSubscription->update([
            'en_name'          =>  $oInput['en_name'],
            'ar_name'          =>  $oInput['ar_name'],
            'updated_at'       =>  Carbon::now()->toDateTimeString(),
        ]);
        $oGosiSubscription = GosiSubscription::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"GosiSubscription"]), $oGosiSubscription, false);

        $this->urlRec(21, 3, $oResponse);
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
                $oGosiSubscription = GosiSubscription::find($id);
                if($oGosiSubscription){
                    $oGosiSubscription->delete();
                }
            }
        }else{
            $oGosiSubscription = GosiSubscription::findOrFail($aIds);
            $oGosiSubscription->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"GosiSubscription"]));
        $this->urlRec(21, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oGosiSubscription = GosiSubscription::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"GosiSubscription"]), $oGosiSubscription, false);
        
        $this->urlRec(21, 5, $oResponse);
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
                
                $oGosiSubscription = GosiSubscription::onlyTrashed()->find($id);
                if($oGosiSubscription){
                    $oGosiSubscription->restore();
                }
            }
        }else{
            $oGosiSubscription = GosiSubscription::onlyTrashed()->findOrFail($aIds);
            $oGosiSubscription->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"GosiSubscription"]));

        $this->urlRec(21, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oGosiSubscription = GosiSubscription::onlyTrashed()->findOrFail($id);
        
        $oGosiSubscription->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"GosiSubscription"]));
        $this->urlRec(21, 7, $oResponse);
        return $oResponse;
    }
}
