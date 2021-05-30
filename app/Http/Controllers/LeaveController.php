<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Leaves
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Leave::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::where($oInput,"is_salary",$oQb);
        $oQb = QB::where($oInput,"requirevisa",$oQb);
        $oQb = QB::where($oInput,"withpay",$oQb);
        $oQb = QB::where($oInput,"operator",$oQb);
        $oQb = QB::where($oInput,"duration",$oQb);
        $oQb = QB::where($oInput,"extra_leavecalc",$oQb);
        $oQb = QB::where($oInput,"is_active",$oQb);
        $oQb = QB::where($oInput,"is_settlement",$oQb);
        $oQb = QB::where($oInput,"request",$oQb);
        
        $oLeaves = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Leaves"]), $oLeaves, false);
        $this->urlRec(12, 0, $oResponse);
        return $oResponse;
    }

    // Store new Leave

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'duration' => 'required|max:5',
            'is_salary'  => 'required|in:0,1',
            'requirevisa'=> 'required|in:0,1',
            'withpay'   => 'required|in:0,1',
            'operator'     => 'required|in:0,1',
            'extra_leavecalc'    => 'required|in:0,1',
            'is_active'     => 'required|in:0,1',
            'is_settlement'   => 'required|in:0,1',
            'request'  => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oLeave = Leave::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'duration' =>  $oInput['duration'],
            'is_salary'  =>  $oInput['is_salary'],
            'requirevisa'=>  $oInput['requirevisa'],
            'withpay'   =>  $oInput['withpay'],
            'withpay'   =>  $oInput['withpay'],
            'operator'     =>  $oInput['operator'],
            'extra_leavecalc'    =>  $oInput['extra_leavecalc'],
            'is_active'     =>  $oInput['is_active'],
            'is_settlement'   =>  $oInput['is_settlement'],
            'request'  =>  $oInput['request'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oLeave= Leave::findOrFail($oLeave->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Leave"]), $oLeave, false);

        $this->urlRec(12, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oLeave= Leave::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Leave"]), $oLeave, false);

        $this->urlRec(12, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'duration' => 'required|max:5',
            'is_salary'  => 'required|in:0,1',
            'requirevisa'=> 'required|in:0,1',
            'withpay'   => 'required|in:0,1',
            'operator'     => 'required|in:0,1',
            'extra_leavecalc'    => 'required|in:0,1',
            'is_active'     => 'required|in:0,1',
            'is_settlement'   => 'required|in:0,1',
            'request'  => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oLeave = Leave::findOrFail($id); 

        $oLeaves = $oLeave->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'duration' =>  $oInput['duration'],
            'is_salary'  =>  $oInput['is_salary'],
            'requirevisa'=>  $oInput['requirevisa'],
            'withpay'   =>  $oInput['withpay'],
            'withpay'   =>  $oInput['withpay'],
            'operator'     =>  $oInput['operator'],
            'extra_leavecalc'    =>  $oInput['extra_leavecalc'],
            'is_active'     =>  $oInput['is_active'],
            'is_settlement'   =>  $oInput['is_settlement'],
            'request'  =>  $oInput['request'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oLeave = Leave::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Leave"]), $oLeave, false);

        $this->urlRec(12, 3, $oResponse);
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
                $oLeave = Leave::find($id);
                if($oLeave){
                    $oLeave->delete();
                }
            }
        }else{
            $oLeave = Leave::findOrFail($aIds);
            $oLeave->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Leave"]));
        $this->urlRec(12, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oLeave = Leave::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Leave"]), $oLeave, false);
        
        $this->urlRec(12, 5, $oResponse);
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
                
                $oLeave = Leave::onlyTrashed()->find($id);
                if($oLeave){
                    $oLeave->restore();
                }
            }
        }else{
            $oLeave = Leave::onlyTrashed()->findOrFail($aIds);
            $oLeave->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Leave"]));

        $this->urlRec(12, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oLeave = Leave::onlyTrashed()->findOrFail($id);
        
        $oLeave->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Leave"]));
        $this->urlRec(12, 7, $oResponse);
        return $oResponse;
    }
}
