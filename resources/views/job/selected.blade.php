<div class="p-4 flex">
  @if ($job->employer_email)
    <a target="_blank" href="{{ $job->employer_email }}">
      <button type="button" class="text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Email</button>
    </a>
  @endif
  @if ($job->employer_contact)
    <a target="_blank" href="{{ $job->employer_contact }}">
      <button type="button" class="text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Whatsapp</button>
    </a>
  @endif
  @if ($job->job_website)
    <a target="_blank" href="{{ $job->job_website }}">
      <button type="button" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
      <!-- <button type="button" class="text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"> -->
        <div class="flex">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
          </svg>
          <span>Website</span>
        </div>
      </button>
    </a>
  @endif
  <a href="{{ route('job_view', ['id' => $job->id, 'title' => $job->urlTitle() ]) }}">
    <button type="button" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">View in new tab</button>
    <!-- <button type="button" class="text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">View in new tab</button> -->
  </a>
</div>

<div class=""></div>

<div class="p-6 overflow-y-scroll h-screen" id="job-selected">
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

  <div class='mb-6'>
    <span class="text-sm text-zinc-600 dark:text-gray-400">{{ $diff = Carbon\Carbon::parse($job->posted_at)->diffForHumans() }}</span>
  </div>

  <div class='mb-3'>
    {!! $job->description !!}
  </div>
</div>
