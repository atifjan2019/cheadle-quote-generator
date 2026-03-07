<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        @page :first {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', poppins, sans-serif;
            color: #222;
            font-size: 10pt;
            line-height: 1.55;
            margin: 0;
            padding: 0;
        }

        /* ══════════════════════════════════════
   COVER PAGE
══════════════════════════════════════ */
        .cover-top-bar {
            background-color: #C8102E;
            height: 10px;
            width: 100%;
        }

        .cover-body {
            padding: 35px 45px 25px 45px;
        }

        .cover-logo-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }

        .cover-logo-table td {
            vertical-align: middle;
        }

        .cover-logo-img {
            height: 55px;
            width: auto;
        }

        .cover-company-name {
            font-size: 22pt;
            font-weight: bold;
            color: #1a1a2e;
            text-align: right;
            letter-spacing: -0.5px;
        }

        .cover-company-name span {
            color: #C8102E;
        }

        .cover-tagline {
            font-size: 7.5pt;
            color: #aaa;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-align: right;
            margin-top: 4px;
        }

        .cover-title-label {
            font-size: 8pt;
            font-weight: bold;
            color: #C8102E;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .cover-title-main {
            font-size: 36pt;
            font-weight: bold;
            color: #1a1a2e;
            letter-spacing: -1px;
            line-height: 1;
            margin-bottom: 8px;
        }

        .cover-title-ref {
            font-size: 10pt;
            color: #999;
            margin-bottom: 32px;
        }

        .cover-divider {
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 28px;
        }

        /* Meta grid */
        .meta-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .meta-grid td {
            padding: 14px 0;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: top;
            width: 50%;
        }

        .meta-grid td.meta-right {
            padding-left: 30px;
        }

        .meta-lbl {
            font-size: 7pt;
            font-weight: bold;
            color: #C8102E;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .meta-val {
            font-size: 11pt;
            font-weight: bold;
            color: #1a1a2e;
        }

        /* Client box */
        .client-box {
            background-color: #f7f8fa;
            border-left: 5px solid #C8102E;
            padding: 20px 22px;
            margin-bottom: 28px;
        }

        .client-box-lbl {
            font-size: 7pt;
            font-weight: bold;
            color: #C8102E;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .client-box-name {
            font-size: 16pt;
            font-weight: bold;
            color: #1a1a2e;
            margin-bottom: 5px;
        }

        .client-box-addr {
            font-size: 10pt;
            color: #555;
            line-height: 1.7;
        }

        /* Project info table */
        .project-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .project-info td {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 10pt;
            vertical-align: top;
        }

        .project-info td.pi-label {
            width: 170px;
            font-weight: bold;
            color: #555;
            padding-right: 20px;
        }

        /* Photos */
        .photos-tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .photos-tbl td {
            vertical-align: top;
            width: 50%;
            padding: 0;
        }

        .photos-tbl td:first-child {
            padding-right: 6px;
        }

        .photos-tbl td:last-child {
            padding-left: 6px;
        }

        .photos-tbl img {
            width: 100%;
            height: 160px;
        }

        /* Page footer row */
        .pg-footer {
            width: 100%;
            border-collapse: collapse;
            border-top: 1px solid #e5e5e5;
            padding-top: 10px;
            position: absolute;
            bottom: 30px;
            left: 45px;
            right: 45px;
        }

        .pg-footer td {
            font-size: 7.5pt;
            color: #bbb;
            vertical-align: middle;
            padding-top: 10px;
        }

        .pg-footer .brand {
            color: #555;
            font-weight: bold;
        }

        /* ══════════════════════════════════════
   INNER PAGES (2-5)
══════════════════════════════════════ */
        .inner-top-bar {
            background-color: #C8102E;
            height: 6px;
            width: 100%;
        }

        .inner-body {
            padding: 30px 45px 30px 45px;
            position: relative;
            min-height: calc(297mm - 6px);
        }

        .inner-hdr {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            border-bottom: 3px solid #1a1a2e;
            padding-bottom: 12px;
        }

        .inner-hdr td {
            vertical-align: bottom;
            padding-bottom: 12px;
        }

        .inner-hdr-logo {
            height: 35px;
            width: auto;
        }

        .inner-hdr-title {
            text-align: right;
            font-size: 15pt;
            font-weight: bold;
            color: #C8102E;
            letter-spacing: -0.3px;
        }

        /* Section label */
        .sec-label {
            font-size: 7.5pt;
            font-weight: bold;
            color: #C8102E;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e8e8e8;
        }

        /* Revision notes page */
        .rn-intro-text {
            font-size: 10pt;
            color: #555;
            margin-bottom: 18px;
            line-height: 1.7;
        }

        .rn-tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .rn-tbl td {
            padding: 11px 14px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 10.5pt;
            line-height: 1.7;
            vertical-align: top;
        }

        .rn-tbl td.rn-dash {
            width: 28px;
            color: #C8102E;
            font-weight: bold;
            font-size: 12pt;
            text-align: center;
            padding-left: 0;
            padding-right: 4px;
        }

        /* Scope table */
        .scope-tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .scope-tbl tr.sg td {
            background-color: #1a1a2e;
            color: #ffffff;
            font-weight: bold;
            font-size: 10.5pt;
            padding: 10px 15px;
            letter-spacing: 0.3px;
        }

        .scope-tbl tr.si td {
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: top;
            line-height: 1.65;
            font-size: 10pt;
        }

        .scope-tbl tr.si td.sn {
            width: 36%;
            font-weight: bold;
            color: #222;
            border-right: 3px solid #C8102E;
            background-color: #fafafa;
        }

        /* Pricing table */
        .price-tbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .price-tbl td {
            padding: 13px 16px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: top;
            font-size: 10.5pt;
            line-height: 1.65;
        }

        .price-tbl td.pl {
            width: 180px;
            font-weight: bold;
            color: #222;
            background-color: #fafafa;
            border-right: 1px solid #f0f0f0;
        }

        .price-tbl tr.total-row td {
            background-color: #1a1a2e;
            color: #ffffff;
            font-weight: bold;
            font-size: 14pt;
            border-right: none;
            padding: 16px 18px;
        }

        .price-tbl tr.total-row td .amount {
            color: #ff6b6b;
            font-size: 18pt;
        }

        /* Signature area */
        .sig-tbl {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
        }

        .sig-tbl td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        .sig-tbl td:first-child {
            padding-right: 18px;
        }

        .sig-tbl td:last-child {
            padding-left: 18px;
            border-left: 1px solid #e8e8e8;
        }

        .sig-block {
            border-top: 2px solid #1a1a2e;
            padding-top: 10px;
            margin-top: 48px;
        }

        .sig-block-lbl {
            font-size: 8pt;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sig-block-name {
            font-size: 11pt;
            font-weight: bold;
            color: #1a1a2e;
            margin-top: 4px;
        }

        /* Project notes page */
        .pn-title {
            font-size: 18pt;
            font-weight: bold;
            color: #1a1a2e;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }

        .pn-title span {
            color: #C8102E;
        }

        .pn-divider {
            border-bottom: 2px solid #f0f0f0;
            margin: 14px 0 18px 0;
        }

        .pn-heading {
            font-size: 9.5pt;
            font-weight: bold;
            color: #1a1a2e;
            margin-top: 18px;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1px solid #f0f0f0;
        }

        .pn-text {
            font-size: 9.5pt;
            color: #444;
            line-height: 1.8;
        }

        .pn-bullet-tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .pn-bullet-tbl td {
            padding: 3px 0;
            font-size: 9.5pt;
            color: #444;
            line-height: 1.7;
            vertical-align: top;
        }

        .pn-bullet-tbl td.bullet {
            width: 14px;
            color: #C8102E;
            font-size: 11pt;
            font-weight: bold;
        }

        .valid-note {
            font-size: 8.5pt;
            color: #bbb;
            font-style: italic;
            margin-top: 8px;
        }

        /* FMB Certificate pages */
        .fmb-page {
            text-align: center;
            padding: 0;
            margin: 0;
        }

        .fmb-page .fmb-body {
            padding: 30px 45px 30px 45px;
            text-align: center;
        }

        .fmb-page .fmb-img {
            max-width: 100%;
            max-height: 920px;
            width: auto;
            height: auto;
        }

        /* Who We Are page */
        .wwa-title {
            font-size: 28pt;
            font-weight: bold;
            color: #1a1a2e;
            text-align: center;
            margin-bottom: 10px;
            font-style: italic;
            letter-spacing: -0.5px;
        }

        .wwa-divider {
            width: 60px;
            height: 3px;
            background: #C8102E;
            margin: 0 auto 24px auto;
        }

        .wwa-text {
            font-size: 10pt;
            color: #444;
            line-height: 1.75;
            margin-bottom: 12px;
            text-align: justify;
        }

        .wwa-highlight {
            border-left: 3px solid #C8102E;
            padding-left: 14px;
            margin: 18px 0;
        }

        .wwa-logos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
            background: #f8f9fb;
            border: 1px solid #e8e8e8;
            border-radius: 6px;
        }

        .wwa-logos td {
            width: 50%;
            text-align: center;
            vertical-align: middle;
            padding: 14px 20px;
        }

        .wwa-logos img {
            max-height: 80px;
            width: auto;
        }

        /* What We Do page */
        .wwd-title {
            font-size: 28pt;
            font-weight: bold;
            color: #1a1a2e;
            font-style: italic;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .wwd-layout {
            width: 100%;
            border-collapse: collapse;
        }

        .wwd-layout td {
            vertical-align: top;
        }

        .wwd-list-col {
            width: 52%;
            padding-right: 12px;
        }

        .wwd-photos-col {
            width: 48%;
            padding-left: 8px;
        }

        .wwd-item {
            font-size: 9.5pt;
            font-weight: bold;
            color: #222;
            padding: 3px 0;
            line-height: 1.45;
            text-decoration: underline;
        }

        .wwd-check {
            color: #C8102E;
            font-weight: bold;
            margin-right: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .wwd-photo {
            width: 100%;
            height: auto;
            border-radius: 6px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    @php
        $dateFmt = $quote->date ? $quote->date->format('d/m/Y') : date('d/m/Y');
        $clientName = e($quote->client_name ?? '');
        $addrLines = array_filter(array_map('trim', explode("\n", $quote->client_address ?? '')));
        $addrHtml = implode('<br>', array_map('e', $addrLines));
        $projectRef = e($quote->project_ref ?? '—');
        $projectDesc = e($quote->project_description ?? '');
        $architect = e($quote->architect ?? 'Not yet appointed');
        $structEng = e($quote->structural_engineer ?? 'Not yet appointed');
        $preparedBy = e($quote->prepared_by ?? 'Joanne Fowler');
        $status = e(ucfirst($quote->status ?? 'Quotation'));

        $p = $pricing ?: null;
        $breakdownHtml = nl2br(e($p['price_breakdown'] ?? ''));
        $notesHtml = nl2br(e($p['notes'] ?? ''));
        $exclItems = array_filter(array_map('trim', explode("\n", $p['exclusions'] ?? '')));
    @endphp

    {{-- ░░░░░░░░░░░░░░░░░░ PAGE 1 — COVER ░░░░░░░░░░░░░░░░░░ --}}
    <div class="cover-top-bar"></div>
    <div class="cover-body">

        <table class="cover-logo-table">
            <tr>
                <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="cover-logo-img" alt="CC">@endif</td>
                <td>
                    <div class="cover-company-name">Cheadle <span>Construction</span></div>
                    <div class="cover-tagline">Building Excellence &middot; Greater Manchester</div>
                </td>
            </tr>
        </table>

        <div class="cover-title-label">Formal Quotation</div>
        <div class="cover-title-main">QUOTATION</div>
        <div class="cover-title-ref">Ref: {{ $projectRef }} &nbsp;&middot;&nbsp; {{ $dateFmt }}</div>
        <div class="cover-divider"></div>

        <table class="meta-grid">
            <tr>
                <td>
                    <div class="meta-lbl">Date</div>
                    <div class="meta-val">{{ $dateFmt }}</div>
                </td>
                <td class="meta-right">
                    <div class="meta-lbl">Reference</div>
                    <div class="meta-val">{{ $projectRef }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="meta-lbl">Prepared By</div>
                    <div class="meta-val">{{ $preparedBy }}</div>
                </td>
                <td class="meta-right">
                    <div class="meta-lbl">Status</div>
                    <div class="meta-val" style="color: #C8102E;">{{ $status }}</div>
                </td>
            </tr>
        </table>

        @if($clientName)
            <div class="client-box">
                <div class="client-box-lbl">Prepared For</div>
                <div class="client-box-name">{{ $clientName }}</div>
                @if($addrHtml)
                <div class="client-box-addr">{!! $addrHtml !!}</div>@endif
            </div>
        @endif

        @if($projectDesc || $architect)
            <table class="project-info">
                @if($projectDesc)
                    <tr>
                        <td class="pi-label">Project</td>
                        <td>{{ $projectDesc }}</td>
                    </tr>
                @endif
                <tr>
                    <td class="pi-label">Architect</td>
                    <td>{{ $architect }}</td>
                </tr>
                <tr>
                    <td class="pi-label">Structural Engineer</td>
                    <td>{{ $structEng }}</td>
                </tr>
            </table>
        @endif

        @if(!empty($workPhotos))
            <table class="photos-tbl">
                <tr>
                    @foreach(array_slice($workPhotos, 0, 2) as $photo)
                        <td><img src="{{ $photo }}" alt="Work"></td>
                    @endforeach
                    @if(count($workPhotos) === 1)
                    <td></td>@endif
                </tr>
            </table>
        @endif

        <table class="pg-footer">
            <tr>
                <td><span class="brand">Cheadle Construction Ltd</span> &middot; Building Excellence, Greater Manchester
                </td>
                <td style="text-align: right;">Page 1 of 9 &nbsp;&middot;&nbsp; {{ $projectRef }}</td>
            </tr>
        </table>
    </div>

    <pagebreak />

    {{-- ░░░░░░░░░░░░░░░░░░ PAGE 2 — REVISION NOTES ░░░░░░░░░░░░░░░░░░ --}}
    <div class="inner-top-bar"></div>
    <div class="inner-body">
        <table class="inner-hdr">
            <tr>
                <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-hdr-logo" alt="">@else<span
                    style="font-size:14pt;font-weight:bold;color:#1a1a2e;">Cheadle <span
                style="color:#C8102E;">Construction</span></span>@endif</td>
                <td class="inner-hdr-title">Scope of Work</td>
            </tr>
        </table>

        <div class="sec-label">Revision Notes</div>

        @if($notes->count())
            <p class="rn-intro-text">This quotation has been revised as of <strong
                    style="color:#C8102E;">{{ $dateFmt }}</strong> to include the following changes:</p>
            <table class="rn-tbl">
                @foreach($notes as $n)
                    <tr>
                        <td class="rn-dash">&mdash;</td>
                        <td>{!! $n->is_bold ? '<strong>' . nl2br(e($n->note_text)) . '</strong>' : nl2br(e($n->note_text)) !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <p style="color:#bbb;font-style:italic;padding:20px 0;">No revision notes added.</p>
        @endif

        <table class="pg-footer">
            <tr>
                <td><span class="brand">Cheadle Construction Ltd</span></td>
                <td style="text-align: right;">Page 2 of 9</td>
            </tr>
        </table>
    </div>

    <pagebreak />

    {{-- ░░░░░░░░░░░░░░░░░░ PAGE 3 — SCOPE & SPECIFICATION ░░░░░░░░░░░░░░░░░░ --}}
    <div class="inner-top-bar"></div>
    <div class="inner-body">
        <table class="inner-hdr">
            <tr>
                <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-hdr-logo" alt="">@endif</td>
                <td class="inner-hdr-title">Specification</td>
            </tr>
        </table>

        <div class="sec-label">Scope &amp; Specification</div>

        @if($sections->count())
            <table class="scope-tbl">
                @foreach($sections as $sec)
                    @if($sec->is_heading)
                        <tr class="sg">
                            <td colspan="2">{{ e($sec->section_name) }}</td>
                        </tr>
                    @else
                        <tr class="si">
                            <td class="sn">{{ e($sec->section_name) }}</td>
                            <td>{!! nl2br(e($sec->section_description ?? '')) !!}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        @else
            <p style="color:#bbb;font-style:italic;padding:20px 0;">No scope sections added yet.</p>
        @endif

        <table class="pg-footer">
            <tr>
                <td><span class="brand">Cheadle Construction Ltd</span></td>
                <td style="text-align: right;">Page 3 of 9</td>
            </tr>
        </table>
    </div>

    <pagebreak />

    {{-- ░░░░░░░░░░░░░░░░░░ PAGE 4 — WHO WE ARE ░░░░░░░░░░░░░░░░░░ --}}
    <div class="inner-top-bar"></div>
    <div class="inner-body">
        <table class="inner-hdr">
            <tr>
                <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-hdr-logo" alt="">@endif</td>
                <td class="inner-hdr-title">About Us</td>
            </tr>
        </table>

        <div class="wwa-title">Who we are&hellip;</div>
        <div class="wwa-divider"></div>

        <p class="wwa-text">We have created this package with the aim to give our customers an overview of our business and to give you the confidence and security of knowing you have made the right choice by employing Cheadle Construction to undertake your project.</p>

        <p class="wwa-text">We would advise all our potential customers to look at our google business page to see what our customers say about us and visit our Instagram page to view on-site videos at <strong>@cheadle_construction</strong>. It is also possible to arrange visits to previous project comparable with your own to see first-hand our standard of workmanship.</p>

        <div class="wwa-highlight">
            <p class="wwa-text" style="margin-bottom:0;">Cheadle Construction Ltd are a well-established professional company with over <strong>25 years&rsquo; experience</strong> in the domestic and commercial building industry.</p>
        </div>

        <p class="wwa-text">We have a close team of professional and reliable tradesmen, all with the relevant qualifications or time served within the industry. We want all our customers to be completely reassured that all our building work is carried out to the highest standards.</p>

        <p class="wwa-text">Services we offer include building refurbishments, home extensions, loft conversions, damp coursing and basement conversions. Our projects are completed in a timely fashion working towards a pre-arranged budget.</p>

        <p class="wwa-text">Cheadle Construction LTD is a fully insured VAT registered company. We are also a member of &lsquo;The Federation of Master builders&rsquo; Trade association and would urge all our customers to visit their website. To qualify to become a member companies must be inspected once a year and provide proof of good working practices.</p>

        <table class="wwa-logos">
            <tr>
                <td>@if($trustmarkBase64)<img src="{{ $trustmarkBase64 }}" alt="TrustMark">@endif</td>
                <td>@if($fmbLogoBase64)<img src="{{ $fmbLogoBase64 }}" alt="Federation of Master Builders">@endif</td>
            </tr>
        </table>

        <table class="pg-footer">
            <tr>
                <td><span class="brand">Cheadle Construction Ltd</span></td>
                <td style="text-align: right;">Page 4 of 9</td>
            </tr>
        </table>
    </div>

    <pagebreak />

    {{-- ░░░░░░░░░░░░░░░░░░ PAGE 5 — WHAT WE DO ░░░░░░░░░░░░░░░░░░ --}}
    <div class="inner-top-bar"></div>
    <div class="inner-body">
        <table class="inner-hdr">
            <tr>
                <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-hdr-logo" alt="">@endif</td>
                <td class="inner-hdr-title">Our Services</td>
            </tr>
        </table>

        <div class="wwd-title">What we do&hellip;</div>

        <table class="wwd-layout">
            <tr>
                <td class="wwd-list-col">
                    @php
                        $services = [
                            'Design & Build', 'Extensions', 'Loft Conversions', 'Basement Conversions',
                            'Garage Conversions', 'General Building', 'Structural Works', 'Renovations',
                            'Kitchens', 'Bathrooms', 'Plumbing', 'Heating',
                            'Electrical', 'Roofing', 'Damp Proofing', 'Maintenance',
                            'Repairs', 'Design Services', 'Locks', 'Painting & Decorating',
                            'Floor Laying', 'Tiling', 'Project Management', 'Landscaping',
                            'Underfloor Heating', 'Facias & Soffits', 'Windows and Door'
                        ];
                    @endphp
                    @foreach($services as $svc)
                        <div class="wwd-item"><span class="wwd-check">&check;</span> {{ $svc }}</div>
                    @endforeach
                </td>
                <td class="wwd-photos-col">
                    @if($wwdPhoto1Base64)<img src="{{ $wwdPhoto1Base64 }}" class="wwd-photo" alt="Extension project">@endif
                    @if($wwdPhoto2Base64)<img src="{{ $wwdPhoto2Base64 }}" class="wwd-photo" alt="Kitchen renovation">@endif
                </td>
            </tr>
        </table>

        <table class="pg-footer">
            <tr>
                <td><span class="brand">Cheadle Construction Ltd</span></td>
                <td style="text-align: right;">Page 5 of 9</td>
            </tr>
        </table>
    </div>

    @if(!empty($p))
        <pagebreak />

        {{-- ░░░░░░░░░░░░░░░░░░ PAGE 6 — PRICING ░░░░░░░░░░░░░░░░░░ --}}
        <div class="inner-top-bar"></div>
        <div class="inner-body">
            <table class="inner-hdr">
                <tr>
                    <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-hdr-logo" alt="">@endif</td>
                    <td class="inner-hdr-title">Pricing</td>
                </tr>
            </table>

            <div class="sec-label">Pricing Summary</div>

            <table class="price-tbl">
                @if(!empty($p['base_cost']))
                    <tr>
                        <td class="pl">Contract Sum</td>
                        <td>
                            <strong
                                style="font-size:12pt;color:#1a1a2e;">&pound;{{ number_format($p['base_cost'], 0) }}</strong>
                            @if(!empty($p['base_cost_label']))
                                <br><span style="font-size:9pt;color:#888;">{{ e($p['base_cost_label']) }}</span>
                            @endif
                        </td>
                    </tr>
                @endif

                @if(!empty($p['additional_cost']))
                    <tr>
                        <td class="pl">Additional Works</td>
                        <td>
                            <strong
                                style="font-size:12pt;color:#1a1a2e;">&pound;{{ number_format($p['additional_cost'], 0) }}</strong>
                            @if(!empty($p['additional_cost_label']))
                                <br><span style="font-size:9pt;color:#888;">{{ e($p['additional_cost_label']) }}</span>
                            @endif
                        </td>
                    </tr>
                @endif

                @if(!empty($p['price_breakdown']))
                    <tr>
                        <td class="pl">Breakdown</td>
                        <td>{!! $breakdownHtml !!}</td>
                    </tr>
                @endif

                @if(!empty($p['notes']))
                    <tr>
                        <td class="pl">Notes</td>
                        <td>{!! $notesHtml !!}</td>
                    </tr>
                @endif

                @if(!empty($exclItems))
                    <tr>
                        <td class="pl">Exclusions<br><span style="font-weight:normal;font-size:8pt;color:#bbb;">(not
                                included)</span></td>
                        <td>
                            <table class="pn-bullet-tbl">
                                @foreach($exclItems as $item)
                                    <tr>
                                        <td class="bullet">&rsaquo;</td>
                                        <td>{{ e($item) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                @endif

                @if(!empty($p['total_cost']))
                    <tr class="total-row">
                        <td>TOTAL @if(!empty($p['total_cost_label']))<br><small
                        style="font-size:8pt;font-weight:normal;opacity:0.7;">{{ e($p['total_cost_label']) }}</small>@endif
                        </td>
                        <td><span class="amount">&pound;{{ number_format($p['total_cost'], 0) }}</span> <small
                                style="font-size:9pt;font-weight:normal;opacity:0.7;">inc. VAT where applicable</small></td>
                    </tr>
                @endif
            </table>

            <p class="valid-note">This quotation is valid for 30 days. A payment schedule and FMB contract will be provided
                upon acceptance.</p>

            <table class="sig-tbl">
                <tr>
                    <td>
                        <div class="sig-block">
                            <div class="sig-block-lbl">Client Signature &amp; Date</div>
                            <div class="sig-block-name">{{ $clientName }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="sig-block">
                            <div class="sig-block-lbl">Authorised by</div>
                            <div class="sig-block-name">{{ $preparedBy }}<br><span
                                    style="font-size:8.5pt;font-weight:normal;color:#999;">Cheadle Construction Ltd</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <table class="pg-footer">
                <tr>
                    <td><span class="brand">Cheadle Construction Ltd</span></td>
                    <td style="text-align: right;">Page 6 of 9</td>
                </tr>
            </table>
        </div>
    @endif

    <pagebreak />

    {{-- ░░░░░░░░░░░░░░░░░░ PAGE 7 — FMB CERTIFICATE 1 ░░░░░░░░░░░░░░░░░░ --}}
    <div class="fmb-page">
        <div class="inner-top-bar"></div>
        <div class="fmb-body">
            <table class="inner-hdr">
                <tr>
                    <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-hdr-logo" alt="">@endif</td>
                    <td class="inner-hdr-title">FMB Membership</td>
                </tr>
            </table>

            @if($fmbCert1Base64)
                <img src="{{ $fmbCert1Base64 }}" class="fmb-img" alt="FMB Membership Certificate">
            @endif

            <table class="pg-footer">
                <tr>
                    <td><span class="brand">Cheadle Construction Ltd</span></td>
                    <td style="text-align: right;">Page 7 of 9</td>
                </tr>
            </table>
        </div>
    </div>

    <pagebreak />

    {{-- ░░░░░░░░░░░░░░░░░░ PAGE 8 — FMB CERTIFICATE 2 ░░░░░░░░░░░░░░░░░░ --}}
    <div class="fmb-page">
        <div class="inner-top-bar"></div>
        <div class="fmb-body">
            <table class="inner-hdr">
                <tr>
                    <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-hdr-logo" alt="">@endif</td>
                    <td class="inner-hdr-title">FMB Membership</td>
                </tr>
            </table>

            @if($fmbCert2Base64)
                <img src="{{ $fmbCert2Base64 }}" class="fmb-img" alt="FMB Membership Certificate">
            @endif

            <table class="pg-footer">
                <tr>
                    <td><span class="brand">Cheadle Construction Ltd</span></td>
                    <td style="text-align: right;">Page 8 of 9</td>
                </tr>
            </table>
        </div>
    </div>

    <pagebreak />

    {{-- ░░░░░░░░░░░░░░░░░░ PAGE 9 — PROJECT NOTES ░░░░░░░░░░░░░░░░░░ --}}
    <div class="inner-top-bar"></div>
    <div class="inner-body">
        <table class="inner-hdr">
            <tr>
                <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-hdr-logo" alt="">@endif</td>
                <td class="inner-hdr-title">Project Notes</td>
            </tr>
        </table>

        <div class="pn-title">Cheadle Construction <span>Project Notes</span></div>
        <div class="pn-divider"></div>

        <div class="pn-heading">General Notes &amp; Exclusions</div>
        <table class="pn-bullet-tbl">
            <tr>
                <td class="bullet">&rsaquo;</td>
                <td>No allowance for floor covering at this stage unless stated otherwise.</td>
            </tr>
            <tr>
                <td class="bullet">&rsaquo;</td>
                <td>Substructures are based on assumed good ground conditions and are without the benefit of a
                    geological survey; The depths of foundation and foundation design may be subject to change by
                    site conditions and/or on the instruction of Building Control or clients Engineer or Architect. In the
                    event of change of design and/or depth of foundation the Contractor reserves the right to amend
                    the Contract Sum by way of re-measurement of the revised foundation design and depth.</td>
            </tr>
            <tr>
                <td class="bullet">&rsaquo;</td>
                <td>All waste to be disposed of</td>
            </tr>
            <tr>
                <td class="bullet">&rsaquo;</td>
                <td>Structural costs are subject to engineer&rsquo;s design/Calcs if not presented prior to costing.</td>
            </tr>
            <tr>
                <td class="bullet">&rsaquo;</td>
                <td>No allowance for landscaping at this stage but have allowed to infill excavated areas with MOT</td>
            </tr>
            <tr>
                <td class="bullet">&rsaquo;</td>
                <td>Please note we have not allowed for any re screeding of floor levels at this stage, unless stated
                    otherwise.</td>
            </tr>
            <tr>
                <td class="bullet">&rsaquo;</td>
                <td>No allowance for kitchen or utility purchase</td>
            </tr>
            <tr>
                <td class="bullet">&rsaquo;</td>
                <td>We have assumed that the existing RCD Board / Consumer Unit is suitable to remain</td>
            </tr>
            <tr>
                <td class="bullet">&rsaquo;</td>
                <td>No allowance for Building Control services at this stage but can be arranged at cost</td>
            </tr>
            <tr>
                <td class="bullet">&rsaquo;</td>
                <td>External drainage subject to inspection and final layout might differ from drawings.</td>
            </tr>
            <tr>
                <td class="bullet">&rsaquo;</td>
                <td>Best endeavours to protect driveways from damage we accept no reasonability for damage.
                    Once protection is in place any concerns please report to a member of staff</td>
            </tr>
        </table>

        <div class="pn-heading">Undertaking Structural Works &mdash; Deflection, Movement and Settlement</div>
        <p class="pn-text">Please note that whilst great care will be taken by our time served tradesmen to
            undertake these works, with all structural works, a tolerance for deflection, movement
            and settlement is to be expected during and following the completion of the works.
            This could result in the appearance of settlement cracking to localised areas and
            damage to decor in areas away from the work area. In some cases, easing of doors to
            the floor above the work area might be required.</p>
        <p class="pn-text">Whilst we have not allowed for these issues in our cost, we will work with the client to
            address these issues at cost in the rare event that remedial works are required.
            If you have any concerns, please just ask a member of our team.</p>

        <div class="pn-heading">Dust Settlement</div>
        <p class="pn-text">Please note, due to the nature of these works there may be some residual dust
            settlement. Whilst we will make best endeavours to keep the area clean, we can&rsquo;t
            guarantee that additional cleaning won&rsquo;t be required.</p>

        <div class="pn-heading">Building Control</div>
        <p class="pn-text">Please note that these works are notifiable under building control laws &mdash; We can handle the
            application on the client&rsquo;s behalf subject to fee quoted by our provider.</p>

        <div class="pn-heading">Payments</div>
        <p class="pn-text"><strong>Payments</strong> &ndash; A payment schedule will be provided, along with an FMB contract upon acceptance of the
            quotation. Final payment is to be paid in line with schedule, however, sometimes circumstances out
            of our control may affect the completion of your project, eg delays in kitchen appliances, building
            control to issue certificates and other services not provided by ourselves.</p>
        <p class="pn-text">Final payment is to be made once we reach the final build stage regardless of these circumstances.</p>

        <table class="pg-footer">
            <tr>
                <td><span class="brand">Cheadle Construction Ltd</span> &middot; Registered &middot; Insured &middot;
                    FMB Member &middot; TrustMark Registered</td>
                <td style="text-align: right;">Page 9 of 9</td>
            </tr>
        </table>
    </div>

</body>

</html>