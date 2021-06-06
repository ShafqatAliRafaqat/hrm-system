<?php

namespace App\Http\Controllers;

use App\Models\DepartmentSection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentSectionController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the DepartmentSections
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = DepartmentSection::with(['companyId','departmentId'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"status",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"department_id",$oQb);
        
        $oDepartmentSections = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Department Section"]), $oDepartmentSections, false);
        $this->urlRec(28, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'status'   => 'nullable|max:50',
            'department_id' => 'required|exists:company_departments,id',
            'company_id' => 'required|exists:companies,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oDepartmentSection = DepartmentSection::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'status'      =>  $oInput['status'],
            'department_id'    =>  $oInput['department_id'],
            'company_id'    =>  $oInput['company_id'],
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oDepartmentSection= DepartmentSection::with(['companyId','departmentId'])->findOrFail($oDepartmentSection->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Department Section"]), $oDepartmentSection, false);
        $this->urlRec(28, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oDepartmentSection= DepartmentSection::with(['companyId','departmentId'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Department Section"]), $oDepartmentSection, false);
        $this->urlRec(28, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'status'   => 'nullable|max:50',
            'department_id' => 'required|exists:company_departments,id',
            'company_id' => 'required|exists:companies,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oDepartmentSection = DepartmentSection::findOrFail($id); 

        $oDepartmentSections = $oDepartmentSection->update([
            'en_name'        =>  $oInput['en_name'],
            'ar_name'        =>  $oInput['ar_name'],
            'status'         =>  $oInput['status'],
            'department_id'  =>  $oInput['department_id'],
            'company_id'     =>  $oInput['company_id'],
            'updated_at'     =>  Carbon::now()->toDateTimeString(),
        ]);
        $oDepartmentSection = DepartmentSection::with(['companyId','departmentId'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Department Section"]), $oDepartmentSection, false);
        
        $this->urlRec(28, 3, $oResponse);
        
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
                $oDepartmentSection = DepartmentSection::find($id);
                if($oDepartmentSection){
                    $oDepartmentSection->delete();
                }
            }
        }else{
            $oDepartmentSection = DepartmentSection::findOrFail($aIds);
            $oDepartmentSection->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Department Section"]));
        $this->urlRec(28, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oDepartmentSection = DepartmentSection::onlyTrashed()->with(['companyId','departmentId'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Department Section"]), $oDepartmentSection, false);
        $this->urlRec(28, 5, $oResponse); 
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
                
                $oDepartmentSection = DepartmentSection::onlyTrashed()->find($id);
                if($oDepartmentSection){
                    $oDepartmentSection->restore();
                }
            }
        }else{
            $oDepartmentSection = DepartmentSection::onlyTrashed()->findOrFail($aIds);
            $oDepartmentSection->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Department Section"]));
        $this->urlRec(28, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oDepartmentSection = DepartmentSection::onlyTrashed()->findOrFail($id);
        
        $oDepartmentSection->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Department Section"]));
        $this->urlRec(28, 7, $oResponse);
        return $oResponse;
    }
}
