@extends('layouts.app')

@section('content')
  <div class='bg-blue-900 p-2.5 sticky top-0 z-10' style="">
    <div class='container justify-center mx-auto max-w-6xl'>
      <div class='grid grid-cols-4 gap-3 mb-2.5 z-5'>
        <form class="flex items-center" onsubmit="return false">   
          <label class="sr-only">Search</label>
          <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input type="text" id="keyword" value="{{ $keywordDisplay }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" />
          </div>
        </form>

        <form onsubmit="return false" class="flex items-center" data-dropdown-toggle="dropdownLocation" data-dropdown-offset-skidding="-20">
          <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg fill="none" class="w-5 h-5 text-gray-500 dark:text-gray-400" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path>
              </svg>
            </div>
            <input readonly type="text" id="simple-search" value="{{ $locationDisplay }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Locations" />
          </div>
        </form>

        <div id="dropdownLocation" class="z-10 p-3 hidden bg-white rounded-lg shadow w-60 dark:bg-gray-700">
          <ul class="h-48 overflow-y-auto text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownSearchButton">
            @foreach ($locations as $location)
              <li>
                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                  @if(in_array($location->id, $selectedLocationIdArr))
                    <input name="{{ $location->id }}" type="checkbox" checked value="" class="w-6 h-6 mr-2 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                  @else
                    <input name="{{ $location->id }}" type="checkbox" value="" class="w-6 h-6 mr-2 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                  @endif
                  <label class="w-full ml-2 text-base font-medium text-gray-900 rounded dark:text-gray-300">{{ $location->name }}</label>
                </div>
              </li>
            @endforeach
          </ul>
        </div>

        <form onsubmit="return false" class="flex items-center" data-dropdown-toggle="dropdownSpecialization" data-dropdown-offset-skidding="-20">
          <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg fill="none" class="w-5 h-5 text-gray-500 dark:text-gray-400" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"></path>
              </svg>
            </div>
            <input readonly type="text" id="simple-search" value="{{ $specializationDisplay }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Specializations" />

          </div>
        </form>

        <!-- <div id="dropdownSpecialization" class="z-10 hidden bg-white divide-gray-100 rounded-lg shadow dark:bg-gray-700 w-72">
                <ul class="h-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                  @foreach ($specializations as $specialization)
                    <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                      <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">

                        @if(in_array($specialization->id, $selectedSpecializationIdArr))
                          <input name="{{ $specialization->id }}" type="checkbox" checked value="" class="w-6 h-6 mr-2 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                        @else
                          <input name="{{ $specialization->id }}" type="checkbox" value="" class="w-6 h-6 mr-2 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                        @endif
                      </div>
                    </li>
                  @endforeach
                  <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                    <div class="flex justify-end items-center px-3">
                      <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center my-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">Apply</button>
                    </div>
                  </li>
                </ul>
              </div> -->

        <div id="dropdownSpecialization" class="z-100 p-3 hidden bg-white rounded-lg shadow w-60 dark:bg-gray-700">
          <ul class="h-48 overflow-y-auto text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownSearchButton">
            @foreach ($specializations as $specialization)
              <li>
                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                  @if(in_array($specialization->id, $selectedSpecializationIdArr))
                    <input name="{{ $specialization->id }}" type="checkbox" checked value="" class="w-6 h-6 mr-2 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                  @else
                    <input name="{{ $specialization->id }}" type="checkbox" value="" class="w-6 h-6 mr-2 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                  @endif
                  <label class="w-full ml-2 text-base font-medium text-gray-900 rounded dark:text-gray-300">{{ $specialization->name }}</label>
                </div>
              </li>
            @endforeach
          </ul>
        </div>

        <button onclick="search(1)" type="button" class="col-span-1 text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">Search</button>


        <!-- <button onclick="search()" type="button" class="col-span-1 text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">Search</button> -->
      </div>

      <div>
        <div class='flex'>

              <button data-dropdown-toggle="dropdownSalary" data-dropdown-offset-skidding="100" class="relative inline-flex items-center justify-center p-0.5 mr-2.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                  Salary
                </span>
              </button>

              <div id="dropdownSalary" class="text-center z-10 hidden bg-white divide-gray-100 rounded-lg shadow dark:bg-gray-700 p-8 w-72">
                <div><span class='font-semibold'>Monthly</span> salary range</div>
                <div><span class='font-semibold'>SGD 0</span> to <span class='font-semibold'>SGD 22K+</span></div>
              </div>

              <button data-dropdown-toggle="dropdownJobType" data-dropdown-offset-skidding="90" class="relative inline-flex items-center justify-center p-0.5 mr-2.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                  Job Type
                </span>
              </button>

              <div id="dropdownJobType" class="z-10 hidden bg-white divide-gray-100 rounded-lg shadow dark:bg-gray-700 w-72">
                <ul class="text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                  @foreach ($jobTypes as $jobType)
                    <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                      <div class="flex justify-between items-center px-3">
                        <label for="vue-checkbox" class="py-3 ml-2 text-base font-medium text-gray-900 dark:text-gray-300">{{ $jobType }}</label>
                        @if(in_array($jobType, $selectedJobTypeArr))
                          <input name="{{ $jobType }}" id="vue-checkbox" checked type="checkbox" value="" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                        @else
                          <input name="{{ $jobType }}" id="vue-checkbox" type="checkbox" value="" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                        @endif
                      </div>
                    </li>
                  @endforeach
                  <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                    <div class="flex justify-between items-center px-3">
                      <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center my-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">Cancel</button>
                      <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center my-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">Apply</button>
                    </div>
                  </li>
                </ul>
              </div>

              <button data-dropdown-toggle="dropdownRemoteWork" data-dropdown-offset-skidding="75" class="relative inline-flex items-center justify-center p-0.5 mr-2.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                  Remote Work
                </span>
              </button>

              <div id="dropdownRemoteWork" class="z-10 hidden bg-white divide-gray-100 rounded-lg shadow dark:bg-gray-700 w-72">
                <ul class="text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                  @foreach ($remoteWorks as $remoteWork)
                    <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                      <div class="flex justify-between items-center px-3">
                        <label for="vue-checkbox" class="py-3 ml-2 text-base font-medium text-gray-900 dark:text-gray-300">{{ $remoteWork }}</label>
                        @if(in_array($remoteWork, $selectedRemoteWorkArr))
                          <input name="{{ $remoteWork }}" id="vue-checkbox" checked type="checkbox" value="" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                        @else
                          <input name="{{ $remoteWork }}" id="vue-checkbox" type="checkbox" value="" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                        @endif
                      </div>
                    </li>
                  @endforeach
                  <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                    <div class="flex justify-between items-center px-3">
                      <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center my-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">Cancel</button>
                      <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center my-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">Apply</button>
                    </div>
                  </li>
                </ul>
              </div>
        </div>
      </div>
    </div>
  </div>

  <div class='container justify-center mx-auto p-2.5 max-w-6xl'>
    <div class='grid grid-cols-3 gap-4'>
      <div class='col-span-3 md:col-span-1'>
        <div role="status" class="max-w-sm animate-pulse py-4 hidden" id="job-list-card-loading">
          <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
          <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[360px] mb-2.5"></div>
          <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
          <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[330px] mb-2.5"></div>
          <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[300px] mb-2.5"></div>
          <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[360px]"></div>
          <span class="sr-only">Loading...</span>
        </div>

        <div id="job-list-card-section">
          <div class='py-2'>
            <span class='font-bold'>{{ ($jobs->currentPage()-1)*$jobs->perPage() + 1 }}-{{ ($jobs->currentPage()-1)*$jobs->perPage() + count($jobs) }}</span> of {{ $jobs->total() }} job
          </div>

          <div class='grid grid-cols-1 gap-4 mb-4' id="job-list-card">
            @foreach ($jobs as $job)
              <div class="border-l-blue-900 border-l-4 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 cursor-pointer" onclick="jobCardClick({{ $job->id }})">
                <img class="w-18 h-16 rounded mb-2" src="{{ env('AWS_S3_URL') }}/company/logo/{{ $job->company->id }}/{{ $job->company->logo }}" alt="{{ $job->company->name }}" />
                <!-- <img class="mb-2 h-auto max-h-12 rounded-lg shadow-xl dark:shadow-gray-800" src="https://image-service-cdn.seek.com.au/85a4e1443ca7c50346cc5ddd29b89d4f3ce81d14/ee4dce1061f3f616224767ad58cb2fc751b8d2dc" alt="image description" /> -->

                <div>
                  <span class="mb-2 text-xl tracking-tight hover:underline text-zinc-800	dark:text-white">{{ $job->title }}</span>
                </div>

                <div class='mb-3'>
                  <span class="text-base text-zinc-600	font-normal dark:text-gray-400 hover:underline">{{ $job->company->name }}</span>
                </div>

                <div>
                  <span class="text-base text-zinc-600 font-bold dark:text-gray-400">{{ $job->location->name }}</span>
                </div>

                @if($job->salary_min)
                  <div class='mb-3'>
                    <span class="text-base text-zinc-600 font-bold dark:text-gray-400">SGD {{ $job->salary_min }} monthly</span>
                  </div>
                @elseif($job->salary_max)
                  <div class='mb-3'>
                    <span class="text-base text-zinc-600 font-bold dark:text-gray-400">SGD {{ $job->salary_max }} monthly</span>
                  </div>
                @elseif($job->salary_min && $job->salary_max)
                  <div class='mb-3'>
                    <span class="text-base text-zinc-600 font-bold dark:text-gray-400">SGD {{ $job->salary_min }} - {{ $job->salary_max }} monthly</span>
                  </div>
                @endif

                <div>
                  <span class="text-sm text-zinc-600 dark:text-gray-400">{{ $diff = Carbon\Carbon::parse($job->posted_at)->diffForHumans() }}</span>
                </div>
              </div>
            @endforeach

            <!-- drawer component -->
            <div id="drawer-bottom-example" class="md:hidden h-5/6 fixed bottom-0 left-0 right-0 z-40 w-full p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 transform-none" tabindex="-1" aria-labelledby="drawer-bottom-label">
              <h5 id="drawer-bottom-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400"><svg class="w-5 h-5 mr-2" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>Job Detail</h5>
              <button id="close-drawer-bottom-example" type="button" aria-controls="drawer-bottom-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" >
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close menu</span>
              </button>
              <p id="job-selected-drawer" class="max-w-lg mb-6 text-sm text-gray-500 dark:text-gray-400">
                
              </p>
            </div>
          </div>

          <div class="flex justify-center mb-2">
            <button id="previousPage" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
              Previous
            </button>

            <button id="nextPage" class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
              Next
            </button>
          </div>
        </div>
      </div>

      <div class='md:block hidden col-span-2'>
        <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 sticky top-32">
          <div role="status" class="p-4 hidden" id="job-selected-card-loading">
            <div class="flex items-center justify-center h-48 mb-4 bg-gray-300 rounded dark:bg-gray-700">
                <svg class="w-12 h-12 text-gray-200 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="currentColor" viewBox="0 0 640 512"><path d="M480 80C480 35.82 515.8 0 560 0C604.2 0 640 35.82 640 80C640 124.2 604.2 160 560 160C515.8 160 480 124.2 480 80zM0 456.1C0 445.6 2.964 435.3 8.551 426.4L225.3 81.01C231.9 70.42 243.5 64 256 64C268.5 64 280.1 70.42 286.8 81.01L412.7 281.7L460.9 202.7C464.1 196.1 472.2 192 480 192C487.8 192 495 196.1 499.1 202.7L631.1 419.1C636.9 428.6 640 439.7 640 450.9C640 484.6 612.6 512 578.9 512H55.91C25.03 512 .0006 486.1 .0006 456.1L0 456.1z"/></svg>
            </div>
            <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>
            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 w-60 mb-2.5"></div>
            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
            <span class="sr-only">Loading...</span>
          </div>

          <div id="job-selected-card" class="">
            
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    var jobs = @json($jobs); currentPage = parseInt("{{ $jobs->currentPage() }}"); lastPage = parseInt("{{ $jobs->lastPage() }}"); drawer = null

    $(document).ready(function(){
      const targetEl = document.getElementById('drawer-bottom-example');
      const options = {
        placement: 'bottom',
        backdrop: true,
        bodyScrolling: false,
        edge: false,
        edgeOffset: '',
        backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-30',
        onHide: () => {

        },
        onShow: () => {

        },
        onToggle: () => {

        }
    };
      drawer = new Drawer(targetEl, options);

      drawer.hide()

      if (jobs && jobs.data && jobs.data.length > 0) {
        jobCardClick(jobs.data[0].id, true)
      }

      $("#keyword").keyup(function(event){
        if(event.keyCode == 13){
          search(currentPage)
        }
      });
    })

    $("#close-drawer-bottom-example").click(function(event){
      drawer.hide()
    });
    
    function jobCardClick(jobId, onLoad = false) {
      if ($(window).width() < 768 && onLoad == false) {
        drawer.show()
      } else {
        drawer.hide()
      }

      $("#job-selected-card-loading").removeClass("hidden");
      $("#job-selected-card").addClass("hidden");
      url = '{{ route("job_by_id", "job_id") }}'.replace('job_id', jobId)
      $.ajax({
        type: 'GET',
        url: url,
        data: null
      })
      .done( function (responseText) {
        $("#job-selected-card-loading").addClass("hidden");
        $("#job-selected-card").removeClass("hidden");
        if (responseText.html) {
          $("#job-selected-card").html(responseText.html);
          $("#job-selected-drawer").html(responseText.html);
          
        }
      })
      .fail( function (jqXHR, status, error) {
        $("#job-selected-card-loading").addClass("hidden");
        $("#job-selected-card").removeClass("hidden");
        // Triggered if response status code is NOT 200 (OK)
        console.log(jqXHR.responseText);
      })
    }

    $('#previousPage').click(function(){
      if (currentPage <= 1) {
        currentPage = 1
      } else {
        currentPage = currentPage - 1
      }
      search(currentPage)
    });

    $('#nextPage').click(function(){
      if (currentPage >= lastPage) {

      } else {
        currentPage = currentPage + 1
        search(currentPage)
      }


    });

    function search(page){
      // $("#job-list-card-section").addClass("hidden");
      // $("#job-list-card-loading").removeClass("hidden");
      // $("#job-selected-card-loading").removeClass("hidden");
      var keyword, specializationIdArr = [], locationIdArr = [], jobTypeArr = [], remoteWorkArr = []

      keyword = $('#keyword').val();

      $('#dropdownLocation input:checked').each(function() {
        locationIdArr.push($(this).attr('name'));
      })

      $('#dropdownSpecialization input:checked').each(function() {
        specializationIdArr.push($(this).attr('name'));
      })

      $('#dropdownJobType input:checked').each(function() {
        jobTypeArr.push($(this).attr('name'));
      })

      $('#dropdownRemoteWork input:checked').each(function() {
        remoteWorkArr.push($(this).attr('name'));
      })

      urlSearchParams = {}
      urlSearchParams.keyword = keyword
      urlSearchParams.currentPage = page

      if (locationIdArr.length > 0) {
        urlSearchParams.location = locationIdArr.join(",")
      }
 
      if (specializationIdArr.length > 0) {
        urlSearchParams.specialization = specializationIdArr.join(",")
      }

      if (jobTypeArr.length > 0) {
        urlSearchParams.jobType = jobTypeArr.join(",")
      }

      if (remoteWorkArr.length > 0) {
        urlSearchParams.remoteWork = remoteWorkArr.join(",")
      }

      const params = new URLSearchParams(urlSearchParams);

      window.location.href = "/job?" + params

      // urlSearchParams = {}
      // console.log("specializationIdArr: ", specializationIdArr.length)


      // url = '{{ route("job_search") }}?' + params.toString()
      // console.log(params.toString())
      // $.ajax({
      //   type: 'GET',
      //   url: url,
      //   // data: {
      //   //   "specialization": specializationIdArr.join(",")
      //   // }
      // })
      // .done( function (responseText) {
      //   $("#job-list-card-section").removeClass("hidden");
      //   $("#job-list-card-loading").addClass("hidden");
      //   $("#job-selected-card-loading").addClass("hidden");
      //   if (responseText.html) {
      //     $("#job-list-card").html(responseText.html);
      //     console.log(params)
      //     var stateObj = { foo: "bar" };
      //     history.pushState("", '', "/job?" + params.toString());
      //   }
      // })
      // .fail( function (jqXHR, status, error) {
      //   $("#job-list-card-section").removeClass("hidden");
      //   $("#job-list-card-loading").addClass("hidden");
      //   $("#job-selected-card-loading").addClass("hidden");
      //   // Triggered if response status code is NOT 200 (OK)
      //   console.log(jqXHR.responseText);
      // })

      // console.log("cha: ", remoteWorkArr)
        // axios.get('/cliente/message')
        // .then(function (response) {
        //     // handle success
        //     console.log(response);
        // })
        // .catch(function (error) {
        //     // handle error
        //     console.log(error);
        // });
    }
</script>
@endsection
