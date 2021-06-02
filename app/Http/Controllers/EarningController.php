<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\Earning;
use Illuminate\Support\Facades\Validator;

class EarningController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Earnings
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Earning::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::where($oInput,"w_value",$oQb);
        $oQb = QB::where($oInput,"is_factor",$oQb);
        $oQb = QB::where($oInput,"is_fixed",$oQb);
        $oQb = QB::where($oInput,"is_mb",$oQb);
        $oQb = QB::where($oInput,"percentage_of_salary",$oQb);
        
        $oEarnings = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Earnings"]), $oEarnings, false);
        $this->urlRec(14, 0, $oResponse);
        return $oResponse;
    }

    // Store new Earning

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'percentage_of_salary' => 'required|max:5',
            'w_value'  => 'required|in:0,1',
            'is_factor'=> 'required|in:0,1',
            'is_fixed'   => 'required|in:0,1',
            'is_mb'     => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEarning = Earning::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'percentage_of_salary' =>  $oInput['percentage_of_salary'],
            'w_value'  =>  $oInput['w_value'],
            'is_factor'=>  $oInput['is_factor'],
            'is_fixed'   =>  $oInput['is_fixed'],
            'is_mb'     =>  $oInput['is_mb'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEarning= Earning::findOrFail($oEarning->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Earning"]), $oEarning, false);

        $this->urlRec(14, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oEarning= Earning::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Earning"]), $oEarning, false);

        $this->urlRec(14, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'percentage_of_salary' => 'required|max:5',
            'w_value'  => 'required|in:0,1',
            'is_factor'=> 'required|in:0,1',
            'is_fixed'   => 'required|in:0,1',
            'is_mb'     => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oEarning = Earning::findOrFail($id); 

        $oEarnings = $oEarning->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'percentage_of_salary' =>  $oInput['percentage_of_salary'],
            'w_value'  =>  $oInput['w_value'],
            'is_factor'=>  $oInput['is_factor'],
            'is_fixed'   =>  $oInput['is_fixed'],
            'is_mb'     =>  $oInput['is_mb'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEarning = Earning::find($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Earning"]), $oEarning, false);

        $this->urlRec(14, 3, $oResponse);
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
                $oEarning = Earning::find($id);
                if($oEarning){
                    $oEarning->delete();
                }
            }
        }else{
            $oEarning = Earning::findOrFail($aIds);
            $oEarning->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Earning"]));
        $this->urlRec(14, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oEarning = Earning::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Earning"]), $oEarning, false);
        
        $this->urlRec(14, 5, $oResponse);
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
                
                $oEarning = Earning::onlyTrashed()->find($id);
                if($oEarning){
                    $oEarning->restore();
                }
            }
        }else{
            $oEarning = Earning::onlyTrashed()->findOrFail($aIds);
            $oEarning->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Earning"]));

        $this->urlRec(14, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oEarning = Earning::onlyTrashed()->findOrFail($id);
        
        $oEarning->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Earning"]));
        $this->urlRec(14, 7, $oResponse);
        return $oResponse;
    }
}
