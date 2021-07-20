<?php

namespace App\Http\Controllers;

use App\Models\EmployeeModification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeModificationController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeModifications
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeModification::with(['companyId','branchId','employeeId','authorizedBy','modificationId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereDate($oInput,"date_from",$oQb);
        $oQb = QB::whereDate($oInput,"date_to",$oQb);
        $oQb = QB::whereDate($oInput,"date_from_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"date_to_hijri",$oQb);
        $oQb = QB::whereDate($oInput,"effectivity_date",$oQb);
        $oQb = QB::whereDate($oInput,"effectivity_date_hijri",$oQb);
        $oQb = QB::where($oInput,"flag",$oQb);
        $oQb = QB::whereLike($oInput,"doc_id",$oQb);
        $oQb = QB::whereLike($oInput,"subdoc_id",$oQb);
        $oQb = QB::whereLike($oInput,"contract_no",$oQb);
        $oQb = QB::whereLike($oInput,"from_value",$oQb);
        $oQb = QB::whereLike($oInput,"to_value",$oQb);
        $oQb = QB::whereLike($oInput,"en_from_info",$oQb);
        $oQb = QB::whereLike($oInput,"ar_from_info",$oQb);
        $oQb = QB::whereLike($oInput,"en_to_info",$oQb);
        $oQb = QB::whereLike($oInput,"ar_to_info",$oQb);
        $oQb = QB::whereLike($oInput,"comments",$oQb);
        $oQb = QB::where($oInput,"company_id",$oQb);
        $oQb = QB::where($oInput,"branch_id",$oQb);
        $oQb = QB::where($oInput,"modification_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeModifications = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Modification"]), $oEmployeeModifications, false);
        $this->urlRec(51, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'date_from'   => 'nullable|date',
            'date_to'   => 'nullable|date',
            'date_from_hijri'   => 'nullable|date',
            'date_to_hijri'   => 'nullable|date',
            'effectivity_date'   => 'nullable|date',
            'effectivity_date_hijri'=> 'nullable|date',
            'flag' => 'in:1,0',
            'doc_id' => 'nullable|max:10',
            'subdoc_id' => 'nullable|max:10',
            'contract_no' => 'nullable|max:20',
            'from_value' => 'nullable|max:20',
            'to_value' => 'nullable|max:20',
            'en_from_info' => 'nullable|max:200',
            'ar_from_info' => 'nullable|max:200',
            'en_to_info' => 'nullable|max:200',
            'ar_to_info' => 'nullable|max:200',
            'comments' => 'nullable|max:200',
            'authorized_by' => 'required|exists:users,id',
            'modification_id' => 'required|exists:modifications,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployeeModification = EmployeeModification::create([
            'date_from' =>  $oInput['date_from'],
            'date_to' =>  $oInput['date_to'],
            'date_from_hijri'=>  $oInput['date_from_hijri'],
            'date_to_hijri'=>  $oInput['date_to_hijri'],
            'effectivity_date'  =>  $oInput['effectivity_date'],
            'effectivity_date_hijri' =>  $oInput['effectivity_date_hijri'],
            'flag'   =>  $oInput['flag'],
            'doc_id'   =>  $oInput['doc_id'],
            'subdoc_id'   =>  $oInput['subdoc_id'],
            'contract_no'   =>  $oInput['contract_no'],
            'from_value'       =>  $oInput['from_value'],
            'to_value'  =>  $oInput['to_value'],
            'en_from_info' =>  $oInput['en_from_info'],
            'ar_from_info'=>  $oInput['ar_from_info'],
            'en_to_info' =>  $oInput['en_to_info'],
            'ar_to_info'=>  $oInput['ar_to_info'],
            'comments'=>  $oInput['comments'],
            'branch_id'     =>  $oInput['branch_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'modification_id'=>  $oInput['modification_id'],
            'company_id'    =>  $oInput['company_id'],
            'authorized_by'=>  $oInput['authorized_by'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeModification= EmployeeModification::with(['companyId','branchId','employeeId','authorizedBy','modificationId','createdBy','updatedBy'])->findOrFail($oEmployeeModification->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Modification"]), $oEmployeeModification, false);
        $this->urlRec(51, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeModification= EmployeeModification::with(['companyId','branchId','employeeId','authorizedBy','modificationId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Modification"]), $oEmployeeModification, false);
        $this->urlRec(51, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'date_from'   => 'nullable|date',
            'date_to'   => 'nullable|date',
            'date_from_hijri'   => 'nullable|date',
            'date_to_hijri'   => 'nullable|date',
            'effectivity_date'   => 'nullable|date',
            'effectivity_date_hijri'=> 'nullable|date',
            'flag' => 'in:1,0',
            'doc_id' => 'nullable|max:10',
            'subdoc_id' => 'nullable|max:10',
            'contract_no' => 'nullable|max:20',
            'from_value' => 'nullable|max:20',
            'to_value' => 'nullable|max:20',
            'en_from_info' => 'nullable|max:200',
            'ar_from_info' => 'nullable|max:200',
            'en_to_info' => 'nullable|max:200',
            'ar_to_info' => 'nullable|max:200',
            'comments' => 'nullable|max:200',
            'authorized_by' => 'required|exists:users,id',
            'modification_id' => 'required|exists:modifications,id',
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:company_branches,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeModification = EmployeeModification::findOrFail($id); 

        $oEmployeeModifications = $oEmployeeModification->update([
            'date_from' =>  $oInput['date_from'],
            'date_to' =>  $oInput['date_to'],
            'date_from_hijri'=>  $oInput['date_from_hijri'],
            'date_to_hijri'=>  $oInput['date_to_hijri'],
            'effectivity_date'  =>  $oInput['effectivity_date'],
            'effectivity_date_hijri' =>  $oInput['effectivity_date_hijri'],
            'flag'   =>  $oInput['flag'],
            'doc_id'   =>  $oInput['doc_id'],
            'subdoc_id'   =>  $oInput['subdoc_id'],
            'contract_no'   =>  $oInput['contract_no'],
            'from_value'       =>  $oInput['from_value'],
            'to_value'  =>  $oInput['to_value'],
            'en_from_info' =>  $oInput['en_from_info'],
            'ar_from_info'=>  $oInput['ar_from_info'],
            'en_to_info' =>  $oInput['en_to_info'],
            'ar_to_info'=>  $oInput['ar_to_info'],
            'comments'=>  $oInput['comments'],
            'branch_id'     =>  $oInput['branch_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'modification_id'=>  $oInput['modification_id'],
            'company_id'    =>  $oInput['company_id'],
            'authorized_by'=>  $oInput['authorized_by'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeModification = EmployeeModification::with(['companyId','branchId','employeeId','authorizedBy','modificationId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Modification"]), $oEmployeeModification, false);
        
        $this->urlRec(51, 3, $oResponse);
        
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
                $oEmployeeModification = EmployeeModification::find($id);
                if($oEmployeeModification){
                    $oEmployeeModification->delete();
                }
            }
        }else{
            $oEmployeeModification = EmployeeModification::findOrFail($aIds);
            $oEmployeeModification->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Modification"]));
        $this->urlRec(51, 4, $oResponse);
        return $oResponse;
    }
}
