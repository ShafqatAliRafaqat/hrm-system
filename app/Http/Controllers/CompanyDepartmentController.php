<?php

namespace App\Http\Controllers;

use App\Models\CompanyDepartment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class CompanyDepartmentController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the CompanyDepartments
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = CompanyDepartment::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_manager_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_manager_name",$oQb);
        $oQb = QB::whereLike($oInput,"acctgbranch",$oQb);
        $oQb = QB::whereLike($oInput,"fabranch",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        
        $oCompanyDepartments = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Company Department"]), $oCompanyDepartments, false);
        $this->urlRec(27, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'en_manager_name'   => 'required|max:50',
            'ar_manager_name'   => 'required|max:50',
            'acctgbranch'   => 'nullable|max:50',
            'fabranch'   => 'nullable|max:50',
            'branch_id' => 'required|exists:company_branches,id',
            'company_id' => 'required|exists:companies,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oCompanyDepartment = CompanyDepartment::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'en_manager_name'=>  $oInput['en_manager_name'],
            'ar_manager_name'=>  $oInput['ar_manager_name'],
            'acctgbranch'      =>  $oInput['acctgbranch'],
            'fabranch'      =>  $oInput['fabranch'],
            'branch_id'    =>  $oInput['branch_id'],
            'company_id'    =>  $oInput['company_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oCompanyDepartment= CompanyDepartment::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($oCompanyDepartment->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Company Department"]), $oCompanyDepartment, false);
        $this->urlRec(27, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oCompanyDepartment= CompanyDepartment::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Company Department"]), $oCompanyDepartment, false);
        $this->urlRec(27, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'en_manager_name'   => 'required|max:50',
            'ar_manager_name'   => 'required|max:50',
            'acctgbranch'   => 'nullable|max:50',
            'fabranch'   => 'nullable|max:50',
            'branch_id' => 'required|exists:company_branches,id',
            'company_id' => 'required|exists:companies,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oCompanyDepartment = CompanyDepartment::findOrFail($id); 

        $oCompanyDepartments = $oCompanyDepartment->update([
            'en_name'        =>  $oInput['en_name'],
            'ar_name'        =>  $oInput['ar_name'],
            'en_manager_name'=>  $oInput['en_manager_name'],
            'ar_manager_name'=>  $oInput['ar_manager_name'],
            'acctgbranch'    =>  $oInput['acctgbranch'],
            'fabranch'       =>  $oInput['fabranch'],
            'branch_id'      =>  $oInput['branch_id'],
            'company_id'     =>  $oInput['company_id'],
            'updated_by'     =>  Auth::user()->id,
            'updated_at'     =>  Carbon::now()->toDateTimeString(),
        ]);
        $oCompanyDepartment = CompanyDepartment::with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Company Department"]), $oCompanyDepartment, false);
        
        $this->urlRec(27, 3, $oResponse);
        
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
                $oCompanyDepartment = CompanyDepartment::find($id);
                $oCompanyDepartment->update(['deleted_by'=>Auth::user()->id]);
                if($oCompanyDepartment){
                    $oCompanyDepartment->delete();
                }
            }
        }else{
            $oCompanyDepartment = CompanyDepartment::findOrFail($aIds);
            $oCompanyDepartment->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Company Department"]));
        $this->urlRec(27, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oCompanyDepartment = CompanyDepartment::onlyTrashed()->with(['companyId','branchId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Company Department"]), $oCompanyDepartment, false);
        $this->urlRec(27, 5, $oResponse); 
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
                
                $oCompanyDepartment = CompanyDepartment::onlyTrashed()->find($id);
                if($oCompanyDepartment){
                    $oCompanyDepartment->restore();
                }
            }
        }else{
            $oCompanyDepartment = CompanyDepartment::onlyTrashed()->findOrFail($aIds);
            $oCompanyDepartment->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Company Department"]));
        $this->urlRec(27, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oCompanyDepartment = CompanyDepartment::onlyTrashed()->findOrFail($id);
        
        $oCompanyDepartment->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Company Department"]));
        $this->urlRec(27, 7, $oResponse);
        return $oResponse;
    }
}
