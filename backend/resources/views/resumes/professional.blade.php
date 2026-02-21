<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            color: #1a1a2e;
            padding: 30px 40px;
        }
        .header { text-align: center; margin-bottom: 18px; border-bottom: 2px solid #2563eb; padding-bottom: 14px; }
        .header h1 { font-size: 22pt; font-weight: 700; color: #111827; letter-spacing: 1px; margin-bottom: 4px; }
        .header .contact-line { font-size: 9pt; color: #4b5563; }
        .header .contact-line span { margin: 0 6px; }
        .section { margin-bottom: 14px; }
        .section-title {
            font-size: 10pt; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;
            color: #2563eb; border-bottom: 1px solid #e5e7eb; padding-bottom: 3px; margin-bottom: 8px;
        }
        .objective { font-size: 10pt; color: #374151; margin-bottom: 14px; padding: 8px 12px; background: #f9fafb; border-left: 3px solid #2563eb; }
        .skills-group { margin-bottom: 4px; }
        .skills-group strong { font-size: 9.5pt; color: #111827; }
        .skills-group span { font-size: 9.5pt; color: #4b5563; }
        .exp-item { margin-bottom: 10px; page-break-inside: avoid; }
        .exp-header { display: table; width: 100%; }
        .exp-left { display: table-cell; }
        .exp-right { display: table-cell; text-align: right; font-size: 9pt; color: #6b7280; }
        .exp-title { font-size: 11pt; font-weight: 700; color: #111827; }
        .exp-company { font-size: 9.5pt; color: #2563eb; font-weight: 600; }
        .exp-desc { font-size: 9.5pt; color: #4b5563; margin-top: 3px; }
        ul.achievements { list-style: none; margin-top: 4px; padding-left: 12px; }
        ul.achievements li { font-size: 9.5pt; color: #374151; margin-bottom: 2px; }
        ul.achievements li:before { content: "› "; color: #2563eb; font-weight: 700; }
        .tech-line { font-size: 8pt; color: #6b7280; margin-top: 4px; }
        .proj-item { margin-bottom: 8px; page-break-inside: avoid; }
        .proj-title { font-size: 10pt; font-weight: 700; color: #111827; }
        .proj-desc { font-size: 9.5pt; color: #4b5563; margin-top: 2px; }
        .edu-item { margin-bottom: 6px; }
        .edu-header { display: table; width: 100%; }
        .edu-left { display: table-cell; }
        .edu-right { display: table-cell; text-align: right; font-size: 9pt; color: #6b7280; }
        .edu-degree { font-size: 10pt; font-weight: 700; color: #111827; }
        .edu-school { font-size: 9.5pt; color: #2563eb; }
        .cert-item { margin-bottom: 4px; font-size: 9.5pt; }
        .cert-name { font-weight: 600; color: #111827; }
        .cert-org { color: #6b7280; }
    </style>
</head>
<body>
    @php $adminUser = \App\Models\User::where('role', 'admin')->first(); @endphp
    <div class="header">
        <h1>{{ $adminUser?->name ?? 'Portfolio Owner' }}</h1>
        <div class="contact-line">
            @foreach($contact as $c)
                <span>{{ $c->display_name ?? $c->value }}</span>
            @endforeach
        </div>
    </div>

    @if(!empty($custom_objective))
        <div class="objective">{{ $custom_objective }}</div>
    @endif

    @if($skills->count())
        <div class="section">
            <div class="section-title">Technical Skills</div>
            @php $grouped = $skills->groupBy('category'); @endphp
            @foreach($grouped as $category => $items)
                <div class="skills-group">
                    <strong>{{ $category ?: 'Other' }}:</strong>
                    <span>{{ $items->pluck('name')->join(', ') }}</span>
                </div>
            @endforeach
        </div>
    @endif

    @if($experiences->count())
        <div class="section">
            <div class="section-title">Professional Experience</div>
            @foreach($experiences as $exp)
                <div class="exp-item">
                    <div class="exp-header">
                        <div class="exp-left">
                            <div class="exp-title">{{ $exp->job_title }}</div>
                            <div class="exp-company">{{ $exp->company_name }}@if($exp->location) · {{ $exp->location }}@endif</div>
                        </div>
                        <div class="exp-right">
                            {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} —
                            {{ $exp->is_current ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('M Y') }}
                        </div>
                    </div>
                    @if($exp->description)
                        <div class="exp-desc">{{ $exp->description }}</div>
                    @endif
                    @if(!empty($exp->achievements))
                        <ul class="achievements">
                            @foreach($exp->achievements as $a)
                                <li>{{ $a }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if(!empty($exp->technologies_used))
                        <div class="tech-line">Technologies: {{ implode(', ', $exp->technologies_used) }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if($projects->count())
        <div class="section">
            <div class="section-title">Key Projects</div>
            @foreach($projects as $proj)
                <div class="proj-item">
                    <div class="proj-title">{{ $proj->title }}</div>
                    @if($proj->description)
                        <div class="proj-desc">{{ $proj->description }}</div>
                    @endif
                    @if(!empty($proj->technologies))
                        <div class="tech-line">Technologies: {{ implode(', ', $proj->technologies) }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if($education->count())
        <div class="section">
            <div class="section-title">Education</div>
            @foreach($education as $ed)
                <div class="edu-item">
                    <div class="edu-header">
                        <div class="edu-left">
                            <div class="edu-degree">{{ $ed->degree }} in {{ $ed->field_of_study }}</div>
                            <div class="edu-school">{{ $ed->institution_name }}</div>
                        </div>
                        <div class="edu-right">
                            {{ \Carbon\Carbon::parse($ed->start_date)->format('M Y') }} —
                            {{ $ed->end_date ? \Carbon\Carbon::parse($ed->end_date)->format('M Y') : 'Present' }}
                        </div>
                    </div>
                    @if($ed->grade)
                        <div style="font-size: 8.5pt; color: #6b7280;">Grade: {{ $ed->grade }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if($certifications->count())
        <div class="section">
            <div class="section-title">Certifications</div>
            @foreach($certifications as $cert)
                <div class="cert-item">
                    <span class="cert-name">{{ $cert->name }}</span>
                    <span class="cert-org"> — {{ $cert->issuing_organization }} ({{ \Carbon\Carbon::parse($cert->issue_date)->format('M Y') }})</span>
                </div>
            @endforeach
        </div>
    @endif
</body>
</html>
