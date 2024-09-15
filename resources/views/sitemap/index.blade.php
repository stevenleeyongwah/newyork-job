<?php  echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}/job</loc>
        <lastmod>2023-03-12T16:20:29+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/') }}/company</loc>
        <lastmod>2023-03-12T16:20:29+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/') }}/blog</loc>
        <lastmod>2023-03-12T16:20:29+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    @foreach ($jobs as $job)
        <url>
            <loc>{{ url('/') }}/job{{ $job->url() }}</loc>
            <lastmod>{{ $job->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    @foreach ($blogs as $blog)
        <url>
            <loc>{{ url('/') }}/blog{{ $blog->url() }}</loc>
            <lastmod>{{ $blog->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    @foreach ($specializations as $specialization)
        <url>
            <loc>{{ url('/') }}/job/{{ $specialization->lowerCaseName()}}-job-in-singapore</loc>
            <lastmod>{{ $specialization->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    @foreach ($companies as $company)
        <url>
            <loc>{{ url('/') }}/company/{{ $company->id }}/{{ $company->urlName() }}</loc>
            <lastmod>{{ $specialization->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>