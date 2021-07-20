<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\FileHelper;

class CompanyController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the Companies
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = Company::with(['createdBy','updatedBy','deletedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"en_name",$oQb);
        $oQb = QB::whereLike($oInput,"ar_name",$oQb);
        $oQb = QB::whereLike($oInput,"en_register_name",$oQb);
        $oQb = QB::whereLike($oInput,"er_register_name",$oQb);
        $oQb = QB::whereDate($oInput,"incorporation_date",$oQb);
        $oQb = QB::whereLike($oInput,"incorporation_date_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"en_type_of_business",$oQb);
        $oQb = QB::whereLike($oInput,"ar_type_of_business",$oQb);
        $oQb = QB::whereLike($oInput,"no_br",$oQb);
        
        $oCompanies = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Company"]), $oCompanies, false);
        $this->urlRec(24, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'en_register_name'   => 'required|max:100',
            'er_register_name'   => 'required|max:100',
            'incorporation_date'   => 'required|date',
            'incorporation_date_hijri'   => 'nullable|max:20',
            'en_type_of_business'=> 'required|max:20',
            'ar_type_of_business'=> 'required|max:20',
            'no_br'=> 'nullable|max:6',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        if(isset($request->logo)){
            $logoExtension = $request->logo->extension();
            if($logoExtension != "png" && $logoExtension != "jpg" && $logoExtension != "jpeg"){
                abort(400,"The logo must be a file of type: jpeg, jpg, png.");
            }
            $oPaths = FileHelper::saveImages($request->logo,'company_logo');
        }

        $oCompany = Company::create([
            'en_name'           =>  $oInput['en_name'],
            'ar_name'           =>  $oInput['ar_name'],
            'en_register_name'  =>  $oInput['en_register_name'],
            'er_register_name'  =>  $oInput['er_register_name'],
            'incorporation_date'=>  $oInput['incorporation_date'],
            'incorporation_date_hijri' =>  $oInput['incorporation_date_hijri'],
            'en_type_of_business'=>  $oInput['en_type_of_business'],
            'ar_type_of_business'=>  $oInput['ar_type_of_business'],
            'no_br'             =>  $oInput['no_br']?? 0,
            'logo'              =>  isset($oPaths)? $oPaths : '',
            'created_by'        =>  Auth::user()->id,
            'updated_by'        =>  Auth::user()->id,
            'created_at'        =>  Carbon::now()->toDateTimeString(),
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);

        $oCompany= Company::with(['createdBy','updatedBy','deletedBy'])->findOrFail($oCompany->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Company"]), $oCompany, false);
        $this->urlRec(24, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oCompany= Company::with(['createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Company"]), $oCompany, false);
        $this->urlRec(24, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'en_name'   => 'required|max:50',
            'ar_name'   => 'required|max:50',
            'en_register_name'   => 'required|max:100',
            'er_register_name'   => 'required|max:100',
            'incorporation_date'   => 'required|date',
            'incorporation_date_hijri'   => 'nullable|max:20',
            'en_type_of_business'=> 'required|max:20',
            'ar_type_of_business'=> 'required|max:20',
            'no_br'=> 'nullable|max:6',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oCompany = Company::findOrFail($id); 
        $oPaths = $oCompany->logo;
        if(isset($request->logo)){

            FileHelper::deleteImages($oPaths);
            $logoExtension = $request->logo->extension();
            if($logoExtension != "png" && $logoExtension != "jpg" && $logoExtension != "jpeg"){
                abort(400,"The logo must be a file of type: jpeg, jpg, png.");
            }
            $oPaths = FileHelper::saveImages($request->logo,'company_logo');
        }

        $oCompanys = $oCompany->update([
            'en_name'           =>  $oInput['en_name'],
            'ar_name'           =>  $oInput['ar_name'],
            'en_register_name'  =>  $oInput['en_register_name'],
            'er_register_name'  =>  $oInput['er_register_name'],
            'incorporation_date'=>  $oInput['incorporation_date'],
            'incorporation_date_hijri'=>  $oInput['incorporation_date_hijri'],
            'en_type_of_business'=>  $oInput['en_type_of_business'],
            'ar_type_of_business'=>  $oInput['ar_type_of_business'],
            'no_br'             =>  $oInput['no_br']?? 0,
            'logo'              =>  $oPaths,
            'updated_by'        =>  Auth::user()->id,
            'updated_at'        =>  Carbon::now()->toDateTimeString(),
        ]);
        $oCompany = Company::with(['createdBy','updatedBy','deletedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Company"]), $oCompany, false);
        
        $this->urlRec(24, 3, $oResponse);
        
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
                $oCompany = Company::find($id);
                $oCompany->update(['deleted_by'=>Auth::user()->id]);
                if($oCompany){
                    $oCompany->delete();
                }
            }
        }else{
            $oCompany = Company::findOrFail($aIds);
            $oCompany->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Company"]));
        $this->urlRec(24, 4, $oResponse);
        return $oResponse;
    }

    // Get soft deleted data
    public function deleted()
    {
        $oCompany = Company::onlyTrashed()->with(['city'])->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.deleted',["mod"=>"Company"]), $oCompany, false);
        $this->urlRec(24, 5, $oResponse); 
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
                
                $oCompany = Company::onlyTrashed()->find($id);
                if($oCompany){
                    $oCompany->restore();
                }
            }
        }else{
            $oCompany = Company::onlyTrashed()->findOrFail($aIds);
            $oCompany->restore();
        } 
        $oResponse = responseBuilder()->success(__('message.general.restore',["mod"=>"Company"]));
        $this->urlRec(24, 6, $oResponse);
        return $oResponse;
    }
    // Permanent Delete
    public function delete($id)
    {
        $oCompany = Company::onlyTrashed()->findOrFail($id);
        
        $oCompany->forceDelete();
        
        $oResponse = responseBuilder()->success(__('message.general.permanentDelete',["mod"=>"Company"]));
        $this->urlRec(24, 7, $oResponse);
        return $oResponse;
    }
}
