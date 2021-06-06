<?php

namespace App\Http\Controllers;

use App\Models\CompanyBranch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class CompanyBranchController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the CompanyBranches
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = CompanyBranch::with(['companyId','countryId','cityId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_manager_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_manager_name",$oQb);
        $oQb = QB::whereLike($oInput,"address_1",$oQb);
        $oQb = QB::whereLike($oInput,"address_2",$oQb);
        $oQb = QB::whereLike($oInput,"address_3",$oQb);
        $oQb = QB::whereLike($oInput,"address_4",$oQb);
        $oQb = QB::whereLike($oInput,"postal_code",$oQb);
        $oQb = QB::whereLike($oInput,"state_region",$oQb);
        $oQb = QB::whereLike($oInput,"phone_1",$oQb);
        $oQb = QB::whereLike($oInput,"phone_2",$oQb);
        $oQb = QB::whereLike($oInput,"phone_3",$oQb);
        $oQb = QB::whereLike($oInput,"fax_2",$oQb);
        $oQb = QB::whereLike($oInput,"fax_3",$oQb);
        $oQb = QB::whereLike($oInput,"email",$oQb);
        $oQb = QB::whereLike($oInput,"website",$oQb);
        $oQb = QB::whereLike($oInput,"status",$oQb);
        $oQb = QB::whereLike($oInput,"remarks_1",$oQb);
        $oQb = QB::whereLike($oInput,"remarks_2",$oQb);
        $oQb = QB::whereLike($oInput,"remarks_3",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"city_id",$oQb);
        $oQb = QB::where($oInput,"country_id",$oQb);
        
        $oCompanyBranches = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Company Branch"]), $oCompanyBranches, false);
        $this->urlRec(26, 0, $oResponse);
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
            'address_1'   => 'nullable|max:200',
            'address_2'   => 'nullable|max:200',
            'address_3'=> 'nullable|max:200',
            'address_4'=> 'nullable|max:200',
            'postal_code'=> 'nullable|max:6',
            'state_region' => 'nullable|max:30',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'company_id' => 'required|exists:companies,id',
            'phone_1' => 'nullable|max:15',
            'phone_2' => 'nullable|max:15',
            'phone_3' => 'nullable|max:15',
            'fax_1' => 'nullable|max:15',
            'fax_2' => 'nullable|max:15',
            'fax_3' => 'nullable|max:15',
            'email' => 'nullable|max:15',
            'website' => 'nullable|max:50',
            'status' => 'nullable|max:6',
            'remarks_1' => 'nullable|max:200',
            'remarks_2' => 'nullable|max:200',
            'remarks_3' => 'nullable|max:200',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oCompanyBranch = CompanyBranch::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'en_manager_name'=>  $oInput['en_manager_name'],
            'ar_manager_name'=>  $oInput['ar_manager_name'],
            'address_1'      =>  $oInput['address_1'],
            'address_2'      =>  $oInput['address_2'],
            'address_3'      =>  $oInput['address_3'],
            'address_4'      =>  $oInput['address_4'],
            'postal_code'    =>  $oInput['postal_code'],
            'state_region'   =>  $oInput['state_region'],
            'country_id'    =>  $oInput['country_id'],
            'city_id'       =>  $oInput['city_id'],
            'company_id'    =>  $oInput['company_id'],
            'phone_1'       =>  $oInput['phone_1'],
            'phone_2'       =>  $oInput['phone_2'],
            'phone_3'       =>  $oInput['phone_3'],
            'fax_1'         =>  $oInput['fax_1'],
            'fax_2'         =>  $oInput['fax_2'],
            'fax_3'         =>  $oInput['fax_3'],
            'email'         =>  $oInput['email'],
            'website'       =>  $oInput['website'],
            'status'        =>  $oInput['status'],
            'remarks_1'     =>  $oInput['remarks_1'],
            'remarks_2'     =>  $oInput['remarks_2'],
            'remarks_3'     =>  $oInput['remarks_3'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oCompanyBranch= CompanyBranch::with(['companyId','countryId','cityId','createdBy','updatedBy','deletedBy'])->findOrFail($oCompanyBranch->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Company Branch"]), $oCompanyBranch, false);
        $this->urlRec(26, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oCompanyBranch= CompanyBranch::with(['companyId','countryId','cityId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Company Branch"]), $oCompanyBranch, false);
        $this->urlRec(26, 2, $oResponse);
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
            'address_1'   => 'nullable|max:200',
            'address_2'   => 'nullable|max:200',
            'address_3'=> 'nullable|max:200',
            'address_4'=> 'nullable|max:200',
            'postal_code'=> 'nullable|max:6',
            'state_region' => 'nullable|max:30',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'company_id' => 'required|exists:companies,id',
            'phone_1' => 'nullable|max:15',
            'phone_2' => 'nullable|max:15',
            'phone_3' => 'nullable|max:15',
            'fax_1' => 'nullable|max:15',
            'fax_2' => 'nullable|max:15',
            'fax_3' => 'nullable|max:15',
            'email' => 'nullable|max:15',
            'website' => 'nullable|max:50',
            'status' => 'nullable|max:6',
            'remarks_1' => 'nullable|max:200',
            'remarks_2' => 'nullable|max:200',
            'remarks_3' => 'nullable|max:200',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oCompanyBranch = CompanyBranch::findOrFail($id); 

        $oCompanyBranches = $oCompanyBranch->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'en_manager_name'=>  $oInput['en_manager_name'],
            'ar_manager_name'=>  $oInput['ar_manager_name'],
            'address_1'      =>  $oInput['address_1'],
            'address_2'      =>  $oInput['address_2'],
            'address_3'      =>  $oInput['address_3'],
            'address_4'      =>  $oInput['address_4'],
            'postal_code'    =>  $oInput['postal_code'],
            'state_region'   =>  $oInput['state_region'],
            'country_id'    =>  $oInput['country_id'],
            'city_id'       =>  $oInput['city_id'],
            'company_id'    =>  $oInput['company_id'],
            'phone_1'       =>  $oInput['phone_1'],
            'phone_2'       =>  $oInput['phone_2'],
            'phone_3'       =>  $oInput['phone_3'],
            'fax_1'         =>  $oInput['fax_1'],
            'fax_2'         =>  $oInput['fax_2'],
            'fax_3'         =>  $oInput['fax_3'],
            'email'         =>  $oInput['email'],
            'website'       =>  $oInput['website'],
            'status'        =>  $oInput['status'],
            'remarks_1'     =>  $oInput['remarks_1'],
            'remarks_2'     =>  $oInput['remarks_2'],
            'remarks_3'     =>  $oInput['remarks_3'],
            'updated_by'        =>  Auth::user()->id,
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);
        $oCompanyBranch = CompanyBranch::with(['companyId','countryId','cityId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Company Branch"]), $oCompanyBranch, false);
        
        $this->urlRec(26, 3, $oResponse);
        
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
                $oCompanyBranch = CompanyBranch::find($id);
                $oCompanyBranch->update(['deleted_by'=>Auth::user()->id]);
                if($oCompanyBranch){
                    $oCompanyBranch->delete();
                }
            }
        }else{
            $oCompanyBranch = CompanyBranch::findOrFail($aIds);
            $oCompanyBranch->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Company Branch"]));
        $this->urlRec(26, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oCompanyBranch = CompanyBranch::onlyTrashed()->with(['companyId','countryId','cityId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Company Branch"]), $oCompanyBranch, false);
        $this->urlRec(26, 5, $oResponse); 
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
                
                $oCompanyBranch = CompanyBranch::onlyTrashed()->find($id);
                if($oCompanyBranch){
                    $oCompanyBranch->restore();
                }
            }
        }else{
            $oCompanyBranch = CompanyBranch::onlyTrashed()->findOrFail($aIds);
            $oCompanyBranch->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Company Branch"]));
        $this->urlRec(26, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oCompanyBranch = CompanyBranch::onlyTrashed()->findOrFail($id);
        
        $oCompanyBranch->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Company Branch"]));
        $this->urlRec(26, 7, $oResponse);
        return $oResponse;
    }
}
