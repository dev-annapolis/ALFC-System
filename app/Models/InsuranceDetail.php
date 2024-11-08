<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceDetail extends Model
{
    protected $fillable = [
        'issuance_code',
        'assured_id',
        'sales_associate_id',
        'sale_date',
        'classification',
        'insurance_type',
        'sale_status',
        'branch_manager_id',
        'legal_representative_name',
        'legal_supervisor_name',
        'assigned_atty_one',
        'assigned_atty_two',
        'collection_gm',
        'product_id',
        'subproduct_id',
        'product_type',
        'source_id',
        'source_branch_id',
        'if_gdfi_id',
        'mortgagee',
        'area_id',
        'alfc_branch_id',
        'loan_amount',
        'total_sum_insured',
        'policy_number',
        'policy_insumption_date',
        'expiry_date',
        'plate_conduction_number',
        'description',
        'policy_expiration_aging',
        'book_number',
        'filing_number',
        'pid_received_date',
        'pid_completion_date',
        'remarks',
        'mode_of_payment_id',
        'provider_id'
    ];

    public function assured()
    {
        return $this->belongsTo(Assured::class);
    }

    public function salesAssociate()
    {
        return $this->belongsTo(SalesAssociate::class);
    }

    public function branchManager()
    {
        return $this->belongsTo(BranchManager::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function subproduct()
    {
        return $this->belongsTo(Subproduct::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function sourceBranch()
    {
        return $this->belongsTo(SourceBranch::class);
    }

    public function ifGdfi()
    {
        return $this->belongsTo(IfGdfi::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function alfcBranch()
    {
        return $this->belongsTo(AlfcBranch::class);
    }

    public function modeOfPayment()
    {
        return $this->belongsTo(ModeOfPayment::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function collectionDetails()
    {
        return $this->hasOne(CollectionDetail::class);
    }

    public function commissionDetails()
    {
        return $this->hasOne(CommisionDetail::class);
    }

    public function paymentDetail()
    {
        return $this->hasOne(PaymentDetail::class);
    }
    public function assuredDetail()
    {
        return $this->hasOne(AssuredDetail::class, 'insurance_detail_id');
    }

}
