<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\EvaluationType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BeneficiaryTypeController extends Controller
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
        $oQb = QB::where($oInput,"finalsetflag",$oQb);
        $oQb = QB::where($oInput,"moneyvalueflag",$oQb);
        $oQb = QB::where($oInput,"holidayflag",$oQb);
        $oQb = QB::where($oInput,"printable",$oQb);
        $oQb = QB::where($oInput,"parentbenefit",$oQb);
        $oQb = QB::where($oInput,"modifyflag",$oQb);
        $oQb = QB::where($oInput,"is_active",$oQb);
        $oQb = QB::where($oInput,"credit_glid",$oQb);
        $oQb = QB::where($oInput,"showinreport",$oQb);
        $oQb = QB::where($oInput,"mulfactor",$oQb);
        $oQb = QB::where($oInput,"percent_frsalary",$oQb);
        $oQb = QB::where($oInput,"mb",$oQb);
        
        $oEvaluationTypes = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"EvaluationTypes"]), $oEvaluationTypes, false);
        $this->urlRec(11, 0, $oResponse);
        return $oResponse;
    }

    // Store new EvaluationType

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'parentbenefit' => 'required|max:5',
            'finalsetflag'  => 'required|in:0,1',
            'moneyvalueflag'=> 'required|in:0,1',
            'holidayflag'   => 'required|in:0,1',
            'printable'     => 'required|in:0,1',
            'modifyflag'    => 'required|in:0,1',
            'is_active'     => 'required|in:0,1',
            'credit_glid'   => 'required|in:0,1',
            'showinreport'  => 'required|in:0,1',
            'mulfactor'     => 'required|in:0,1',
            'percent_frsalary'=> 'required|in:0,1',
            'mb'            => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEvaluationType = EvaluationType::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'parentbenefit' =>  $oInput['parentbenefit'],
            'finalsetflag'  =>  $oInput['finalsetflag'],
            'moneyvalueflag'=>  $oInput['moneyvalueflag'],
            'holidayflag'   =>  $oInput['holidayflag'],
            'holidayflag'   =>  $oInput['holidayflag'],
            'printable'     =>  $oInput['printable'],
            'modifyflag'    =>  $oInput['modifyflag'],
            'is_active'     =>  $oInput['is_active'],
            'credit_glid'   =>  $oInput['credit_glid'],
            'showinreport'  =>  $oInput['showinreport'],
            'mulfactor'     =>  $oInput['mulfactor'],
            'percent_frsalary'=>  $oInput['percent_frsalary'],
            'mb'            =>  $oInput['mb'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEvaluationType= EvaluationType::findOrFail($oEvaluationType->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"EvaluationType"]), $oEvaluationType, false);

        $this->urlRec(11, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oEvaluationType= EvaluationType::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"EvaluationType"]), $oEvaluationType, false);

        $this->urlRec(11, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'parentbenefit' => 'required|max:5',
            'finalsetflag'  => 'required|in:0,1',
            'moneyvalueflag'=> 'required|in:0,1',
            'holidayflag'   => 'required|in:0,1',
            'printable'     => 'required|in:0,1',
            'modifyflag'    => 'required|in:0,1',
            'is_active'     => 'required|in:0,1',
            'credit_glid'   => 'required|in:0,1',
            'showinreport'  => 'required|in:0,1',
            'mulfactor'     => 'required|in:0,1',
            'percent_frsalary'=> 'required|in:0,1',
            'mb'            => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oEvaluationType = EvaluationType::findOrFail($id); 

        $oEvaluationTypes = $oEvaluationType->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'parentbenefit' =>  $oInput['parentbenefit'],
            'finalsetflag'  =>  $oInput['finalsetflag'],
            'moneyvalueflag'=>  $oInput['moneyvalueflag'],
            'holidayflag'   =>  $oInput['holidayflag'],
            'holidayflag'   =>  $oInput['holidayflag'],
            'printable'     =>  $oInput['printable'],
            'modifyflag'    =>  $oInput['modifyflag'],
            'is_active'     =>  $oInput['is_active'],
            'credit_glid'   =>  $oInput['credit_glid'],
            'showinreport'  =>  $oInput['showinreport'],
            'mulfactor'     =>  $oInput['mulfactor'],
            'percent_frsalary'=>  $oInput['percent_frsalary'],
            'mb'            =>  $oInput['mb'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEvaluationType = EvaluationType::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"EvaluationType"]), $oEvaluationType, false);

        $this->urlRec(11, 3, $oResponse);
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
        $this->urlRec(11, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oEvaluationType = EvaluationType::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"EvaluationType"]), $oEvaluationType, false);
        
        $this->urlRec(11, 5, $oResponse);
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

        $this->urlRec(11, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oEvaluationType = EvaluationType::onlyTrashed()->findOrFail($id);
        
        $oEvaluationType->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"EvaluationType"]));
        $this->urlRec(11, 7, $oResponse);
        return $oResponse;
    }
}
