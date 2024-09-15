@foreach ($jobs as $job)
  <div class="border-l-blue-900 border-l-4 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 cursor-pointer" onclick="jobCardClick({{ $job->id }})">
    <img class="w-12 h-12 rounded" src="{{ env('AWS_S3_URL') }}/company/logo/{{ $job->company->id }}/{{ $job->company->logo }}" alt="{{ $job->company->name }}" />
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

    <div class='mb-3'>
      <span class="text-base text-zinc-600 font-bold dark:text-gray-400">SGD {{ $job->salary_min }} - {{ $job->salary_max }} monthly</span>
    </div>

    <div>
      <span class="text-sm text-zinc-600 dark:text-gray-400">1d ago</span>
    </div>
  </div>
@endforeach