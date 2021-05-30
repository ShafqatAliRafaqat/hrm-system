<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\EvaluationType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EvaluationTypeController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EvaluationTypes
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EvaluationType::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        
        $oEvaluationTypes = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"EvaluationTypes"]), $oEvaluationTypes, false);
        $this->urlRec(10, 0, $oResponse);
        return $oResponse;
    }

    // Store new EvaluationType

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

        $oEvaluationType = EvaluationType::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEvaluationType= EvaluationType::findOrFail($oEvaluationType->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"EvaluationType"]), $oEvaluationType, false);

        $this->urlRec(10, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oEvaluationType= EvaluationType::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"EvaluationType"]), $oEvaluationType, false);

        $this->urlRec(10, 2, $oResponse); 
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
        $oEvaluationType = EvaluationType::findOrFail($id); 

        $oEvaluationTypes = $oEvaluationType->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEvaluationType = EvaluationType::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"EvaluationType"]), $oEvaluationType, false);

        $this->urlRec(10, 3, $oResponse);
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
                $oEvaluationType = EvaluationType::find($id);
                if($oEvaluationType){
                    $oEvaluationType->delete();
                }
            }
        }else{
            $oEvaluationType = EvaluationType::findOrFail($aIds);
            $oEvaluationType->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"EvaluationType"]));
        $this->urlRec(10, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oEvaluationType = EvaluationType::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"EvaluationType"]), $oEvaluationType, false);
        
        $this->urlRec(10, 5, $oResponse);
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
                
                $oEvaluationType = EvaluationType::onlyTrashed()->find($id);
                if($oEvaluationType){
                    $oEvaluationType->restore();
                }
            }
        }else{
            $oEvaluationType = EvaluationType::onlyTrashed()->findOrFail($aIds);
            $oEvaluationType->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"EvaluationType"]));

        $this->urlRec(10, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oEvaluationType = EvaluationType::onlyTrashed()->findOrFail($id);
        
        $oEvaluationType->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"EvaluationType"]));
        $this->urlRec(10, 7, $oResponse);
        return $oResponse;
    }
}
