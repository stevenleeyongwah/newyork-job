<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employer;
use App\Models\Company;
use App\Models\Location;
use App\Models\Industry;
use App\Models\Education;
use App\Models\User;
use App\Models\JobApply;
use Illuminate\Support\Facades\Auth;

class Job extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'Active';
    const STATUS_INACTIVE = 'Inactive';

    protected $table = 'job';

    protected $fillable = [
        'title',    
        'company',
        'job_type',         
        'remote_work',
        'position',
        'experience',   
        'location',   
        'qualification',
        'salary_currency',
        'salary_min',      
        'salary_max',
        'salary_rate',   
        'hide_salary',
        'description',
        'posted_at',
        'expiry_at',
        'status',
        'extend',
        'screening_question',
        'whatsapp_apply',
        'job99_apply',
        'email_apply',
        'website_apply',
        'employer_phonecode',
        'employer_contact',
        'employer_email',
        'job_website'
    ];

    protected $casts = [
        'screening_question' => 'array'
    ];

    public function employerCollaborate()
    {
        return $this->belongsToMany(Employer::class, 'job_post_collaborate')->withTimestamps();
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }

    public function jobApply() {
        return $this->hasMany('App\Models\JobApply', 'job_post_id');
    }

    public function jobApplyUnprocessed() {
        return $this->hasMany('App\Models\JobApply', 'job_post_id')->where('status', '=', JobApply::STATUS_UNPROCESSED);
    }

    public function jobApplyInterview() {
        return $this->hasMany('App\Models\JobApply', 'job_post_id')->where('status', '=', JobApply::STATUS_INTERVIEW);
    }

    public function jobApplyShortlisted() {
        return $this->hasMany('App\Models\JobApply', 'job_post_id')->where('status', '=', JobApply::STATUS_SHORTLISTED);
    }

    public function jobApplyUnsuitable() {
        return $this->hasMany('App\Models\JobApply', 'job_post_id')->where('status', '=', JobApply::STATUS_UNSUITABLE);
    }

    public function getCategoryAttribute()
    {
        return "Job";
    }

    public function getApplicantAttribute()
    {
        return $this->jobApply()->count();
    }

    public function getUnprocessedApplicantAttribute()
    {
        return $this->jobApply()->where('status', '=', JobApply::STATUS_UNPROCESSED)->count();
    }

    public function getInterviewApplicantAttribute()
    {
        return $this->jobApply()->where('status', '=', JobApply::STATUS_INTERVIEW)->count();
    }

    public function getShortlistedApplicantAttribute()
    {
        return $this->jobApply()->where('status', '=', JobApply::STATUS_SHORTLISTED)->count();
    }

    public function getUnsuitableApplicantAttribute()
    {
        return $this->jobApply()->where('status', '=', JobApply::STATUS_UNSUITABLE)->count();
    }

    public function alreadyApplied() {
        return $this->hasMany('App\Models\JobApply', 'job_post_id');
    }

    public function jobPostCollaborate() {
        return $this->hasMany('App\Models\JobPostCollaborate', 'job_post_id');
    }

    public function getEmployerAccessAttribute()
    {
        $employer = Auth::guard('employer')->user();

        if ($employer) {
            /**
             * Check if this job post is created by employer
             */
            if ($this->employer_id === $employer->id) return true;

            /**
             * Check if employer job post access status
             */
            if ($employer->job_post_access === Employer::JOB_POST_ACCESS_ALL) return true;

            /**
             * Check if there is job post collaboration with this employer
             */
            $jobPostCollaborate = $this->jobPostCollaborate()
                                        ->where('job_post_id', $this->id)
                                        ->where('employer_id', $employer->id)
                                        ->first();

            if (!empty($jobPostCollaborate)) return true;
        }

        return false;
    }

    public function jobPostScreeningQuestion() {
        return $this->hasMany('App\Models\JobPostScreeningQuestion', 'job_post_id');
    }

    public function jobPostLocation() {
        return $this->hasMany('App\Models\JobPostLocation', 'job_post_id');
    }

    public function url()
    {
        return "/" . $this->id . "/" . str_replace(' ', '-', strtolower($this->title));
    }

    public function urlTitle()
    {
        return str_replace('/', '-', str_replace(' ', '-', strtolower($this->title)));
    }

    // function getDaysLeftAttribute()
    // {
    //     $created_at = \Carbon\Carbon::parse($this->created_at);
    //     return $created_at->subDays((int)$this->duration)->diffForHumans();
    // }
}
