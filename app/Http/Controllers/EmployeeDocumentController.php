<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeDocumentController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeDocument
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeDocument::with(['employeeId','documentTypeId','cityId','countryId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::where($oInput,"renew_flag",$oQb);
        $oQb = QB::where($oInput,"current_flag",$oQb);
        $oQb = QB::where($oInput,"visa_validity",$oQb);
        $oQb = QB::where($oInput,"validity_unit",$oQb);
        $oQb = QB::whereDate($oInput,"date_issued",$oQb);
        $oQb = QB::whereDate($oInput,"date_issued_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"date_expire",$oQb);
        $oQb = QB::whereDate($oInput,"date_expire_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"date_entry",$oQb);
        $oQb = QB::whereDate($oInput,"date_entry_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"return_date",$oQb);
        $oQb = QB::whereDate($oInput,"return_date_hijri",$oQb);
        $oQb = QB::whereLike($oInput,"dependents_no",$oQb);
        $oQb = QB::whereLike($oInput,"sponsor_no",$oQb);
        $oQb = QB::whereLike($oInput,"document_no",$oQb);
        $oQb = QB::whereLike($oInput,"port_entry",$oQb);
        $oQb = QB::whereLike($oInput,"notes",$oQb);
        $oQb = QB::whereLike($oInput,"issuing_authority",$oQb);
        $oQb = QB::whereLike($oInput,"en_description",$oQb);
        $oQb = QB::whereLike($oInput,"ar_description",$oQb);
        $oQb = QB::whereLike($oInput,"remarks",$oQb);
        $oQb = QB::where($oInput,"city_id",$oQb);
        $oQb = QB::where($oInput,"country_id",$oQb);
        $oQb = QB::where($oInput,"document_type_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeDocument = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Document"]), $oEmployeeDocument, false);
        $this->urlRec(57, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'renew_flag'   => 'nullable|in:0,1',
            'current_flag'   => 'nullable|in:0,1',
            'visa_validity'   => 'nullable|in:0,1',
            'validity_unit'   => 'nullable|in:0,1',
            'date_issued' => 'nullable|date',
            'date_issued_hijri' => 'nullable|date',
            'date_expire' => 'nullable|date',
            'date_expire_hijri' => 'nullable|date',
            'date_entry' => 'nullable|date',
            'date_entry_hijri' => 'nullable|date',
            'return_date' => 'nullable|date',
            'return_date_hijri' => 'nullable|date',
            'dependents_no' => 'nullable|max:50',
            'sponsor_no' => 'nullable|max:50',
            'document_no' => 'nullable|max:50',
            'port_entry' => 'nullable|max:200',
            'notes' => 'nullable|max:200',
            'issuing_authority' => 'nullable|max:200',
            'en_description' => 'nullable|max:500',
            'ar_description' => 'nullable|max:500',
            'remarks' => 'nullable|max:500',
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
            'document_type_id' => 'required|exists:document_types,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployeeDocument = EmployeeDocument::create([
            'renew_flag' =>  $oInput['renew_flag'],
            'current_flag' =>  $oInput['current_flag'],
            'visa_validity'=>  $oInput['visa_validity'],
            'validity_unit'=>  $oInput['validity_unit'],
            'date_issued'   =>  $oInput['date_issued'],
            'date_issued_hijri'   =>  $oInput['date_issued_hijri'],
            'date_expire'   =>  $oInput['date_expire'],
            'date_expire_hijri'=>  $oInput['date_expire_hijri'],
            'employee_id'   =>  $oInput['employee_id'],
            'date_entry'=>  $oInput['date_entry'],
            'date_entry_hijri'=>  $oInput['date_entry_hijri'],
            'return_date'=>  $oInput['return_date'],
            'return_date_hijri'=>  $oInput['return_date_hijri'],
            'dependents_no'=>  $oInput['dependents_no'],
            'sponsor_no'=>  $oInput['sponsor_no'],
            'document_no'=>  $oInput['document_no'],
            'port_entry'=>  $oInput['port_entry'],
            'notes'=>  $oInput['notes'],
            'issuing_authority'=>  $oInput['issuing_authority'],
            'en_description'=>  $oInput['en_description'],
            'ar_description'=>  $oInput['ar_description'],
            'remarks'=>  $oInput['remarks'],
            'city_id'=>  $oInput['city_id'],
            'country_id'=>  $oInput['country_id'],
            'document_type_id'=>  $oInput['document_type_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeDocument= EmployeeDocument::with(['employeeId','documentTypeId','cityId','countryId','createdBy','updatedBy'])->findOrFail($oEmployeeDocument->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Document"]), $oEmployeeDocument, false);
        $this->urlRec(57, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeDocument= EmployeeDocument::with(['employeeId','documentTypeId','cityId','countryId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Document"]), $oEmployeeDocument, false);
        $this->urlRec(57, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'renew_flag'   => 'nullable|in:0,1',
            'current_flag'   => 'nullable|in:0,1',
            'visa_validity'   => 'nullable|in:0,1',
            'validity_unit'   => 'nullable|in:0,1',
            'date_issued' => 'nullable|date',
            'date_issued_hijri' => 'nullable|date',
            'date_expire' => 'nullable|date',
            'date_expire_hijri' => 'nullable|date',
            'date_entry' => 'nullable|date',
            'date_entry_hijri' => 'nullable|date',
            'return_date' => 'nullable|date',
            'return_date_hijri' => 'nullable|date',
            'dependents_no' => 'nullable|max:50',
            'sponsor_no' => 'nullable|max:50',
            'document_no' => 'nullable|max:50',
            'port_entry' => 'nullable|max:200',
            'notes' => 'nullable|max:200',
            'issuing_authority' => 'nullable|max:200',
            'en_description' => 'nullable|max:500',
            'ar_description' => 'nullable|max:500',
            'remarks' => 'nullable|max:500',
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
            'document_type_id' => 'required|exists:document_types,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeDocument = EmployeeDocument::findOrFail($id); 

        $oEmployeeDocument = $oEmployeeDocument->update([
            'renew_flag' =>  $oInput['renew_flag'],
            'current_flag' =>  $oInput['current_flag'],
            'visa_validity'=>  $oInput['visa_validity'],
            'validity_unit'=>  $oInput['validity_unit'],
            'date_issued'   =>  $oInput['date_issued'],
            'date_issued_hijri'   =>  $oInput['date_issued_hijri'],
            'date_expire'   =>  $oInput['date_expire'],
            'date_expire_hijri'=>  $oInput['date_expire_hijri'],
            'employee_id'   =>  $oInput['employee_id'],
            'date_entry'=>  $oInput['date_entry'],
            'date_entry_hijri'=>  $oInput['date_entry_hijri'],
            'return_date'=>  $oInput['return_date'],
            'return_date_hijri'=>  $oInput['return_date_hijri'],
            'dependents_no'=>  $oInput['dependents_no'],
            'sponsor_no'=>  $oInput['sponsor_no'],
            'document_no'=>  $oInput['document_no'],
            'port_entry'=>  $oInput['port_entry'],
            'notes'=>  $oInput['notes'],
            'issuing_authority'=>  $oInput['issuing_authority'],
            'en_description'=>  $oInput['en_description'],
            'ar_description'=>  $oInput['ar_description'],
            'remarks'=>  $oInput['remarks'],
            'city_id'=>  $oInput['city_id'],
            'country_id'=>  $oInput['country_id'],
            'document_type_id'=>  $oInput['document_type_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeDocument = EmployeeDocument::with(['employeeId','documentTypeId','cityId','countryId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Document"]), $oEmployeeDocument, false);
        
        $this->urlRec(57, 3, $oResponse);
        
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
                $oEmployeeDocument = EmployeeDocument::find($id);
                if($oEmployeeDocument){
                    $oEmployeeDocument->delete();
                }
            }
        }else{
            $oEmployeeDocument = EmployeeDocument::findOrFail($aIds);
            $oEmployeeDocument->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Document"]));
        $this->urlRec(57, 4, $oResponse);
        return $oResponse;
    }
}
