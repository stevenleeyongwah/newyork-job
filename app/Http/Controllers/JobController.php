<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\JobPostCollaborate;
use App\Models\JobApply;
use App\Models\JobDraft;
use App\Models\Employer;
use App\Models\User;
use App\Models\Company;
use App\Models\UserSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Config;
use App\Models\Job;
use App\Models\Location;
use App\Models\Specialization;
use Illuminate\Validation\Rule;
use App\Helper\Util;
use Butschster\Head\Facades\Meta;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function __construct()
    {

    }

    public function jobSearch(Request $request, $slug = null)
    {
        Meta::setTitle("Job search for software developer in Singapore | " . "SoftwareJob SG");
        Meta::setDescription("Find software developer & tech jobs at a hand-picked list of Singapore's best tech companies.");

        $currentPage = $request->currentPage ?: 1;
        $keywordDisplay = "";
        $locationDisplay = "";
        $selectedLocationIdArr = [];
        $specializationDisplay = "";
        $selectedSpecializationIdArr = [];
        $jobTypeDisplay = "";
        $selectedJobTypeArr = [];
        $remoteWorkDisplay = "";
        $selectedRemoteWorkArr = [];

        $jobTypes = Config::get('constant.jobType');

        $remoteWorks = Config::get('constant.remoteWork');

        if (!empty($slug)) {
            $selectedSpecialization = explode("-job-in-singapore", $slug);
            $specializationBuilder = Specialization::query();
            $specializationBuilder->where('name', 'like', '%'.$selectedSpecialization[0].'%');
            $specialization = $specializationBuilder->first();
            array_push($selectedSpecializationIdArr, $specialization->id);
            $specializationDisplay = $specialization->name;

            Meta::setTitle($specializationDisplay . " job in Singapore | " . "SoftwareJob SG");
            Meta::setDescription("Explore top " . $specializationDisplay . " jobs in Singapore. Looking for a job in Singapore for ". $specializationDisplay ."? Check out for hand-picked opportunities at top companies.");
        } else {
            if (!empty($request->keyword)) {
                $keywordDisplay = $request->keyword;
            }

            if (!empty($request->location)) {
                $selectedLocationIdArr = explode(',', $request->location);
                $locationBuilder = Location::query();
                $locationBuilder->whereIn('id', $selectedLocationIdArr);
                $locationArr = $locationBuilder->get();

                for ($i = 0; $i < count($locationArr) ; $i++) {
                    $locationDisplay = $locationDisplay . $locationArr[$i]->name;

                    if ($i < (count($locationArr) - 1)) {
                        $locationDisplay = $locationDisplay . ", ";
                    }
                }
            }

            if (!empty($request->specialization)) {
                $selectedSpecializationIdArr = explode(',', $request->specialization);
                $specializationBuilder = Specialization::query();
                $specializationBuilder->whereIn('id', $selectedSpecializationIdArr);
                $specializationArr = $specializationBuilder->get();

                for ($i = 0; $i < count($specializationArr) ; $i++) {
                    $specializationDisplay = $specializationDisplay . $specializationArr[$i]->name;

                    if ($i < (count($specializationArr) - 1)) {
                        $specializationDisplay = $specializationDisplay . ", ";
                    }
                }
            }

            if (!empty($request->jobType)) {
                $selectedJobTypeArr = explode(',', $request->jobType);

                for ($i = 0; $i < count($jobTypes) ; $i++) {
                    $jobTypeDisplay = $jobTypeDisplay . $jobTypes[$i];

                    if ($i < (count($jobTypes) - 1)) {
                        $jobTypeDisplay = $jobTypeDisplay . ", ";
                    }
                }
            }

            if (!empty($request->remoteWork)) {
                $selectedRemoteWorkArr = explode(',', $request->remoteWork);

                for ($i = 0; $i < count($remoteWorks) ; $i++) {
                    $remoteWorkDisplay = $remoteWorkDisplay . $remoteWorks[$i];

                    if ($i < (count($remoteWorks) - 1)) {
                        $remoteWorkDisplay = $remoteWorkDisplay . ", ";
                    }
                }
            }
        }

        $jobBuilder = Job::query();
        if ($request->keyword) {
            $jobBuilder->where('title', 'like', '%' . $request->keyword . '%');
        }
        if (!empty($selectedSpecializationIdArr) && count($selectedSpecializationIdArr) > 0) {
            $jobBuilder->whereIn('specialization_id', $selectedSpecializationIdArr);
        }

        $jobs = $jobBuilder->orderBy('posted_at', 'DESC')->paginate(30, ['*'], 'page', $currentPage);
        // dump($jobs);die;
        $specialization = Specialization::query();
        $specializations = $specialization->get();

        $location = Location::query();
        $locations = $location->get();

        // $html = view('job.listCard', [ 'jobs' => $jobs ])->render();

        // return [
        //     'html' => $html
        // ];


        return view('job.index', [
            'jobs' => $jobs,
            'locations' => $locations,
            'specializations' => $specializations,
            'jobTypes' => $jobTypes,
            'remoteWorks' => $remoteWorks,
            'selectedSpecializationIdArr' => $selectedSpecializationIdArr,
            'specializationDisplay' => $specializationDisplay,
            'selectedLocationIdArr' => $selectedLocationIdArr,
            'locationDisplay' => $locationDisplay,
            'keywordDisplay' => $keywordDisplay,
            'selectedJobTypeArr' => $selectedJobTypeArr,
            'jobTypeDisplay' => $jobTypeDisplay,
            'selectedRemoteWorkArr' => $selectedRemoteWorkArr,
            'remoteWorkDisplay' => $remoteWorkDisplay,
        ]);   
    }

    public function view($id, $title)
    {
        /**
         * Construct query
         */
        $jobBuilder = Job::query();

        $jobBuilder->where('id', $id);

        $job = $jobBuilder->first();

        Meta::setTitle($job->title . " | " . $job->company . " | SoftwareJob SG");
        Meta::setDescription("Explore jobs at " . $job->company . " in Singapore. Looking for a job in Singapore for? Check out for hand-picked opportunities at top companies.");

        return view('job.view', [ "job" => $job, "employmentType" => $employmentType ]);
    }

    public function getJobById($id)
    {
        /**
         * Construct query
         */
        $jobBuilder = Job::query();

        $jobBuilder->where('id', $id);

        $job = $jobBuilder->first();

        $html = view('job.selected', [ 'job' => $job ])->render();

        return [
            'html' => $html
        ];
    }

    public function create(Request $request)
    {
        $specialization = Specialization::query();
        $specializations = $specialization->get();

        $location = Location::query();
        $locations = $location->get();

        $jobTypes = Config::get('constant.jobType');

        $remoteWorks = Config::get('constant.remoteWork');

        /**
         * Construct query
         */
        return view('employer.job.create', [ 
            'locations' => $locations,
            'specializations' => $specializations,
            'jobTypes' => $jobTypes,
            'remoteWorks' => $remoteWorks
        ]);
    }

    public function edit(Request $request, $id)
    {
        $jobBuilder = Job::query();

        $jobBuilder->where('id', $id);

        $job = $jobBuilder->first();

        $specialization = Specialization::query();
        $specializations = $specialization->get();

        $location = Location::query();
        $locations = $location->get();

        $jobTypes = Config::get('constant.jobType');

        $remoteWorks = Config::get('constant.remoteWork');

        /**
         * Construct query
         */
        return view('employer.job.edit', [ 
            'locations' => $locations,
            'specializations' => $specializations,
            'jobTypes' => $jobTypes,
            'remoteWorks' => $remoteWorks,
            'job' => $job
        ]);
    }

    public function postCreate(Request $request)
    {
        /**
         * Get user
         */ 
        $employer 	= Auth::user();

        if ($employer === null) {
            return response()->json([
                'error' => 'Employer not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'                   => 'required|string',
            'job_type'                => ['required', Rule::in(Config::get('constant.jobType'))],
            // 'position'                => ['required', Rule::in(Config::get('constant.position'))],
            // 'experience'              => ['required', Rule::in(Config::get('constant.experience'))],
            'location_id'             => ['required', 'exists:location,id'],
            'specialization_id'             => ['required', 'exists:specialization,id'],
            // 'qualification'           => ['required', Rule::in(Config::get('constant.qualification'))],
            // 'salary_currency'         => ['required', Rule::in($this->countryManager->getCurrency())],
            'salary_min'              => 'numeric|gte:0|nullable',
            'salary_max'              => 'numeric|gte:0|nullable',
            'description'             => 'required|string',
        ],
        [
            'required' => 'The :attribute is required.'
        ]);

        if ($validator->fails()) {

            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $job = Job::create([
            'title'                   => $request->title,
            'type'                    => $request->job_type,
            'employer_id'             => $employer->id,
            'company_id'              => 1,
            // 'position'                => $request->job_type,
            // 'experience'              => ['required', Rule::in(Config::get('constant.experience'))],
            'location_id'             => $request->location_id,
            'specialization_id'       => $request->specialization_id,
            // 'qualification'           => ['required', Rule::in(Config::get('constant.qualification'))],
            // 'salary_currency'         => ['required', Rule::in($this->countryManager->getCurrency())],
            'salary_min'              => $request->salary_min,
            'salary_max'              => $request->salary_max,
            'job_type'                => $request->job_type,
            'remote_work'             => $request->remote_work,
            'description'             => $request->description,
            'employer_contact'        => $request->employer_contact,
            'employer_email'          => $request->employer_email,
            'job_website'             => $request->job_website,
            'posted_at'               => Carbon::now(),
            'expiry_at'               => (Carbon::now())->addDays(30)
        ]);

        /**
         * Construct query
         */
        // return view('employer.job.index', []);
        return redirect()->route('employer_job', []);
    }

    public function update(Request $request, $id)
    {
        /**
         * Get user
         */ 
        $employer 	= Auth::user();

        if ($employer === null) {
            return response()->json([
                'error' => 'Employer not found'
            ], 404);
        }

        /**
         * Validate post request
         */
        $validator = Validator::make($request->all(), [
            'title'                   => 'required|string',
            'job_type'                => ['required', Rule::in(Config::get('constant.jobType'))],
            'remote_work'                => ['required', Rule::in(Config::get('constant.remoteWork'))],
            // 'position'                => ['required', Rule::in(Config::get('constant.position'))],
            // 'experience'              => ['required', Rule::in(Config::get('constant.experience'))],
            'specialization_id'             => ['required', 'exists:specialization,id'],

            // 'qualification'           => ['required', Rule::in(Config::get('constant.qualification'))],
            // 'salary_currency'         => ['required', Rule::in($this->countryManager->getCurrency())],
            'salary_min'              => 'numeric|gte:0|nullable',
            'salary_max'              => 'numeric|gte:0|nullable',
            // 'salary_rate'             => ['required', Rule::in(Config::get('constant.salaryHourlyDailyMonthlyRate'))],
            // 'hide_salary'             => 'required|boolean',
            // 'description'             => 'required|string',
            'employer_contact'        => 'string|nullable',
            'employer_email'          => 'string|nullable',
            'job_website'             => 'string|nullable'
        ],
        [
            'required' => 'The :attribute is required.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        /**
         * Update
         */
        $jobBuilder = Job::query();
        $jobBuilder->where('id','=', $id);
        // $jobBuilder->where('employer_id','=', $employer->id);
        $job = $jobBuilder->first();

        if ($job === null) {
            return response()->json([
                'error' => 'Job not found'
            ], 404);
        }        

        $job->update([
            'title'                   => $request->title,
            'job_type'                    => $request->job_type,
            'remote_work'                    => $request->remote_work,
            'employer_id'             => $employer->id,
            'company_id'              => 1,
            // 'position'                => $request->job_type,
            // 'experience'              => ['required', Rule::in(Config::get('constant.experience'))],
            'location_id'             => $request->location_id,
            'specialization_id'       => $request->specialization_id,
            // 'qualification'           => ['required', Rule::in(Config::get('constant.qualification'))],
            // 'salary_currency'         => ['required', Rule::in($this->countryManager->getCurrency())],
            'salary_min'              => $request->salary_min,
            'salary_max'              => $request->salary_max,
            'description'             => $request->description,
            'employer_contact'        => $request->employer_contact,
            'employer_email'          => $request->employer_email,
            'job_website'             => $request->job_website
        ]);

        return redirect()->route('employer_job', []);
    }

    public function updateJobPostEnhance(Request $request, $id)
    {
        /**
         * Get user
         */ 
        $employer 	= Auth::user();

        if ($employer === null) {
            return response()->json([
                'error' => 'Employer not found'
            ], 404);
        }

        /**
         * Validate post request
         */
        $fields = $request->validate([
            'job_post_location'       => 'present|array',
            'whatsapp_apply'          => 'boolean|nullable',
            'job99_apply'             => 'boolean|nullable',
            'email_apply'             => 'boolean|nullable',
            'website_apply'           => 'boolean|nullable',
            'employer_phonecode'      => 'string|nullable',
            'employer_contact'        => 'string|nullable',
            'employer_email'          => 'string|nullable',
            'job_website'             => 'string|nullable'
        ]);

        /**
         * Update
         */
        $jobPostBuilder = JobPost::query();
        $jobPostBuilder->where('id','=', $id);
        $jobPostBuilder->where('employer_id','=', $employer->id);
        $jobPost = $jobPostBuilder->first();

        if ($jobPost === null) {
            return response()->json([
                'error' => 'Job post not found'
            ], 404);
        }        

        /**
         * Begin transaction
         */
        DB::beginTransaction();

        /**
         * Update job post
         */
        $jobPost->update([
            'whatsapp_apply'          => isset($fields['whatsapp_apply']) ? $fields['whatsapp_apply'] : null,
            'job99_apply'             => isset($fields['job99_apply']) ? $fields['job99_apply'] : null,
            'email_apply'             => isset($fields['email_apply']) ? $fields['email_apply'] : null,
            'website_apply'           => isset($fields['website_apply']) ? $fields['website_apply'] : null,
            'employer_phonecode'      => isset($fields['employer_phonecode']) ? $fields['employer_phonecode'] : null,
            'employer_contact'        => isset($fields['employer_contact']) ? $fields['employer_contact'] : null,
            'employer_email'          => isset($fields['employer_email']) ? $fields['employer_email'] : null,
            'job_website'             => isset($fields['job_website']) ? $fields['job_website'] : null
        ]);

        /**
         * Delete all previous job post location
         */
        JobPostLocation::where('job_post_id', $jobPost->id)->delete();

        /**
         * Insert job post location
         */
        if (!empty($fields['job_post_location'])) {
            foreach($fields['job_post_location'] as $location) {
                JobPostLocation::updateOrCreate([
                    'job_post_id' => $jobPost->id,
                    'latitude' => $location["lat"],
                    'longitude' => $location["lng"]
                ]);
            }
        }

        DB::commit();

        /**
         * Return 200
         */
        return response()->json([
            'message' => 'Success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return JobPost::destroy($id);
    }

    public function search(Request $request)
    {
        $jobBuilder = Job::query();
        $jobs = $jobBuilder->get();

        $html = view('job.listCard', [ 'jobs' => $jobs ])->render();

        return [
            'html' => $html
        ];

        /**
         * Validate request body
         */
        $fields = $request->validate([
            'key_word'      => 'string|nullable',
            'location_id'   => ['exists:location,id','nullable'],
            'specialization_id' => ['exists:specialization,id','nullable'],
            'date_posted'   => 'string|nullable',
            'salary_min'    => 'numeric|gte:0|nullable',
            'salary_max'    => 'numeric|gte:0|nullable',
            'type'          => 'string|nullable',
            'page'          => 'int|nullable',
            'slug'          => 'string|nullable',
        ]);

        /**
         * Variables
         */
        $maxPerPage = 30;
        $util = new Util();

        /**
         * Filter input
         */
        $keyWord = str_replace("(", "\(", $keyWord);
        $keyWord = str_replace(")", "\)", $keyWord);

        /**
         * Check if it is auth user or non auth user
         */
        $user = Auth::guard('user')->user();

        /**
         * Retrieve country
         */
        $countryBuilder = Country::query();
        $countryBuilder->where('name', 'like', $countryName);
        $country = $countryBuilder->first();

        if (empty($country)) {
            return response()->json([
                'error' => 'Country not found'
            ], 404);
        }

        /**
         * Check if search using slug
         */
        $industry_id = null;
        if (!empty($slug)) {
            $endSlug = explode("-", $slug);
            if (count($endSlug) > 0) {
                $endSlug = $endSlug[count($endSlug) - 1];
            }

            /**
             * Location if starts with l
             */
            if (!empty($endSlug[0]) && $endSlug[0] == "l") {
                $location_id = substr($endSlug, 1);
            }

            /**
             * Industry if starts with i
             */
            if (!empty($endSlug[0]) && $endSlug[0] == "i") {
                $industry_id = substr($endSlug, 1);
            }
        }

        /**
         * Construct query
         */
        $jobPost = JobPost::select(['id', 'title', 'country_id', 'location_id', 'company_id', 'salary_min', 'salary_max', 'hide_salary', 'salary_rate', 'salary_currency', 'posted_at'])->with(['location' => function ($query) {
            $query->select('id', 'full_name');
        }]);
        $jobPost->with(['company' => function ($query) {
            $query->select('id', 'name', 'logo', 'country_id')->with(['country' => function ($query) {
                $query->select('id', 'name');
            }]);
        }]);
        $jobPost->with(['country' => function ($query) {
            $query->select('id', 'name');
        }]);
        if ($user) {
            // Auth user
            $jobPost->withCount(['alreadyApplied' => function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            }]);
        }
        // if ($user) {
        //     // Auth user
        //     $jobPost = JobPost::with(['jobPostScreeningQuestion', 'jobPostLocation']);
        //     $jobPost->withCount(['alreadyApplied' => function ($query) use ($user) {
        //         return $query->where('user_id', $user->id);
        //     }]);
        // } else {
        //     // Non auth user
        //     $jobPost = JobPost::with(['jobPostScreeningQuestion', 'jobPostLocation']);
        // }

        if ($keyWord && is_string($keyWord)) {
            $jobPost = $jobPost->where(function($query) use ($keyWord) {
                $query->whereHas('company', function($query2) use ($keyWord) {
                    $query2->where('name', 'regexp', $keyWord);
                })->orWhere('title', 'regexp', $keyWord);
            });
        }

        $location = null;
        if ($location_id) {
            $locationBuilder = Location::query();
            $locationBuilder->where('id', $location_id);
            $locationBuilder->where('country_id', $country->id);
            $location = $locationBuilder->first();

            if (empty($location)) {
                return response()->json([
                    'error' => 'Location not found'
                ], 404);
            }

            if (!empty($location->city)) {
                /**
                 * Search based on location
                 */
                $jobPost->whereHas('location', function($q) use ($location_id) {
                    $q->where('id', $location_id);
                });
            } else if (!empty($location->state_id)) {
                /**
                 * Search based on state
                 */
                $jobPost->whereHas('location', function($q) use ($location) {
                    $q->where('state_id', $location->state_id);
                });
            } else {
                /**
                 * Search based on country
                 */
                $jobPost->where('country_id', $country->id);
            }
        } else {
            $jobPost->where('country_id', $country->id);
        }

        if ($industry && is_array($industry)) {
            $jobPost->whereHas('industry', function($q) use($industry) {
                foreach($industry as $index => $temp){
                    if ($index == 0) {
                        $q->where('name', 'LIKE', '%'.$temp.'%');
                    } else {
                        $q->orWhere('name', 'LIKE', '%'.$temp.'%');
                    }
                }
            });
        }

        if ($industry_id) {
            $jobPost = $jobPost->where('industry_id', $industry_id);
        }


        if ($type && is_array($type)) {
            $jobPost = $jobPost->whereIn('type', $type);
        }

        if ($datePosted) {
            $jobPost = $jobPost->where('posted_at', '>', Carbon::now()->subDays($datePosted));
        }

        /**
         * Handle salary min & salary max
         */
        if (is_int($salaryMin) && is_int($salaryMax)) {
            $jobPost = $jobPost->where(function($query) use ($salaryMin,$salaryMax){
                $query->orWhereBetween('salary_min', [$salaryMin, $salaryMax])
                        ->orWhereBetween('salary_max', [$salaryMin, $salaryMax])
                        ->orWhereRaw('? between salary_min and salary_max', [$salaryMin])
                        ->orWhereRaw('? between salary_min and salary_max', [$salaryMax]);
            });
        } else if (is_int($salaryMin)) {
            $jobPost = $jobPost->where('salary_max', '>=', $salaryMin);
        } else if (is_int($salaryMax)) {
            $jobPost = $jobPost->where('salary_min', '<=', $salaryMax);
        }

        /**
         * Handle salary rate
         */
        if ($salaryRate) {
            $jobPost = $jobPost->where('salary_rate', '=', $salaryRate);
        }

        /**
         * Add extra rule
         */
        $jobPost = $jobPost->where('status', JobPost::STATUS_ACTIVE);
        // $jobPost = $jobPost->whereDate('expiry_at', '>', Carbon::now()); // Carbon::now()->subMonths(2)
        $jobPost = $jobPost->orderBy('rank', 'DESC')->orderBy('posted_at', 'DESC')->paginate($maxPerPage, ['*'], 'page', $page);

        /**
         * Save search for user
         */
        if ($user && (isset($fields['key_word']) || isset($fields['location_id']) || isset($fields['industry_id']))) {
            $saveKeyWord = isset($fields['key_word']) ? $fields['key_word'] : null;
            $saveLocation = isset($fields['location_id']) ? $fields['location_id'] : null;
            $saveIndustry = isset($fields['industry_id']) ? $fields['industry_id'] : null;

            /**
             * Check if there is same search, if there is, avoid saving
             */
            $searchBuilder = UserSearch::query();
            $searchBuilder->where('user_id',$user->id);
            $searchBuilder->where('key_word', $saveKeyWord);
            $searchBuilder->where('search_location_id', $saveLocation);
            $previousSearch = $searchBuilder->orderBy('created_at', 'DESC')->limit(10)->get();

            if (count($previousSearch) <= 0) {
                $search = new UserSearch;

                $search->user_id    = $user->id;
                $search->key_word   = $saveKeyWord;
                $search->search_location_id = $saveLocation;
                $search->industry   = $saveIndustry;
                $search->save();
            }
        }
        
        $jobPost = $jobPost->toArray();
        $jobPost['country'] = [
            "id" => $country->id,
            "name" => $country->name,
            "iso2" => $country->iso2
        ];
        if ($location) {
            $jobPost['location'] = $location;
        }

        /**
         * Industry
         */
        $industryBuilder = Industry::query();
        $industry = $industryBuilder->get()->pluck('name');

        $jobPost["constant"]['industry'] = $industry;

        /**
         * Language
         */
        // $languageBuilder = Language::query();
        // $language = $languageBuilder->get()->pluck('name');

        // $jobPost['language'] = $language;

        return response()->json($jobPost);
    }

    public function convertJobDraftToJobPost(Request $request)
    {
        /**
         * Variables
         */
        $employer 	= Auth::user();
        $jobDraftId = $request->jobDraftId;

        /**
         * Validate if user has enough job_post_credit
         */
        if ($employer->company->job_post_credit == 0) {
            return response()->json([
                'error' => 'Credit 0'
            ], 404);
        }

        /**
         * Validate if the job draft belongs to the user
         */
        $jobDraft = JobDraft::findOrFail($jobDraftId);

        if ($jobDraft->employer->id != $employer->id)  {
            return response()->json([
                'error' => 'Job draft does not belong to employer'
            ], 404);
        }

        /**
         * Create job post
         */
        $jobPostInitialData = array(
            "title" => $jobDraft->title,
            "employer_id" => $jobDraft->employer_id,
            "company_id" => $jobDraft->company_id,
            "type" => $jobDraft->type,
            "position" => $jobDraft->position,
            "experience" => $jobDraft->experience,
            "location_id" => $jobDraft->location_id,
            "country_id" => $jobDraft->location->country_id,
            "industry_id" => $jobDraft->industry_id,
            "qualification" => $jobDraft->qualification,
            "salary_currency" => $jobDraft->company->country->currency,
            "salary_min" => $jobDraft->salary_min,
            "salary_max" => $jobDraft->salary_max,
            "salary_rate" => $jobDraft->salary_rate,
            "hide_salary" => $jobDraft->hide_salary,
            "description" => $jobDraft->description,
            "status" => JobPost::STATUS_ACTIVE,
            'posted_at' => Carbon::now(),
            'expiry_at' => (Carbon::now())->addDays(30),
            "whatsapp_apply" => $jobDraft->whatsapp_apply,
            "job99_apply" => $jobDraft->job99_apply,
            "employer_phonecode" => $jobDraft->employer_phonecode,
            "employer_contact" => $jobDraft->employer_contact,
            "email_apply" => $jobDraft->email_apply,
            "employer_email" => $jobDraft->employer_email,
            "website_apply" => $jobDraft->website_apply,
            "job_website" => $jobDraft->job_website,
            "rank" => 2
        );

        /**
         * Begin transaction
         */
        DB::beginTransaction();

        /**
         * Create job post
         */
        $jobPost = JobPost::create($jobPostInitialData);

        /**
         * Create job post screening question
         */
        if (!empty($jobDraft->screening_question)) {
            foreach($jobDraft->screening_question as $screeningQuestion) {
                JobPostScreeningQuestion::updateOrCreate([
                    'job_post_id' => $jobPost->id,
                    'screening_question' => $screeningQuestion
                ]);
            }
        }

         /**
          * Create job post location
          */
          if (!empty($jobDraft->lat_lng)) {
            foreach($jobDraft->lat_lng as $latLng) {
                JobPostLocation::updateOrCreate([
                    'job_post_id' => $jobPost->id,
                    'latitude' => $latLng["lat"],
                    'longitude' => $latLng["lng"]
                ]);
            }
        }

        /**
         * Delete job draft
         */
        JobDraft::destroy($jobDraftId);

        /**
         * Deduct user job_post_credit
         */
        $employer->company->job_post_credit -= 1;
        $employer->company->save();

        /**
         * Commit
         */
        DB::commit();

        /**
         * Send email
         */

         /**
          * Return response
          */
        return [
            "job_post_credit" => $employer->company->job_post_credit
        ];
    }

    public function employerJobPost(Request $request)
    {
        /**
         * Get employer
         */ 
        $employer 	= Auth::user();

        if ($employer === null) {
            return response()->json([
                'error' => 'Employer not found'
            ], 404);
        }

        /** 
         * Get employer job post
         */
        if ($employer->job_post_access == Employer::JOB_POST_ACCESS_ALL) {
            $jobPostBuilder = JobPost::with(['jobApply', 'jobPostCollaborate', 'jobPostLocation']);
            $jobPostBuilder->where('company_id','=', $employer->company_id);
            $jobPost = $jobPostBuilder->orderBy('posted_at', 'desc')->get();
        } else {
            // Employer self job + collaborate job
            $jobPostBuilder = JobPost::with(['jobApply', 'jobPostCollaborate', 'jobPostLocation']);
            $jobPostBuilder->where('employer_id','=', $employer->id);
            $jobPostBuilder->orWhereJsonContains('collaborate', $employer->id);
            $jobPost = $jobPostBuilder->orderBy('posted_at', 'desc')->get();
        }

        return $jobPost;
    }

    public function employerJobPostById(Request $request, $id)
    {
        /**
         * Get user
         */ 
        $employer 	= Auth::user();

        if ($employer === null) {
            return response()->json([
                'error' => 'Employer not found'
            ], 404);
        }

        /**
         * Validate if employer can modify the job post
         */
        $jobPostBuilder = JobPost::with(['jobApply', 'jobPostCollaborate', 'jobPostScreeningQuestion', 'jobPostLocation']);
        $jobPostBuilder->where('id','=', $id);
        $jobPost = $jobPostBuilder->first();

        if ($jobPost->employer_access == false) {
            return response()->json([
                'error' => 'Employer has no right to access this job post'
            ], 401);
        }

        $jobPostManager = new JobPostManager();

        $jobPost["filter"] = [
            JobApply::STATUS_UNPROCESSED => $jobPostManager->constructTreeFilter(JobApply::STATUS_UNPROCESSED, $jobPost),
            JobApply::STATUS_INTERVIEW => $jobPostManager->constructTreeFilter(JobApply::STATUS_INTERVIEW, $jobPost),
            JobApply::STATUS_SHORTLISTED => $jobPostManager->constructTreeFilter(JobApply::STATUS_SHORTLISTED, $jobPost),
            JobApply::STATUS_UNSUITABLE => $jobPostManager->constructTreeFilter(JobApply::STATUS_UNSUITABLE, $jobPost)
        ];

        return $jobPost;
    }

    public function updateStatus(Request $request, $id)
    {
        /**
         * Validate request body
         */
        $request->validate([
            'action'      => 'string'
        ]);

        /**
         * Retrieve PUT params
         */
        $action    = $request->input('action');

        /**
         * Validate if action is valid
         */
        if (!in_array($action, ["repost", "activate", "deactivate"]))
        {
            return response()->json([
                'error' => 'Invalid action'
            ], 400);
        }

        /**
         * Get user
         */ 
        $employer 	= Auth::user();

        if ($employer === null) {
            return response()->json([
                'error' => 'Employer not found'
            ], 404);
        }

        /**
         * Validate if the job post belongs to the employer
         */
        $jobPost = JobPost::findOrFail($id);

        if ($jobPost->employer->id != $employer->id)  {
            return response()->json([
                'error' => 'You are not allow to modify this job post'
            ], 404);
        }
        
        /**
         * Create update data
         */
        if ($action == "repost") {
            /**
             * Validate if company has enough credit Update company job credit
             */
            if ($employer->company->job_post_credit <= 0) {
                return response()->json([
                    'error' => 'Insufficient job ads credit. Please top up credit to post job.'
                ], 400);
            }

            /**
             * Update company credit
             */
            $employer->company->update([
                "job_post_credit" => $employer->company->job_post_credit - 1
            ]);

            /**
             * Update job post posted_at & expiry_at
             */
            $updateData["posted_at"] = Carbon::now();
            $updateData["expiry_at"] = (Carbon::now())->addDays(30);
            $updateData["status"]    = JobPost::STATUS_ACTIVE;
        } else if ($action == "activate") {
            $updateData["status"]    = JobPost::STATUS_ACTIVE;
        } else if ($action == "deactivate") {
            $updateData["status"]    = JobPost::STATUS_INACTIVE;
        }

        /**
         * Update job post status
         */
        $jobPost->update($updateData);

        /**
         * Return job post
         */
        $jobPostBuilder = JobPost::with('jobApply');
        $jobPostBuilder->where('id','=', $id);
        $jobPost = $jobPostBuilder->first();

        return $jobPost;
    }

    public function jobPostCollaborate(Request $request, $id)
    {
        /**
         * Get user
         */ 
        $employer 	= Auth::user();

        if ($employer === null) {
            return response()->json([
                'error' => 'Employer not found'
            ], 404);
        }

        /**
         * Validate request body
         */
        $fields = $request->validate([
            'employer_id' => ['array']
        ]);

        /**
         * Validate if the job post belongs to the employer
         */
        $jobPost = JobPost::findOrFail($id);

        $finalEmployerId = [];

        if (count($fields['employer_id']) > 0) {
            foreach ($fields['employer_id'] as $employer_id) {
                // Get employer
                $employerBuilder = Employer::query();
                $employerBuilder->where('id','=', $employer_id);
                $toBeCollaborateEmployer = $employerBuilder->first();

                // Filter employer which is invalid
                if (
                    !$toBeCollaborateEmployer ||
                    $toBeCollaborateEmployer->company_id !== $jobPost->company_id ||
                    $toBeCollaborateEmployer->id === $jobPost->employer_id ||
                    $toBeCollaborateEmployer->status !== Employer::STATUS_ACTIVE
                ) {
                    continue;
                }

                array_push($finalEmployerId, $employer_id);
            }
        } else {
            $finalEmployerId = $fields['employer_id'];
        }

        /**
         * Ensure final employer id is unique
         */
        $finalEmployerId = array_unique($finalEmployerId);

        /**
         * Update job post collaborate column
         */
        JobPost::where('id', $id)->update(array('collaborate' => $finalEmployerId));

        /**
         * Return job post
         */
        $jobPostBuilder = JobPost::with('jobApply');
        $jobPostBuilder->where('id','=', $id);
        $jobPost = $jobPostBuilder->first();

        return $jobPost;
    }

    public function employerJob(Request $request)
    {
        /**
         * Validate request body
         */
        $fields = $request->validate([
            'title'         => 'string|nullable',
            'page'          => 'int|nullable'
        ]);

        /**
         * Variables
         */
        $maxPerPage = 30;

        /**
         * Retrieve GET params
         */
        $title      = isset($fields['title']) ? $fields['title'] : '';
        $page       = isset($fields['page']) ? $fields['page'] : 1;

        /**
         * Get employer
         */
        $employer 	= Auth::user();

        if ($employer === null) {
            return response()->json([
                'error' => 'Employer not found'
            ], 404);
        }

        /**
         * Construct query
         */
        $jobBuilder = Job::query();

        if ($title && is_string($title)) {
            $jobBuilder = $jobBuilder->where('title', 'regexp', $title);
        }

        /**
         * Add extra rule
         */
        $jobs = $jobBuilder->orderBy('posted_at', 'DESC')
                    ->paginate($maxPerPage, ['*'], 'page', $page);

        return view('employer.job.index', [
            'jobs' => $jobs
        ]);
    }

    public function searchJobKeyWord(Request $request)
    {
        /**
         * Request body
         */
        $keyWord = $request->get('keyWord');
        $country_id = $request->get('country_id');

        /**
         * Set variable
         */
        $limit = 6;

        /**
         * Get job post keyword
         */
        $jobPostKeyWord = [];
        $jobPostBuilder = JobPost::query();
        $jobPostBuilder->select('title');
        $jobPostBuilder->where('status', JobPost::STATUS_ACTIVE);
        $jobPostBuilder->whereDate('expiry_at', '>', Carbon::now());
        $jobPostBuilder->whereHas('location', function($q) use($country_id) {
            $q->where('country_id', $country_id);
        });
        if ($keyWord) $jobPostBuilder->where('title', 'regexp', $keyWord);
        $jobPostKeyWord = $jobPostBuilder->limit($limit)->get()->unique('title')->toArray();

        /**
         * Get company keyword
         */
        $companyKeyWord = [];
        if (count($jobPostKeyWord) < 6) {
            $limit = $limit - count($jobPostKeyWord);
            $companyBuilder = Company::query();
            $companyBuilder->select('name');
            if ($keyWord) $companyBuilder->where('name', 'regexp', $keyWord);
            $companyBuilder->where('country_id', $country_id);
            $companyKeyWord = $companyBuilder->limit($limit)->get()->toArray();
        }

        $result = array_merge($jobPostKeyWord, $companyKeyWord);

        /**
         * Return output
         */
        return $result;
    }

    public function searchCompanyJob(Request $request)
    {
        /**
         * Validate request body
         */
        $fields = $request->validate([
            'page'          => 'int|nullable',
            'key_word'      => 'string|nullable',
            'company_id'    => ['exists:company,id']
        ]);

        /**
         * Variables
         */
        $maxPerPage = 20;
        $page = isset($fields['page']) ? $fields['page'] : 1;

        /**
         * Check if it is auth user or non auth user
         */
        $user = Auth::guard('user')->user();

        /** Get company */
        $companyBuilder = Company::query();
        $companyBuilder->where('id', '=', $fields["company_id"]);
        $company = $companyBuilder->first();
    
        /**
         * Construct query
         */
        if ($user) {
            // Auth user
            $jobPostBuilder = JobPost::withCount(['alreadyApplied' => function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            }]);
        } else {
            // Non auth user
            $jobPostBuilder = JobPost::query();
        }

        if (!empty($fields['key_word'])) $jobPostBuilder->where('title', 'regexp', $fields['key_word']);

        if (!empty($fields['company_id'])) $jobPostBuilder->where('company_id', $fields['company_id']);

        /**
         * Add extra rule
         */
        $jobPostBuilder->where('status', JobPost::STATUS_ACTIVE);
        // $jobPostBuilder->whereDate('expiry_at', '>', Carbon::now());
        $jobPost = $jobPostBuilder->orderBy('posted_at', 'DESC')->paginate($maxPerPage, ['*'], 'page', $page);
        
        $jobPost = $jobPost->toArray();
        $jobPost['company'] = $company;

        return response()->json($jobPost);
    }

    public function googleForJob(Request $request)
    {
        $jobPostBuilder = JobPost::query();
        $jobPost = $jobPostBuilder->orderBy('created_at', 'DESC')->limit(5)->get();

        return view('googleForJob', ['jobPost' => $jobPost]);   
    }
}

