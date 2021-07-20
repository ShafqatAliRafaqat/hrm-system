<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocumentPath;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\FileHelper;

class EmployeeDocumentPathController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeDocumentPath
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeDocumentPath::with(['employeeId','employeeDocumentId','documentTypeId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"document_no",$oQb);
        $oQb = QB::whereLike($oInput,"document_file_name",$oQb);
        $oQb = QB::whereLike($oInput,"document_type",$oQb);
        $oQb = QB::whereLike($oInput,"path",$oQb);
        $oQb = QB::where($oInput,"document_type_id",$oQb);
        $oQb = QB::where($oInput,"employee_document_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeDocumentPath = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Document Path"]), $oEmployeeDocumentPath, false);
        $this->urlRec(58, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'document_no'   => 'nullable|max:20',
            'document_file_name'   => 'nullable|max:50',
            'document_type'   => 'nullable|max:50',
            'document_type_id' => 'required|exists:document_types,id',
            'employee_document_id' => 'required|exists:employee_documents,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        if(isset($request->path)){
            $pathExtension = $request->path->extension();
            if($pathExtension != "png" && $pathExtension != "jpg" && $pathExtension != "jpeg"){
                abort(400,"The path must be a file of type: jpeg, jpg, png.");
            }
            $oPaths = FileHelper::saveImages($request->path,'employee_document');
        }

        $oEmployeeDocumentPath = EmployeeDocumentPath::create([
            'document_no' =>  $oInput['document_no'],
            'document_file_name' =>  $oInput['document_file_name'],
            'document_type'=>  $oInput['document_type'],
            'path'=>  isset($oPaths)? $oPaths : '',
            'document_type_id'   =>  $oInput['document_type_id'],
            'employee_document_id'   =>  $oInput['employee_document_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeDocumentPath= EmployeeDocumentPath::with(['employeeId','employeeDocumentId','documentTypeId','createdBy','updatedBy'])->findOrFail($oEmployeeDocumentPath->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Document Path"]), $oEmployeeDocumentPath, false);
        $this->urlRec(58, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeDocumentPath= EmployeeDocumentPath::with(['employeeId','employeeDocumentId','documentTypeId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Document Path"]), $oEmployeeDocumentPath, false);
        $this->urlRec(58, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'document_no'   => 'nullable|max:20',
            'document_file_name'   => 'nullable|max:50',
            'document_type'   => 'nullable|max:50',
            'path'   => 'nullable|max:200',
            'document_type_id' => 'required|exists:document_types,id',
            'employee_document_id' => 'required|exists:employee_documents,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeDocumentPath = EmployeeDocumentPath::findOrFail($id); 
        $oPaths = $oEmployeeDocumentPath->path;
        if(isset($request->path)){

            FileHelper::deleteImages($oPaths);
            $pathExtension = $request->path->extension();
            if($pathExtension != "png" && $pathExtension != "jpg" && $pathExtension != "jpeg"){
                abort(400,"The path must be a file of type: jpeg, jpg, png.");
            }
            $oPaths = FileHelper::saveImages($request->path,'employee_document');
        }
        $oEmployeeDocumentPath = $oEmployeeDocumentPath->update([
            'document_no' =>  $oInput['document_no'],
            'document_file_name' =>  $oInput['document_file_name'],
            'document_type'=>  $oInput['document_type'],
            'path'=>  isset($oPaths)? $oPaths : '',
            'document_type_id'   =>  $oInput['document_type_id'],
            'employee_document_id'   =>  $oInput['employee_document_id'],
            'employee_id'   =>  $oInput['employee_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeDocumentPath = EmployeeDocumentPath::with(['employeeId','employeeDocumentId','documentTypeId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Document Path"]), $oEmployeeDocumentPath, false);
        
        $this->urlRec(58, 3, $oResponse);
        
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
                $oEmployeeDocumentPath = EmployeeDocumentPath::find($id);
                if($oEmployeeDocumentPath){
                    $oEmployeeDocumentPath->delete();
                }
            }
        }else{
            $oEmployeeDocumentPath = EmployeeDocumentPath::findOrFail($aIds);
            $oEmployeeDocumentPath->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Document Path"]));
        $this->urlRec(58, 4, $oResponse);
        return $oResponse;
    }
}
