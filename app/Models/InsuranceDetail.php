<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceDetail extends Model
{
    protected $fillable = [
        'assured_detail_id',
        'issuance_code',
        'team_id',
        'sales_associate_id',
        'sales_manager_id',
        'regional_manager_id',
        'sale_date',
        'classification',
        'insurance_status',
        'product_id',
        'subproduct_id',
        'source_id',
        'source_branch_id',
        'source_division_id',
        'mortgagee',
        'area_id',
        'alfc_branch_id',
        'loan_amount',
        'total_sum_insured',
        'policy_inception_date',
        'expiry_date',
        'policy_number',
        'plate_conduction_number',
        'description',
        'mode_of_payment_id',
        'ra_comments',
        'admin_assistant_remarks',
        'tracking_number',
        'mode_of_delivery',
        'policy_received_by',
        'policy_expiration_aging',
        'book_number',
        'filing_number',
        'database_remarks',
        'pid_received_date',
        'pid_status',
        'pid_completion_date',
        'verification_status',
    ];
    

    public function salesAssociate()
    {
        return $this->belongsTo(SalesAssociate::class);
    }

    public function salesManager()
    {
        return $this->belongsTo(SalesManager::class);
    }

    public function regionalManager()
    {
        return $this->belongsTo(RegionalManager::class);
    }

    public function sourceDivision()
    {
        return $this->belongsTo(SourceDivision::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function subproduct()
    {
        return $this->belongsTo(SubProduct::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function sourceBranch()
    {
        return $this->belongsTo(SourceBranch::class);
    }

    // public function ifGdfi()
    // {
    //     return $this->belongsTo(IfGdfi::class);
    // }

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

    public function collectionDetail()
    {
        return $this->hasOne(CollectionDetail::class);
    }

    public function commissionDetail()
    {
        return $this->hasOne(CommissionDetail::class);
    }

    public function paymentDetail()
    {
        return $this->hasOne(PaymentDetail::class);
    }

    public function insuranceCommissioner()
    {
        return $this->hasMany(InsuranceCommissioner::class);
    }

    public function assuredDetail()
    {
        return $this->belongsTo(AssuredDetail::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function checklistOption()
    {
        return $this->belongsTo(ChecklistOption::class);
    }

    public function arAging()
    {
        return $this->hasMany(ArAging::class);
    }
}
