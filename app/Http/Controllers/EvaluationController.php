<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Evaluations
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Evaluation::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::where($oInput,"group",$oQb);
        $oQb = QB::where($oInput,"eval_cycle",$oQb);
        $oQb = QB::where($oInput,"max_mark",$oQb);
        
        $oEvaluations = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Evaluations"]), $oEvaluations, false);
        $this->urlRec(7, 0, $oResponse);
        return $oResponse;
    }

    // Store new Evaluation

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'group'     => 'required|in:0,1',
            'eval_cycle'=> 'required|in:0,1',
            'max_mark'  => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEvaluation = Evaluation::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'group'         =>  $oInput['group'],
            'eval_cycle'    =>  $oInput['eval_cycle'],
            'max_mark'      =>  $oInput['max_mark'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEvaluation= Evaluation::findOrFail($oEvaluation->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Evaluation"]), $oEvaluation, false);

        $this->urlRec(7, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oEvaluation= Evaluation::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Evaluation"]), $oEvaluation, false);

        $this->urlRec(7, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'group'     => 'required|in:0,1',
            'eval_cycle'=> 'required|in:0,1',
            'max_mark'  => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oEvaluation = Evaluation::findOrFail($id); 

        $oEvaluations = $oEvaluation->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'group'         =>  $oInput['group'],
            'eval_cycle'     =>  $oInput['eval_cycle'],
            'max_mark'      =>  $oInput['max_mark'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEvaluation = Evaluation::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Evaluation"]), $oEvaluation, false);

        $this->urlRec(7, 3, $oResponse);
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
                $oEvaluation = Evaluation::find($id);
                if($oEvaluation){
                    $oEvaluation->delete();
                }
            }
        }else{
            $oEvaluation = Evaluation::findOrFail($aIds);
            $oEvaluation->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Evaluation"]));
        $this->urlRec(7, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oEvaluation = Evaluation::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Evaluation"]), $oEvaluation, false);
        
        $this->urlRec(7, 5, $oResponse);
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
                
                $oEvaluation = Evaluation::onlyTrashed()->find($id);
                if($oEvaluation){
                    $oEvaluation->restore();
                }
            }
        }else{
            $oEvaluation = Evaluation::onlyTrashed()->findOrFail($aIds);
            $oEvaluation->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Evaluation"]));

        $this->urlRec(7, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oEvaluation = Evaluation::onlyTrashed()->findOrFail($id);
        
        $oEvaluation->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Evaluation"]));
        $this->urlRec(7, 7, $oResponse);
        return $oResponse;
    }
}
