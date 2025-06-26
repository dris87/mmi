<?php

namespace App\Http\Livewire;

use App\Models\Factories\CandidateFactory;
use App\Models\Factories\CityFactory;
use App\Models\Factories\PostalCodeFactory;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class JobSearch extends Component
{
    use WithPagination;

    public $searchByLocation = '';
    public $types = [];
    public $category = '';
    public $salaryFrom = '';
    public $salaryTo = '';
    public $title = '';
    public $skill = '';
    public $searchByCity = '';
    public $gender = '';
    public $type = '';
    public $careerLevel = '';
    public $functionalArea = '';
    public $company = '';
    public $language = '';
    public $shift = '';
    public $requiredDegreeLevels = '';
    public $jobExperience = '';
    public $maxDistance = null;

    private $perPage = 10;

    protected $listeners = ['changeFilter', 'resetFilter'];

    public function paginationView()
    {
        return 'livewire.custom-pagination-company';
    }

    public function mount(Request $request)
    {

        if (! empty($request->get('keywords'))) {
            $this->searchByLocation = $request->get('keywords');
        }

        if (! empty($request->get('categories'))) {
            $this->category = explode(",",$request->get('categories'));
        }
        if (! empty($request->get('maxDistance'))) {
            $this->maxDistance = $request->get('maxDistance');
        }
    }

    public function nextPage($lastPage)
    {
        if ($this->page < $lastPage) {
            $this->page = $this->page + 1;
        }
    }

    public function previousPage()
    {
        if ($this->page > 1) {
            $this->page = $this->page - 1;
        }
    }

    public function updatingSearchByLocation()
    {
        $this->resetPage();
    }

    /**
     * @param $param
     * @param $value
     */
    public function changeFilter($param, $value)
    {
        $this->resetPage();
        $this->$param = $value;
    }

    public function resetFilter()
    {
        $this->reset();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $jobs = $this->searchJobs();
        return view('livewire.job-search', compact('jobs'));
    }

    /**
     *
     * @return MIXED
     */
    public function searchJobs()
    {

        $objUser = Auth::user();

        $home_city_postcode = null;

        if($this->maxDistance == 0 ){
            $this->maxDistance = 10000000;
        }

        if(!isset($this->homeTown) && $objUser ){
            $objUser = Auth::user();
            $objCandidate = (new CandidateFactory())->getByUser($objUser);
            if($objCandidate){
                $objPostCode = (new PostalCodeFactory())->getByCityId($objCandidate->city_id);
                if($objPostCode){
                    $home_city_postcode = $objPostCode->postal_code;
                }
            }
        }

        /** @var Job $query */

        $arrSelect = ["jobs.*"];
        if($home_city_postcode && $this->maxDistance){
            $arrSelect[]="distance_matrix.distance";
        }

        if($objUser){
            $arrSelect[]="favourite_jobs.id as is_favourite";
        }

        $query = Job::select($arrSelect)
            ->with([
            'company', 'jobShift', 'company.user', 'jobShifts', 'jobCategory',
        ])
            ->whereStatus(Job::STATUS_ACTIVE)->where('status', '!=', Job::STATUS_DRAFT)
            ->whereDate('job_expiry_date', '>=', Carbon::now()->toDateString());


        $query->when(! empty($this->category), function (Builder $q) {
            $q->join('job_assigned_categories', 'job_assigned_categories.job_id',"=","jobs.id" );
            $q->whereIn('job_assigned_categories.job_category_id', $this->category);
        });


        $query->when(! empty($this->type), function (Builder $q) {
            $q->join('job_assigned_types', 'job_assigned_types.job_id',"=","jobs.id" );
            $q->where('job_assigned_types.job_type_id', '=', $this->type);
        });

        $query->when(! empty($this->company), function (Builder $q) {
            $q->whereHas('company', function (Builder $q) {
                $q->where('company_id', '=', $this->company);
            });
        });

        $query->when(! empty($this->shift), function (Builder $q) {
            $q->whereHas('jobShifts', function (Builder $q) {
                $q->where('job_shift_id', '=', $this->shift);
            });
        });

        $query->when(! empty($this->jobExperience), function (Builder $q) {
            $q->WhereHas('jobExperienceRequirements', function (Builder $q) {
                $q->where('years', '>=',  $this->jobExperience);
            });
        });

        $query->when(! empty($this->language), function (Builder $q) {
            $q->WhereHas('jobLanguageSkillRequirements', function (Builder $q) {
                $q->where('language_id', '=',  $this->language);
            });
        });

        $query->when(! empty($this->drivingLicence), function (Builder $q) {
            $q->WhereHas('jobDrivingLicenseRequirements', function (Builder $q) {
                $q->where('driving_license_id', '=',  $this->drivingLicence);
            });
        });

        $query->when(! empty($this->requiredDegreeLevels), function (Builder $q) {
            $q->WhereHas('jobEducations', function (Builder $q) {
                $q->where('degree_level_id', '=',  $this->requiredDegreeLevels);
            });
        });

        $query->when(! empty($this->searchByCity), function (Builder $q) {
            $q->WhereHas('jobLocations.city', function (Builder $q) {
                $q->where('name', 'like', '%' . $this->searchByCity . '%');
            });
        });

        $query->when(! empty($this->searchByLocation), function (Builder $q) {
            $q->where(function (Builder $q) {
                $q->where('job_title', 'like', '%'.$this->searchByLocation.'%');

                $q->orWhereHas('company', function (Builder $q) {
                    $q->where('name', 'like', '%'.$this->searchByLocation.'%');

                })->orWhereHas('jobsSkill', function (Builder $q) {
                    $q->where('name', 'like', '%'.$this->searchByLocation.'%');
                });
            });
        });

        $query->when(! empty($this->title), function (Builder $q) {
            $q->where('job_title', 'like', '%'.$this->title.'%')
                ->orWhereHas('jobsSkill', function (Builder $q) {
                    $q->where('name', 'like', '%'.$this->title.'%');
                })
                ->orWhereHas('company.user', function (Builder $q) {
                    $q->where('first_name', 'like', '%'.$this->title.'%')
                        ->orWhere('last_name', 'like', '%'.$this->title.'%');
                });
        });

        if($objUser){
            $query->leftJoin('favourite_jobs', function($join) use ($objUser)
            {
                $join->on('favourite_jobs.job_id',"=","jobs.id");
                $join->where('favourite_jobs.user_id',intval($objUser->id));
            });
        }

        $query->where("jobs.is_suspended","!=", 1 );

        if(!isset($this->maxDistance)){
            $this->maxDistance= 10000000;
        }
        if($home_city_postcode && $this->maxDistance>0){

            $query->join("job_locations","job_locations.job_id","=","jobs.id");
            $query->join("postal_codes","postal_codes.id","=","job_locations.postcode_id");
            $query->join('distance_matrix', function ($join) use ($home_city_postcode) {
                $join->on('distance_matrix.postal_code_from', '=', 'postal_codes.postal_code');
                $join->where('distance_matrix.postal_code_to', '=', $home_city_postcode);

            });
            $query->where("distance_matrix.distance","<=", $this->maxDistance * 1000 );

        }


        if($home_city_postcode){
            $query->orderBy("distance_matrix.distance","asc");
        }

        $query->groupBy("jobs.id");

        $all = $query->paginate($this->perPage);
        $currentPage = $all->currentPage();
        $lastPage = $all->lastPage();
        if ($currentPage > $lastPage) {
            $this->page = $lastPage;
            $all = $query->paginate($this->perPage);
        }

        return $all;
    }
}
