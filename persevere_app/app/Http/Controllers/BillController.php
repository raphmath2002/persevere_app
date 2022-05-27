<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Bill,User,Horse,Pension,Option};
use App\Http\Resources\{BillResource};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Auth;
use DB;

class BillController extends Controller
{
    /**
     * Show bills.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bills = Bill::all();

        return response()->json(["success" => BillResource::collection($bills)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'reference' => 'required|string|max:255',
            'due_date' => 'required|date',
            'bill_year' => 'required|integer',
            'bill_month' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new Bill instance
        $inputs = $request->all();

        // Create bill dates limits
        $bill_year = $inputs['bill_year'];
        $bill_month = $inputs['bill_month'];
        $start_month_date = Carbon::parse("$bill_year-$bill_month-01 00:00:00"); // Min limit date

        if($bill_month == 12){
            $bill_year++;
            $bill_month = 1;
        }
        else{
            $bill_month++;
        }
        $end_month_date = Carbon::parse("$bill_year-$bill_month-01 00:00:00"); // Max limit date

        $horses = Horse::where([['user_id', '=', $user->id], ['created_at', '<', $end_month_date]])->get(); // Get user horses

        $global_pricing = 0;
        $details_pricing = "";
        $horses_pensions = "";
        $horses_options = "";

        //TODO refaire horse_pension

        foreach($horses as $horse){
            // Select horse pension
            $db_request = "SELECT pn.name, pn.price, pn.description, hrs_pn.subscribe_date, hrs_pn.unsubscribe_date
                            FROM horses
                            INNER JOIN horse_pension AS hrs_pn ON (hrs_pn.horse_id = horses.id)
                            INNER JOIN pensions AS pn ON (pn.id = hrs_pn.pension_id)
                            WHERE ((hrs_pn.subscribe_date < '$end_month_date' AND (hrs_pn.unsubscribe_date >= '$start_month_date' OR hrs_pn.unsubscribe_date IS NULL)) AND (horses.id = $horse->id))
                            LIMIT 1;";
            $pension = DB::select($db_request);
            $pension = $pension[0];

            $global_pricing += $pension->price;
            if($details_pricing != ""){
                $details_pricing .= ";";
            }
            $details_pricing .= "$pension->price";
            if($horses_pensions != ""){
                $horses_pensions .= ";";
            }
            $horses_pensions .= "$horse->name|$pension->name|$pension->price|$pension->description|$pension->subscribe_date";

            // Select horse options
            $db_request = "SELECT opt.name, opt.price, opt.description, opt.option_type, hrs_opt.subscribe_date, hrs_opt.unsubscribe_date
                            FROM horses
                            INNER JOIN horse_option AS hrs_opt ON (hrs_opt.horse_id = horses.id)
                            INNER JOIN options AS opt ON (opt.id = hrs_opt.option_id)
                            WHERE (((hrs_opt.subscribe_date < '$end_month_date' AND (hrs_opt.unsubscribe_date >= '$start_month_date' OR hrs_opt.unsubscribe_date IS NULL) AND opt.option_type = 'monthly') OR (hrs_opt.subscribe_date >= '$start_month_date' AND hrs_opt.subscribe_date < '$end_month_date' AND opt.option_type = 'punctual')) AND (horses.id = $horse->id));";
            $options = DB::select($db_request);

            foreach($options as $option){
                $global_pricing += $option->price;
                if($details_pricing != ""){
                    $details_pricing .= ";";
                }
                $details_pricing .= "$option->price";
                if($horses_options != ""){
                    $horses_options .= ";";
                }
                $horses_options .= "$horse->name|$option->name|$option->price|$option->description|$option->subscribe_date";
            }
        }

        $bill = new Bill();
        $bill->reference = $inputs['reference'];
        $bill->due_date = $inputs['due_date'];
        $bill->global_pricing = $global_pricing;
        $bill->details_pricing = $details_pricing;
        $bill->horses_pensions = $horses_pensions;
        $bill->horses_options = $horses_options;
        $bill->user_id = $user->id;
        $bill->save();

        return response()->json(["success" => new BillResource($bill)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        $bill->delete();

        return response()->json(["success" => "Facture supprimée avec succès !"]);
    }
}
