<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAddress;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\QB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeAddressController extends Controller
{
    use \App\Traits\WebServicesDoc;

    // get list of all the EmployeeAddress
   
    public function index(Request $request)
    {
        $oInput = $request->all();

        $oQb = EmployeeAddress::with(['employeeId','localCityId','homeCityId','localCountryId','homeCountryId','createdBy','updatedBy'])->orderByDesc('updated_at');
        $oQb = QB::where($oInput,"id",$oQb);
        $oQb = QB::whereLike($oInput,"local_address_1",$oQb);
        $oQb = QB::whereLike($oInput,"local_address_2",$oQb);
        $oQb = QB::whereLike($oInput,"local_address_3",$oQb);
        $oQb = QB::whereLike($oInput,"home_address_1",$oQb);
        $oQb = QB::whereLike($oInput,"home_address_2",$oQb);
        $oQb = QB::whereLike($oInput,"home_address_3",$oQb);
        $oQb = QB::whereLike($oInput,"local_postal_code",$oQb);
        $oQb = QB::whereLike($oInput,"home_postal_code",$oQb);
        $oQb = QB::whereLike($oInput,"local_phone",$oQb);
        $oQb = QB::whereLike($oInput,"home_phone",$oQb);
        $oQb = QB::whereLike($oInput,"local_telephone",$oQb);
        $oQb = QB::whereLike($oInput,"home_telephone",$oQb);
        $oQb = QB::where($oInput,"local_city_id",$oQb);
        $oQb = QB::where($oInput,"local_country_id",$oQb);
        $oQb = QB::where($oInput,"home_city_id",$oQb);
        $oQb = QB::where($oInput,"home_country_id",$oQb);
        $oQb = QB::where($oInput,"employee_id",$oQb);
        
        $oEmployeeAddress = $oQb->paginate(10);
        
        $oResponse = responseBuilder()->success(__('message.general.list',["mod"=>"Employee Address"]), $oEmployeeAddress, false);
        $this->urlRec(54, 0, $oResponse);
        return $oResponse;
    }
    // Store new country

    public function store(Request $request)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'local_address_1'   => 'nullable|max:200',
            'local_address_2'   => 'nullable|max:200',
            'local_address_3'   => 'nullable|max:200',
            'home_address_1'   => 'nullable|max:200',
            'home_address_2' => 'nullable|max:200',
            'home_address_3' => 'nullable|max:200',
            'local_postal_code' => 'nullable|max:6',
            'home_postal_code' => 'nullable|max:6',
            'local_phone' => 'nullable|max:15',
            'home_phone' => 'nullable|max:15',
            'local_telephone' => 'nullable|max:15',
            'home_telephone' => 'nullable|max:15',
            'local_city_id' => 'nullable|exists:cities,id',
            'local_country_id' => 'nullable|exists:countries,id',
            'home_city_id' => 'nullable|exists:cities,id',
            'home_country_id' => 'nullable|exists:countries,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }
        
        $oEmployeeAddress = EmployeeAddress::create([
            'local_address_1' =>  $oInput['local_address_1'],
            'local_address_2' =>  $oInput['local_address_2'],
            'local_address_3'=>  $oInput['local_address_3'],
            'home_address_1'=>  $oInput['home_address_1'],
            'home_address_2'   =>  $oInput['home_address_2'],
            'home_address_3'   =>  $oInput['home_address_3'],
            'local_postal_code'   =>  $oInput['local_postal_code'],
            'home_postal_code'=>  $oInput['home_postal_code'],
            'employee_id'   =>  $oInput['employee_id'],
            'local_phone'=>  $oInput['local_phone'],
            'home_phone'=>  $oInput['home_phone'],
            'local_telephone'=>  $oInput['local_telephone'],
            'home_telephone'=>  $oInput['home_telephone'],
            'local_city_id'=>  $oInput['local_city_id'],
            'local_country_id'=>  $oInput['local_country_id'],
            'home_city_id'=>  $oInput['home_city_id'],
            'home_country_id'=>  $oInput['home_country_id'],
            'created_by'    =>  Auth::user()->id,
            'updated_by'    =>  Auth::user()->id,
            'created_at'    =>  Carbon::now()->toDateTimeString(),
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        $oEmployeeAddress= EmployeeAddress::with(['employeeId','localCityId','homeCityId','localCountryId','homeCountryId','createdBy','updatedBy'])->findOrFail($oEmployeeAddress->id);

        $oResponse = responseBuilder()->success(__('message.general.create',["mod"=>"Employee Address"]), $oEmployeeAddress, false);
        $this->urlRec(54, 1, $oResponse);
        return $oResponse;
    }
    // Show country details

    public function show($id)
    {

        $oEmployeeAddress= EmployeeAddress::with(['employeeId','localCityId','homeCityId','localCountryId','homeCountryId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.detail',["mod"=>"Employee Address"]), $oEmployeeAddress, false);
        $this->urlRec(54, 2, $oResponse);
        return $oResponse;
    }
    // Update country details
    
    public function update(Request $request, $id)
    {
        $oInput = $request->all();

        $oValidator = Validator::make($oInput,[
            'local_address_1'   => 'nullable|max:200',
            'local_address_2'   => 'nullable|max:200',
            'local_address_3'   => 'nullable|max:200',
            'home_address_1'   => 'nullable|max:200',
            'home_address_2' => 'nullable|max:200',
            'home_address_3' => 'nullable|max:200',
            'local_postal_code' => 'nullable|max:6',
            'home_postal_code' => 'nullable|max:6',
            'local_phone' => 'nullable|max:15',
            'home_phone' => 'nullable|max:15',
            'local_telephone' => 'nullable|max:15',
            'home_telephone' => 'nullable|max:15',
            'local_city_id' => 'nullable|exists:cities,id',
            'local_country_id' => 'nullable|exists:countries,id',
            'home_city_id' => 'nullable|exists:cities,id',
            'home_country_id' => 'nullable|exists:countries,id',
            'employee_id' => 'required|exists:employees,id',
        ]);

        if($oValidator->fails()){
            return responseBuilder()->error(__($oValidator->errors()->first()), 400, false);
        }

        $oEmployeeAddress = EmployeeAddress::findOrFail($id); 

        $oEmployeeAddress = $oEmployeeAddress->update([
            'local_address_1' =>  $oInput['local_address_1'],
            'local_address_2' =>  $oInput['local_address_2'],
            'local_address_3'=>  $oInput['local_address_3'],
            'home_address_1'=>  $oInput['home_address_1'],
            'home_address_2'   =>  $oInput['home_address_2'],
            'home_address_3'   =>  $oInput['home_address_3'],
            'local_postal_code'   =>  $oInput['local_postal_code'],
            'home_postal_code'=>  $oInput['home_postal_code'],
            'employee_id'   =>  $oInput['employee_id'],
            'local_phone'=>  $oInput['local_phone'],
            'home_phone'=>  $oInput['home_phone'],
            'local_telephone'=>  $oInput['local_telephone'],
            'home_telephone'=>  $oInput['home_telephone'],
            'local_city_id'=>  $oInput['local_city_id'],
            'local_country_id'=>  $oInput['local_country_id'],
            'home_city_id'=>  $oInput['home_city_id'],
            'home_country_id'=>  $oInput['home_country_id'],
            'updated_by'    =>  Auth::user()->id,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ]);
        $oEmployeeAddress = EmployeeAddress::with(['employeeId','localCityId','homeCityId','localCountryId','homeCountryId','createdBy','updatedBy'])->findOrFail($id);

        $oResponse = responseBuilder()->success(__('message.general.update',["mod"=>"Employee Address"]), $oEmployeeAddress, false);
        
        $this->urlRec(54, 3, $oResponse);
        
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
                $oEmployeeAddress = EmployeeAddress::find($id);
                if($oEmployeeAddress){
                    $oEmployeeAddress->delete();
                }
            }
        }else{
            $oEmployeeAddress = EmployeeAddress::findOrFail($aIds);
            $oEmployeeAddress->delete();
        }
        
        $oResponse = responseBuilder()->success(__('message.general.delete',["mod"=>"Employee Address"]));
        $this->urlRec(54, 4, $oResponse);
        return $oResponse;
    }
}
