<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Helpers\QB;
use App\Models\CostCenter;
use Illuminate\Support\Facades\Validator;

class CostCenterController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the CostCenters
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = CostCenter::orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::where($oInput,"storecc",$oQb);
        $oQb = QB::where($oInput,"status",$oQb);
        $oQb = QB::where($oInput,"is_active",$oQb);
        $oQb = QB::where($oInput,"update_status",$oQb);
        
        $oCostCenters = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Cost Centers"]), $oCostCenters, false);
        $this->urlRec(18, 0, $oResponse);
        return $oResponse;
    }

    // Store new CostCenter

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'is_active'      => 'required|in:0,1',
            'storecc'       => 'required|in:0,1',
            'status'        => 'required|in:0,1',
            'update_status' => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oCostCenter = CostCenter::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'is_active'      =>  $oInput['is_active'],
            'storecc'       =>  $oInput['storecc'],
            'status'        =>  $oInput['status'],
            'update_status' =>  $oInput['update_status'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oCostCenter= CostCenter::findOrFail($oCostCenter->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Cost Center"]), $oCostCenter, false);

        $this->urlRec(18, 1, $oResponse);
        return $oResponse;
    }
    // Show city details

    public function show($id)
    {

        $oCostCenter= CostCenter::findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Cost Center"]), $oCostCenter, false);

        $this->urlRec(18, 2, $oResponse); 
        return $oResponse;
    }
    // Update city details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'       => 'required|max:50',
            'ar_name'       => 'required|max:50',
            'is_active'      => 'required|in:0,1',
            'storecc'       => 'required|in:0,1',
            'status'        => 'required|in:0,1',
            'update_status' => 'required|in:0,1',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        $oCostCenter = CostCenter::findOrFail($id); 

        $oCostCenters = $oCostCenter->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'is_active'      =>  $oInput['is_active'],
            'storecc'       =>  $oInput['storecc'],
            'status'        =>  $oInput['status'],
            'update_status' =>  $oInput['update_status'],
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oCostCenter = CostCenter::find($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Cost Center"]), $oCostCenter, false);

        $this->urlRec(18, 3, $oResponse);
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
                $oCostCenter = CostCenter::find($id);
                if($oCostCenter){
                    $oCostCenter->delete();
                }
            }
        }else{
            $oCostCenter = CostCenter::findOrFail($aIds);
            $oCostCenter->delete();
        }
       
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Cost Center"]));
        $this->urlRec(18, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oCostCenter = CostCenter::onlyTrashed()->paginate(10);

        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Cost Center"]), $oCostCenter, false);
        
        $this->urlRec(18, 5, $oResponse);
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
                
                $oCostCenter = CostCenter::onlyTrashed()->find($id);
                if($oCostCenter){
                    $oCostCenter->restore();
                }
            }
        }else{
            $oCostCenter = CostCenter::onlyTrashed()->findOrFail($aIds);
            $oCostCenter->restore();
        }
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Cost Center"]));

        $this->urlRec(18, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oCostCenter = CostCenter::onlyTrashed()->findOrFail($id);
        
        $oCostCenter->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Cost Center"]));
        $this->urlRec(18, 7, $oResponse);
        return $oResponse;
    }
}
