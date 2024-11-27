<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceDetail extends Model
{
    protected $fillable = [
        'assured_detail_id',
        'issuance_code',
        'sale_date',
        'classification',
        'insurance_status',
        'team_id',
        'sales_associate_id',
        'sales_manager_id',
        'book_number',
        'filing_number',
        'database_remarks',
        'pid_received_date',
        'pid_completion_date',
        'pid_status',
        'provider_id',
        'product_id',
        'subproduct_id',
        'product_type',
        'source_id',
        'source_branch_id',
        'if_gdfi_id',
        'mortgagee',
        'area_id',
        'alfc_branch_id',
        'policy_number',
        'plate_conduction_number',
        'description',
        'policy_inception_date',
        'expiry_date',
        'mode_of_payment_id',
        'loan_amount',
        'total_sum_insured',
        'policy_expiration_aging',
        'ra_comments',
        'admin_assistant_remarks',
        'tracking_number',
        'policy_received_by',
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

    public function provider()
    {
        return $this->belongsTo(Provider::class);
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
}
