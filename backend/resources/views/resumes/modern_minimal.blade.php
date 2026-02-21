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
            line-height: 1.4;
            color: #111;
        }
        .container { display: table; width: 100%; height: 100%; }
        .sidebar {
            display: table-cell; width: 30%; vertical-align: top;
            background: #1e293b; color: #e2e8f0; padding: 30px 20px;
        }
        .main { display: table-cell; width: 70%; vertical-align: top; padding: 30px 25px; }
        .sidebar h1 { font-size: 18pt; color: #fff; margin-bottom: 4px; letter-spacing: 1px; }
        .sidebar .subtitle { font-size: 9pt; color: #94a3b8; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .sidebar h2 {
            font-size: 8.5pt; text-transform: uppercase; letter-spacing: 2px;
            color: #94a3b8; border-bottom: 1px solid #334155; padding-bottom: 4px;
            margin-top: 18px; margin-bottom: 8px;
        }
        .sidebar .contact-item { font-size: 9pt; margin-bottom: 5px; color: #cbd5e1; }
        .sidebar .contact-item strong { color: #e2e8f0; font-size: 8.5pt; }
        .sidebar .skill-item { font-size: 9pt; margin-bottom: 3px; color: #cbd5e1; }
        .sidebar .edu-item { margin-bottom: 8px; }
        .sidebar .edu-degree { font-size: 9.5pt; font-weight: 700; color: #fff; }
        .sidebar .edu-school { font-size: 8.5pt; color: #94a3b8; }
        .sidebar .edu-date { font-size: 8pt; color: #64748b; }
        .sidebar .cert-item { font-size: 9pt; margin-bottom: 5px; color: #cbd5e1; }
        .sidebar .cert-name { font-weight: 600; color: #e2e8f0; }

        .main h2 {
            font-size: 10pt; text-transform: uppercase; letter-spacing: 1.5px;
            color: #1e293b; border-bottom: 2px solid #1e293b; padding-bottom: 3px;
            margin-bottom: 10px; margin-top: 18px;
        }
        .main h2:first-child { margin-top: 0; }
        .objective { font-size: 9.5pt; color: #475569; margin-bottom: 14px; line-height: 1.6; }
        .exp-item { margin-bottom: 12px; page-break-inside: avoid; }
        .exp-header { display: table; width: 100%; }
        .exp-left { display: table-cell; }
        .exp-right { display: table-cell; text-align: right; font-size: 8.5pt; color: #64748b; }
        .exp-title { font-size: 10.5pt; font-weight: 700; color: #0f172a; }
        .exp-company { font-size: 9pt; color: #3b82f6; font-weight: 600; }
        .exp-desc { font-size: 9pt; color: #475569; margin-top: 3px; }
        ul.achievements { list-style: none; margin-top: 4px; padding-left: 10px; }
        ul.achievements li { font-size: 9pt; color: #334155; margin-bottom: 2px; }
        ul.achievements li:before { content: "— "; color: #1e293b; }
        .tech-line { font-size: 8pt; color: #94a3b8; margin-top: 3px; font-style: italic; }
        .proj-item { margin-bottom: 8px; page-break-inside: avoid; }
        .proj-title { font-size: 10pt; font-weight: 700; color: #0f172a; }
        .proj-desc { font-size: 9pt; color: #475569; margin-top: 2px; }
    </style>
</head>
<body>
    @php $adminUser = \App\Models\User::where('role', 'admin')->first(); @endphp
    <div class="container">
        <div class="sidebar">
            <h1>{{ $adminUser?->name ?? 'Portfolio Owner' }}</h1>
            <div class="subtitle">{{ $meta->job_title ?? '' }}</div>

            <h2>Contact</h2>
            @foreach($contact as $c)
                <div class="contact-item">
                    <strong>{{ ucfirst($c->type) }}</strong><br>
                    {{ $c->display_name ?? $c->value }}
                </div>
            @endforeach

            <h2>Skills</h2>
            @foreach($skills as $skill)
                <div class="skill-item">{{ $skill->name }}</div>
            @endforeach

            <h2>Education</h2>
            @foreach($education as $ed)
                <div class="edu-item">
                    <div class="edu-degree">{{ $ed->degree }}</div>
                    <div class="edu-school">{{ $ed->institution_name }}</div>
                    <div class="edu-date">
                        {{ \Carbon\Carbon::parse($ed->start_date)->format('Y') }} —
                        {{ $ed->end_date ? \Carbon\Carbon::parse($ed->end_date)->format('Y') : 'Present' }}
                    </div>
                </div>
            @endforeach

            @if($certifications->count())
                <h2>Certifications</h2>
                @foreach($certifications as $cert)
                    <div class="cert-item">
                        <span class="cert-name">{{ $cert->name }}</span><br>
                        {{ $cert->issuing_organization }}
                    </div>
                @endforeach
            @endif
        </div>

        <div class="main">
            @if(!empty($custom_objective))
                <h2>Profile</h2>
                <div class="objective">{{ $custom_objective }}</div>
            @endif

            @if($experiences->count())
                <h2>Experience</h2>
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
                            <div class="tech-line">{{ implode(' · ', $exp->technologies_used) }}</div>
                        @endif
                    </div>
                @endforeach
            @endif

            @if($projects->count())
                <h2>Projects</h2>
                @foreach($projects as $proj)
                    <div class="proj-item">
                        <div class="proj-title">{{ $proj->title }}</div>
                        @if($proj->description)
                            <div class="proj-desc">{{ $proj->description }}</div>
                        @endif
                        @if(!empty($proj->technologies))
                            <div class="tech-line">{{ implode(' · ', $proj->technologies) }}</div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</body>
</html>
