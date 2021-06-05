<?php

namespace App\Http\Controllers;

use App\Models\CompanySchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class CompanyScheduleController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the CompanySchedules
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = CompanySchedule::with(['companyId'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_description",$oQb);
        $oQb = QB::whereLike($oInput,"ar_description",$oQb);
        $oQb = QB::whereDate($oInput,"date_from",$oQb);
        $oQb = QB::whereDate($oInput,"date_to",$oQb);
        $oQb = QB::whereDate($oInput,"date_from_h",$oQb);
        $oQb = QB::whereDate($oInput,"date_to_h",$oQb);
        $oQb = QB::where($oInput,"no_work",$oQb);
        $oQb = QB::where($oInput,"for_schedule",$oQb);
        $oQb = QB::where($oInput,"paid_overtime",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        
        $oCompanySchedules = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Company Schedule"]), $oCompanySchedules, false);
        $this->urlRec(25, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_description'   => 'required|max:50',
            'ar_description'   => 'required|max:50',
            'date_from'   => 'required|date',
            'date_to'   => 'required|date',
            'date_from_h'   => 'required|date',
            'date_to_h'   => 'required|date',
            'no_work'=> 'required|in:0,1',
            'for_schedule'=> 'required|in:0,1',
            'paid_overtime'=> 'required|in:0,1',
            'company_id' => 'required|exists:companies,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oCompanySchedule = CompanySchedule::create([
            'en_description'    =>  $oInput['en_description'],
            'ar_description'    =>  $oInput['ar_description'],
            'date_from'         =>  $oInput['date_from'],
            'date_to'           =>  $oInput['date_to'],
            'date_from_h'       =>  $oInput['date_from_h'],
            'date_to_h'         =>  $oInput['date_to_h'],
            'no_work'           =>  $oInput['no_work'],
            'for_schedule'      =>  $oInput['for_schedule'],
            'paid_overtime'     =>  $oInput['paid_overtime'],
            'company_id'        =>  $oInput['company_id'],
            'created_at'        =>  Carbon::now()->toDateTimeString(),
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);

        $oCompanySchedule= CompanySchedule::with(['companyId'])->findOrFail($oCompanySchedule->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Company Schedule"]), $oCompanySchedule, false);
        $this->urlRec(25, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oCompanySchedule= CompanySchedule::with(['companyId'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Company Schedule"]), $oCompanySchedule, false);
        $this->urlRec(25, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_description'   => 'required|max:50',
            'ar_description'   => 'required|max:50',
            'date_from'   => 'required|date',
            'date_to'   => 'required|date',
            'date_from_h'   => 'required|date',
            'date_to_h'   => 'required|date',
            'no_work'=> 'required|in:0,1',
            'for_schedule'=> 'required|in:0,1',
            'paid_overtime'=> 'required|in:0,1',
            'company_id' => 'required|exists:companies,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oCompanySchedule = CompanySchedule::findOrFail($id); 

        $oCompanySchedules = $oCompanySchedule->update([
            'en_description'    =>  $oInput['en_description'],
            'ar_description'    =>  $oInput['ar_description'],
            'date_from'         =>  $oInput['date_from'],
            'date_to'           =>  $oInput['date_to'],
            'date_from_h'       =>  $oInput['date_from_h'],
            'date_to_h'         =>  $oInput['date_to_h'],
            'no_work'           =>  $oInput['no_work'],
            'for_schedule'      =>  $oInput['for_schedule'],
            'paid_overtime'     =>  $oInput['paid_overtime'],
            'company_id'        =>  $oInput['company_id'],
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);
        $oCompanySchedule = CompanySchedule::with(['companyId'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Company Schedule"]), $oCompanySchedule, false);
        
        $this->urlRec(25, 3, $oResponse);
        
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
                $oCompanySchedule = CompanySchedule::find($id);
                if($oCompanySchedule){
                    $oCompanySchedule->delete();
                }
            }
        }else{
            $oCompanySchedule = CompanySchedule::findOrFail($aIds);
            $oCompanySchedule->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Company Schedule"]));
        $this->urlRec(25, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oCompanySchedule = CompanySchedule::onlyTrashed()->with(['companyId'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Company Schedule"]), $oCompanySchedule, false);
        $this->urlRec(25, 5, $oResponse); 
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
                
                $oCompanySchedule = CompanySchedule::onlyTrashed()->find($id);
                if($oCompanySchedule){
                    $oCompanySchedule->restore();
                }
            }
        }else{
            $oCompanySchedule = CompanySchedule::onlyTrashed()->findOrFail($aIds);
            $oCompanySchedule->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Company Schedule"]));
        $this->urlRec(25, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oCompanySchedule = CompanySchedule::onlyTrashed()->findOrFail($id);
        
        $oCompanySchedule->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Company Schedule"]));
        $this->urlRec(25, 7, $oResponse);
        return $oResponse;
    }
}
