<?php

namespace App\Http\Controllers;

use App\Models\CompanyBank;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class CompanyBankController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the CompanyBankes
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = CompanyBank::with(['companyId','countryId','cityId','branchId','currencyId','createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"account_type",$oQb);
        $oQb = QB::whereLike($oInput,"account_no",$oQb);
        $oQb = QB::whereLike($oInput,"address_1",$oQb);
        $oQb = QB::whereLike($oInput,"address_2",$oQb);
        $oQb = QB::whereLike($oInput,"address_3",$oQb);
        $oQb = QB::whereLike($oInput,"address_4",$oQb);
        $oQb = QB::whereLike($oInput,"gl_acct_code",$oQb);
        $oQb = QB::whereLike($oInput,"bank_code",$oQb);
        $oQb = QB::whereLike($oInput,"bank_file",$oQb);
        $oQb = QB::whereLike($oInput,"payment_type",$oQb);
        $oQb = QB::whereLike($oInput,"branch_id",$oQb);
        $oQb = QB::whereLike($oInput,"currency_id",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"city_id",$oQb);
        $oQb = QB::where($oInput,"country_id",$oQb);
        
        $oCompanyBankes = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Company Bank"]), $oCompanyBankes, false);
        $this->urlRec(30, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'account_type'   => 'required|max:50',
            'account_no'   => 'required|max:50',
            'address_1'   => 'nullable|max:200',
            'address_2'   => 'nullable|max:200',
            'address_3'=> 'nullable|max:200',
            'address_4'=> 'nullable|max:200',
            'gl_acct_code'=> 'nullable|max:50',
            'bank_code' => 'nullable|max:30',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'company_id' => 'required|exists:companies,id',
            'bank_file' => 'nullable|max:30',
            'payment_type' => 'nullable|max:30',
            'branch_id' => 'required|exists:company_branches,id',
            'currency_id' => 'required|exists:currency_types,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oCompanyBank = CompanyBank::create([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'account_type'  =>  $oInput['account_type'],
            'account_no'    =>  $oInput['account_no'],
            'address_1'     =>  $oInput['address_1'],
            'address_2'     =>  $oInput['address_2'],
            'address_3'     =>  $oInput['address_3'],
            'address_4'     =>  $oInput['address_4'],
            'gl_acct_code'  =>  $oInput['gl_acct_code'],
            'bank_code'     =>  $oInput['bank_code'],
            'country_id'    =>  $oInput['country_id'],
            'city_id'       =>  $oInput['city_id'],
            'company_id'    =>  $oInput['company_id'],
            'bank_file'     =>  $oInput['bank_file'],
            'payment_type'  =>  $oInput['payment_type'],
            'branch_id'     =>  $oInput['branch_id'],
            'currency_id'   =>  $oInput['currency_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oCompanyBank= CompanyBank::with(['companyId','countryId','cityId','branchId','currencyId','createdBy','updatedBy','deletedBy'])->findOrFail($oCompanyBank->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Company Bank"]), $oCompanyBank, false);
        $this->urlRec(30, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oCompanyBank= CompanyBank::with(['companyId','countryId','cityId','branchId','currencyId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Company Bank"]), $oCompanyBank, false);
        $this->urlRec(30, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'account_type'   => 'required|max:50',
            'account_no'   => 'required|max:50',
            'address_1'   => 'nullable|max:200',
            'address_2'   => 'nullable|max:200',
            'address_3'=> 'nullable|max:200',
            'address_4'=> 'nullable|max:200',
            'gl_acct_code'=> 'nullable|max:50',
            'bank_code' => 'nullable|max:30',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'company_id' => 'required|exists:companies,id',
            'bank_file' => 'nullable|max:30',
            'payment_type' => 'nullable|max:30',
            'branch_id' => 'required|exists:company_branches,id',
            'currency_id' => 'required|exists:currency_types,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oCompanyBank = CompanyBank::findOrFail($id); 

        $oCompanyBankes = $oCompanyBank->update([
            'en_name'       =>  $oInput['en_name'],
            'ar_name'       =>  $oInput['ar_name'],
            'account_type'  =>  $oInput['account_type'],
            'account_no'    =>  $oInput['account_no'],
            'address_1'     =>  $oInput['address_1'],
            'address_2'     =>  $oInput['address_2'],
            'address_3'     =>  $oInput['address_3'],
            'address_4'     =>  $oInput['address_4'],
            'gl_acct_code'  =>  $oInput['gl_acct_code'],
            'bank_code'     =>  $oInput['bank_code'],
            'country_id'    =>  $oInput['country_id'],
            'city_id'       =>  $oInput['city_id'],
            'company_id'    =>  $oInput['company_id'],
            'bank_file'     =>  $oInput['bank_file'],
            'payment_type'  =>  $oInput['payment_type'],
            'branch_id'     =>  $oInput['branch_id'],
            'currency_id'   =>  $oInput['currency_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oCompanyBank = CompanyBank::with(['companyId','countryId','cityId','branchId','currencyId','createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Company Bank"]), $oCompanyBank, false);
        
        $this->urlRec(30, 3, $oResponse);
        
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
                $oCompanyBank = CompanyBank::find($id);
                $oCompanyBank->update(['deleted_by'=>Auth::user()->id]);
                if($oCompanyBank){
                    $oCompanyBank->delete();
                }
            }
        }else{
            $oCompanyBank = CompanyBank::findOrFail($aIds);
            $oCompanyBank->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Company Bank"]));
        $this->urlRec(30, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oCompanyBank = CompanyBank::onlyTrashed()->with(['companyId','countryId','cityId','branchId','currencyId','createdBy','updatedBy','deletedBy'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Company Bank"]), $oCompanyBank, false);
        $this->urlRec(30, 5, $oResponse); 
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
                
                $oCompanyBank = CompanyBank::onlyTrashed()->find($id);
                if($oCompanyBank){
                    $oCompanyBank->restore();
                }
            }
        }else{
            $oCompanyBank = CompanyBank::onlyTrashed()->findOrFail($aIds);
            $oCompanyBank->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Company Bank"]));
        $this->urlRec(30, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oCompanyBank = CompanyBank::onlyTrashed()->findOrFail($id);
        
        $oCompanyBank->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Company Bank"]));
        $this->urlRec(30, 7, $oResponse);
        return $oResponse;
    }
}
