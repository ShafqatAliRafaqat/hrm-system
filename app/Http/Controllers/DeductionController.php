<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Deduction;
use Illuminate\Support\Facades\Validator;

class DeductionController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Deductions
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Deduction::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::where($oInput,"credit_glid",$oQb);
        $oQb = QB::where($oInput,"parentdeduction",$oQb);
        $oQb = QB::where($oInput,"modifyflag",$oQb);
        $oQb = QB::where($oInput,"is_request",$oQb);
        $oQb = QB::where($oInput,"is_fixed",$oQb);
        $oQb = QB::where($oInput,"is_mb",$oQb);
        $oQb = QB::where($oInput,"printable",$oQb);
        
        $oDeductions = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Deductions"]), $oDeductions, false);
        $this->urlRec(15, 0, $oResponse);
        return $oResponse;
    }

    // Store new Deduction

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'is_fixed' => 'required|in:0,1',
            'credit_glid'  => 'required|max:50',
            'parentdeduction'=> 'required|max:50',
            'is_request'     => 'required|in:0,1',
            'modifyflag'    => 'required|in:0,1',
            'is_mb'     => 'required|in:0,1',
            'printable'  => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oDeduction = Deduction::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'is_fixed'      =>  $oInput['is_fixed'],
            'credit_glid'   =>  $oInput['credit_glid'],
            'parentdeduction'=>  $oInput['parentdeduction'],
            'is_request'     =>  $oInput['is_request'],
            'modifyflag'    =>  $oInput['modifyflag'],
            'is_mb'         =>  $oInput['is_mb'],
            'printable'     =>  $oInput['printable'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oDeduction= Deduction::findOrFail($oDeduction->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Deduction"]), $oDeduction, false);

        $this->urlRec(15, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oDeduction= Deduction::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Deduction"]), $oDeduction, false);

        $this->urlRec(15, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'is_fixed' => 'required|in:0,1',
            'credit_glid'  => 'required|max:50',
            'parentdeduction'=> 'required|max:50',
            'is_request'     => 'required|in:0,1',
            'modifyflag'    => 'required|in:0,1',
            'is_mb'     => 'required|in:0,1',
            'printable'  => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oDeduction = Deduction::findOrFail($id); 

        $oDeductions = $oDeduction->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'is_fixed'      =>  $oInput['is_fixed'],
            'credit_glid'   =>  $oInput['credit_glid'],
            'parentdeduction'=>  $oInput['parentdeduction'],
            'is_request'     =>  $oInput['is_request'],
            'modifyflag'    =>  $oInput['modifyflag'],
            'is_mb'         =>  $oInput['is_mb'],
            'printable'     =>  $oInput['printable'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oDeduction = Deduction::find($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Deduction"]), $oDeduction, false);

        $this->urlRec(15, 3, $oResponse);
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
                $oDeduction = Deduction::find($id);
                if($oDeduction){
                    $oDeduction->delete();
                }
            }
        }else{
            $oDeduction = Deduction::findOrFail($aIds);
            $oDeduction->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Deduction"]));
        $this->urlRec(15, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oDeduction = Deduction::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Deduction"]), $oDeduction, false);
        
        $this->urlRec(15, 5, $oResponse);
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
                
                $oDeduction = Deduction::onlyTrashed()->find($id);
                if($oDeduction){
                    $oDeduction->restore();
                }
            }
        }else{
            $oDeduction = Deduction::onlyTrashed()->findOrFail($aIds);
            $oDeduction->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Deduction"]));

        $this->urlRec(15, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oDeduction = Deduction::onlyTrashed()->findOrFail($id);
        
        $oDeduction->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Deduction"]));
        $this->urlRec(15, 7, $oResponse);
        return $oResponse;
    }
}
