<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Exception;
use PhpParser\Node\Expr\AssignOp\Concat;
use PhpParser\Node\Expr\BinaryOp\Concat as BinaryOpConcat;


class LoanDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'loan_amount',
        'interest_rate_id',
        'interest_start_date',
        'loan_amount_string',
        'receive_method',
        'bank_id', 
        'maintainace_branch',
        'balance',
        'loan_status_id',
        'repayment_cycle',
        'name_on_account',
        'account_number',
        'account_type',
        'created_by',
        
        
    ];

    static function getAllLoans(){

        $loanDetails = new Collection();

        try{
            $loanDetails = DB::table('loan_details as ld')
            ->join('users','ld.user_id','=','users.id')
            ->join('interest_rates as ir','ld.interest_rate_id',"=",'ir.id')
            ->join('loan_statuses as ls','ld.loan_status_id','=','ls.id')
            ->select(
                    [
                    'ld.id as loanId',
                    DB::raw("concat(users.firstname  ,' ',users.lastname) as name"),
                    'ir.rate',
                    'ld.interest_start_date',
                    'loan_amount',
                    'receive_method',
                    'ls.status'
                    ])->get();
        }
        catch(Exception $error){
            Log::error("Error trying to roles from roles Table" . $error->getMessage());
        }
        
        return $loanDetails;

    }

    static function getLoanById($id){

        $loanDetails = new Collection();

        try{
            $loanDetails = DB::table('loan_details as ld')
            ->join('users','ld.user_id','=','users.id')
            ->join('customer_details as cd','users.id','=','cd.user_id')
            ->join('customer_employment_details as cmd','users.id','=','cmd.user_id')
            ->join('interest_rates as ir','ld.interest_rate_id',"=",'ir.id')
            ->where("ld.id",'=',"$id")
            ->select(
                    [
                    'ld.id as loanId',
                    'users.id as client_id',
                    'users.firstname',
                    'users.lastname',
                    'users.email',
                    'cd.phone_number',
                    'cd.address',
                    'cd.street_address',
                    'cd.city',
                    'cd.state as state',
                    'cd.postal as postal',
                    'cd.trn',
                    'cd.identification',
                    'cd.identification_number',
                    'cd.identification_expiration',
                    'cd.contact_person_name',
                    'cd.contact_person_address',
                    'cd.contact_person_number',
                    'cd.kinship',
                    'cd.length_of_relationship',
                    'cmd.name_of_employer',
                    'cmd.address_of_employer',
                    'cmd.position_held',
                    'cmd.tenure',
                    'ir.rate',
                    'interest_start_date',
                    'loan_amount',
                    'loan_amount_string',
                    'balance',
                    'maintainace_branch',
                    'name_on_account',
                    'account_number',
                    'account_type',
                    'loan_status_id',
                    'number_of_repayments',
                    'repayment_cycle',
                    'note',
                    'ld.updated_by',
                    'ld.created_at',
                    'ld.updated_at',
                    'receive_method'
                    ])->get();
        }
        catch(Exception $error){
            Log::error("Error trying to roles from roles Table" . $error->getMessage());
        }
        
        return $loanDetails;

    }

}
