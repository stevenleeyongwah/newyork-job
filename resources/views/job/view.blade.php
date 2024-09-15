@extends('layouts.app')

@section('content')

<script type="application/ld+json">
{
  "@context" : "https://schema.org/",
  "@type" : "JobPosting",
  "title" : "{{ $job->title }}",
  "description" : "{{ $job->description }}",
  "identifier": {
    "@type": "PropertyValue",
    "name": "{{ $job->company }}",
    "value": "{{ $job->company }}"
  },
  "datePosted" : "{{ date('Y-m-d', strtotime($job->posted_at)) }}",
  "applicantLocationRequirements": {
    "@type": "Country",
    "name": "USA"
  },
  "jobLocationType": "TELECOMMUTE",
  "hiringOrganization" : {
    "@type" : "Organization",
    "name" : "{{ $job->company }}",
    "sameAs" : "https://newyork-job.com"
  }
}
</script>

<div class='container mx-auto justify-center p-8 max-w-6xl'>
  <div class="">

    <div>
      <p class='text-3xl mb-1 text-sky-900 font-semibold'>{{ $job->title }}</p>
    </div>

    <div class='mb-2'>
      <span class="text-base text-zinc-600 font-bold dark:text-gray-400">{{ $job->company }}</span>
    </div>

    <div class='mb-2'>
      <span class="text-base text-zinc-600 font-bold dark:text-gray-400">West</span>
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

    <a target="_blank" href="{{ $job->job_website }}">
      <button type="button" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
      <!-- <button type="button" class="text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"> -->
        <div class="flex">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
          </svg>
          <span>Website</span>
        </div>
      </button>
    </a>

    <div class='mb-6'>
      <span class="text-sm text-zinc-600 dark:text-gray-400">Posted {{ $diff = Carbon\Carbon::parse($job->posted_at)->diffForHumans() }}</span>
    </div>

    <div class='mb-3 blog-content'>
      {!! $job->description !!}
    </div>
  </div>

</div>
@endsection
