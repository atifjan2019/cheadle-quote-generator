<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #1a1a2e;
            background: #fff;
            font-size: 10pt;
            line-height: 1.6;
        }

        .page-break {
            page-break-after: always;
        }

        /* ── Accent bar ── */
        .accent-bar {
            background: #C8102E;
            height: 8px;
            width: 100%;
        }

        .accent-bar-thin {
            background: linear-gradient(90deg, #C8102E, #e8354f);
            height: 4px;
            width: 100%;
        }

        /* ── Cover ── */
        .cover-wrap {
            padding: 40px 48px 32px;
        }

        .logo-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 48px;
        }

        .logo-table td {
            vertical-align: middle;
        }

        .logo-img {
            height: 54px;
            width: auto;
        }

        .brand-text {
            font-size: 20pt;
            font-weight: bold;
            color: #1a1a2e;
            letter-spacing: -0.5px;
            text-align: right;
        }

        .brand-text span {
            color: #C8102E;
        }

        .brand-sub {
            font-size: 7.5pt;
            color: #999;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-align: right;
            margin-top: 3px;
        }

        /* Hero */
        .hero-label {
            font-size: 7.5pt;
            font-weight: bold;
            color: #C8102E;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .hero-title {
            font-size: 38pt;
            font-weight: bold;
            color: #1a1a2e;
            letter-spacing: -1.5px;
            line-height: 1;
            margin-bottom: 8px;
        }

        .hero-ref {
            font-size: 10pt;
            color: #8a92a0;
            margin-bottom: 40px;
        }

        /* Divider */
        .divider {
            height: 2px;
            background: #f0f0f0;
            margin-bottom: 32px;
        }

        .divider-red {
            height: 2px;
            background: #C8102E;
            width: 60px;
            margin-bottom: 24px;
        }

        /* Meta grid */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 36px;
        }

        .meta-table td {
            padding: 16px 0;
            border-bottom: 1px solid #f0f2f5;
            vertical-align: top;
            width: 50%;
        }

        .meta-table td.right-col {
            padding-left: 32px;
        }

        .meta-label {
            font-size: 7pt;
            font-weight: bold;
            color: #C8102E;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .meta-value {
            font-size: 11pt;
            font-weight: bold;
            color: #1a1a2e;
        }

        /* Client block */
        .client-block {
            background: #f8f9fb;
            border-left: 5px solid #C8102E;
            padding: 22px 24px;
            margin-bottom: 32px;
        }

        .client-label {
            font-size: 7pt;
            font-weight: bold;
            color: #C8102E;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .client-name {
            font-size: 16pt;
            font-weight: bold;
            color: #1a1a2e;
            margin-bottom: 6px;
        }

        .client-addr {
            font-size: 10pt;
            color: #555;
            line-height: 1.7;
        }

        /* Project detail table */
        .project-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
        }

        .project-table td {
            padding: 12px 0;
            border-bottom: 1px solid #f0f2f5;
            vertical-align: top;
            font-size: 10pt;
        }

        .project-table td.proj-label {
            width: 170px;
            font-weight: bold;
            color: #555;
            padding-right: 24px;
        }

        /* Photos */
        .photos-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .photos-table td {
            vertical-align: top;
            width: 50%;
        }

        .photos-table td:first-child {
            padding-right: 8px;
        }

        .photos-table td:last-child {
            padding-left: 8px;
        }

        .photos-table img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
            border-radius: 4px;
        }

        /* Cover footer */
        .cover-footer-wrap {
            margin-top: 40px;
        }

        /* ══ INNER PAGES ══ */
        .inner-wrap {
            padding: 36px 48px 40px;
        }

        /* Inner header */
        .inner-header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
            border-bottom: 3px solid #1a1a2e;
            padding-bottom: 14px;
        }

        .inner-header-table td {
            vertical-align: bottom;
        }

        .inner-logo {
            height: 36px;
            width: auto;
        }

        .inner-page-title {
            text-align: right;
            font-size: 14pt;
            font-weight: bold;
            color: #C8102E;
            letter-spacing: -0.3px;
        }

        /* Section heading */
        .section-heading {
            font-size: 7.5pt;
            font-weight: bold;
            color: #C8102E;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e8ebef;
        }

        /* Revision notes */
        .rn-intro {
            font-size: 10pt;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.7;
        }

        .rn-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rn-table td {
            padding: 12px 0 12px 24px;
            border-bottom: 1px solid #f0f2f5;
            font-size: 10.5pt;
            line-height: 1.7;
            vertical-align: top;
        }

        .rn-table td.rn-bullet {
            width: 24px;
            padding: 12px 0 12px 0;
            color: #C8102E;
            font-weight: bold;
            font-size: 12pt;
            text-align: center;
            vertical-align: top;
        }

        /* Scope table */
        .scope-table {
            width: 100%;
            border-collapse: collapse;
        }

        .scope-table tr.scope-group-row td {
            background: #1a1a2e;
            color: #fff;
            font-weight: bold;
            font-size: 10.5pt;
            padding: 10px 16px;
            letter-spacing: 0.3px;
        }

        .scope-table tr.scope-item-row td {
            padding: 11px 16px;
            border-bottom: 1px solid #f0f2f5;
            vertical-align: top;
            line-height: 1.7;
            font-size: 10pt;
        }

        .scope-table tr.scope-item-row td.scope-name {
            width: 36%;
            font-weight: bold;
            color: #1a1a2e;
            border-right: 3px solid #C8102E;
            background: #fafbfc;
        }

        /* Pricing table */
        .price-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }

        .price-table td {
            padding: 14px 18px;
            border-bottom: 1px solid #f0f2f5;
            vertical-align: top;
            font-size: 10.5pt;
            line-height: 1.7;
        }

        .price-table td.price-label {
            width: 180px;
            font-weight: bold;
            color: #1a1a2e;
            background: #fafbfc;
            border-right: 1px solid #f0f2f5;
        }

        .price-table tr.price-total-row td {
            background: #1a1a2e;
            color: #fff;
            font-weight: bold;
            font-size: 14pt;
            border-right: none;
            padding: 18px;
        }

        .price-table tr.price-total-row td span {
            color: #ff6b6b;
            font-size: 18pt;
        }

        /* Signature */
        .sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 44px;
        }

        .sig-table td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        .sig-table td:first-child {
            padding-right: 20px;
        }

        .sig-table td:last-child {
            padding-left: 20px;
            border-left: 1px solid #e8ebef;
        }

        .sig-line-block {
            border-top: 2px solid #1a1a2e;
            padding-top: 10px;
            margin-top: 50px;
        }

        .sig-lbl {
            font-size: 8pt;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sig-nm {
            font-size: 11pt;
            font-weight: bold;
            color: #1a1a2e;
            margin-top: 4px;
        }

        /* Project notes */
        .pn-title-text {
            font-size: 18pt;
            font-weight: bold;
            color: #1a1a2e;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .pn-title-text span {
            color: #C8102E;
        }

        .pn-section-title {
            font-size: 9.5pt;
            font-weight: bold;
            color: #1a1a2e;
            margin-top: 20px;
            margin-bottom: 8px;
            letter-spacing: 0.2px;
            padding-bottom: 4px;
            border-bottom: 1px solid #f0f2f5;
        }

        .pn-text {
            font-size: 9.5pt;
            color: #444;
            line-height: 1.8;
        }

        .pn-item-table {
            width: 100%;
            border-collapse: collapse;
        }

        .pn-item-table td {
            padding: 4px 0 4px 0;
            font-size: 9.5pt;
            color: #444;
            line-height: 1.7;
            vertical-align: top;
        }

        .pn-item-table td.pn-bullet {
            width: 16px;
            color: #C8102E;
            font-size: 11pt;
            font-weight: bold;
            padding-right: 6px;
        }

        /* Page footer */
        .page-foot-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 36px;
            padding-top: 14px;
            border-top: 1px solid #e8ebef;
        }

        .page-foot-table td {
            font-size: 7.5pt;
            color: #b0b7c3;
            vertical-align: middle;
        }

        .pf-brand-name {
            color: #555;
            font-weight: bold;
        }

        /* Valid note */
        .valid-note {
            font-size: 8.5pt;
            color: #b0b7c3;
            font-style: italic;
            margin-top: 10px;
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

        $pricingData = $pricing ?: null;
        $breakdownHtml = nl2br(e($pricingData['price_breakdown'] ?? ''));
        $notesHtml = nl2br(e($pricingData['notes'] ?? ''));
        $exclItems = array_filter(array_map('trim', explode("\n", $pricingData['exclusions'] ?? '')));
    @endphp

    {{-- ═══════════════════════════════════
    PAGE 1 — COVER PAGE
    ═══════════════════════════════════ --}}
    <div class="accent-bar"></div>

    <div class="cover-wrap">

        {{-- Logo row --}}
        <table class="logo-table">
            <tr>
                <td>
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" class="logo-img" alt="Cheadle Construction">
                    @endif
                </td>
                <td>
                    <div class="brand-text">Cheadle <span>Construction</span></div>
                    <div class="brand-sub">Building Excellence &middot; Greater Manchester</div>
                </td>
            </tr>
        </table>

        {{-- Hero --}}
        <div class="hero-label">Formal Quotation</div>
        <div class="hero-title">QUOTATION</div>
        <div class="hero-ref">Ref: {{ $projectRef }} &nbsp;&middot;&nbsp; {{ $dateFmt }}</div>

        <div class="divider"></div>

        {{-- Meta details --}}
        <table class="meta-table">
            <tr>
                <td>
                    <div class="meta-label">Date</div>
                    <div class="meta-value">{{ $dateFmt }}</div>
                </td>
                <td class="right-col">
                    <div class="meta-label">Reference</div>
                    <div class="meta-value">{{ $projectRef }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="meta-label">Prepared By</div>
                    <div class="meta-value">{{ $preparedBy }}</div>
                </td>
                <td class="right-col">
                    <div class="meta-label">Status</div>
                    <div class="meta-value" style="color:#C8102E;">{{ $status }}</div>
                </td>
            </tr>
        </table>

        {{-- Client --}}
        @if($clientName)
            <div class="client-block">
                <div class="client-label">Prepared For</div>
                <div class="client-name">{{ $clientName }}</div>
                @if($addrHtml)
                <div class="client-addr">{!! $addrHtml !!}</div>@endif
            </div>
        @endif

        {{-- Project details --}}
        @if($projectDesc || $architect)
            <table class="project-table">
                @if($projectDesc)
                    <tr>
                        <td class="proj-label">Project</td>
                        <td>{{ $projectDesc }}</td>
                    </tr>
                @endif
                <tr>
                    <td class="proj-label">Architect</td>
                    <td>{{ $architect }}</td>
                </tr>
                <tr>
                    <td class="proj-label">Structural Engineer</td>
                    <td>{{ $structEng }}</td>
                </tr>
            </table>
        @endif

        {{-- Work photos --}}
        @if(!empty($workPhotos))
            <table class="photos-table">
                <tr>
                    @foreach(array_slice($workPhotos, 0, 2) as $photo)
                        <td><img src="{{ $photo }}" alt="Project work"></td>
                    @endforeach
                    @if(count($workPhotos) === 1)
                    <td></td>@endif
                </tr>
            </table>
        @endif

        {{-- Page footer --}}
        <table class="page-foot-table">
            <tr>
                <td><span class="pf-brand-name">Cheadle Construction Ltd</span> &middot; Building Excellence, Greater
                    Manchester</td>
                <td style="text-align:right;">Page 1 of 5 &nbsp;&middot;&nbsp; {{ $projectRef }}</td>
            </tr>
        </table>

    </div>

    <div class="page-break"></div>

    {{-- ═══════════════════════════════════
    PAGE 2 — REVISION NOTES
    ═══════════════════════════════════ --}}
    <div class="accent-bar"></div>

    <div class="inner-wrap">
        <table class="inner-header-table">
            <tr>
                <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-logo" alt="">@else<span
                    style="font-size:14pt;font-weight:bold;color:#1a1a2e;">Cheadle <span
                style="color:#C8102E;">Construction</span></span>@endif</td>
                <td class="inner-page-title">Scope of Work</td>
            </tr>
        </table>

        <div class="section-heading">Revision Notes</div>

        @if($notes->count())
            <p class="rn-intro">This quotation has been revised as of <strong style="color:#C8102E;">{{ $dateFmt }}</strong>
                to include the following changes:</p>

            <table class="rn-table">
                @foreach($notes as $n)
                    <tr>
                        <td class="rn-bullet">&mdash;</td>
                        <td>{!! $n->is_bold ? '<strong>' . nl2br(e($n->note_text)) . '</strong>' : nl2br(e($n->note_text)) !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <p style="color:#b0b7c3;font-style:italic;padding:20px 0;">No revision notes added.</p>
        @endif

        <table class="page-foot-table">
            <tr>
                <td><span class="pf-brand-name">Cheadle Construction Ltd</span></td>
                <td style="text-align:right;">Page 2 of 5</td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    {{-- ═══════════════════════════════════
    PAGE 3 — SCOPE & SPECIFICATION
    ═══════════════════════════════════ --}}
    <div class="accent-bar"></div>

    <div class="inner-wrap">
        <table class="inner-header-table">
            <tr>
                <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-logo" alt="">@endif</td>
                <td class="inner-page-title">Specification</td>
            </tr>
        </table>

        <div class="section-heading">Scope &amp; Specification</div>

        @if($sections->count())
            <table class="scope-table">
                @foreach($sections as $sec)
                    @if($sec->is_heading)
                        <tr class="scope-group-row">
                            <td colspan="2">{{ e($sec->section_name) }}</td>
                        </tr>
                    @else
                        <tr class="scope-item-row">
                            <td class="scope-name">{{ e($sec->section_name) }}</td>
                            <td>{!! nl2br(e($sec->section_description ?? '')) !!}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        @else
            <p style="color:#b0b7c3;font-style:italic;padding:20px 0;">No scope sections added yet.</p>
        @endif

        <table class="page-foot-table">
            <tr>
                <td><span class="pf-brand-name">Cheadle Construction Ltd</span></td>
                <td style="text-align:right;">Page 3 of 5</td>
            </tr>
        </table>
    </div>

    @if(!empty($pricingData))
        <div class="page-break"></div>

        {{-- ═══════════════════════════════════
        PAGE 4 — PRICING
        ═══════════════════════════════════ --}}
        <div class="accent-bar"></div>

        <div class="inner-wrap">
            <table class="inner-header-table">
                <tr>
                    <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-logo" alt="">@endif</td>
                    <td class="inner-page-title">Pricing</td>
                </tr>
            </table>

            <div class="section-heading">Pricing Summary</div>
            <div class="divider-red"></div>

            <table class="price-table">
                @if(!empty($pricingData['base_cost']))
                    <tr>
                        <td class="price-label">Contract Sum</td>
                        <td>
                            <strong
                                style="font-size:12pt;color:#1a1a2e;">&pound;{{ number_format($pricingData['base_cost'], 0) }}</strong>
                            @if(!empty($pricingData['base_cost_label']))
                                <br><span style="font-size:9pt;color:#8a92a0;">{{ e($pricingData['base_cost_label']) }}</span>
                            @endif
                        </td>
                    </tr>
                @endif

                @if(!empty($pricingData['additional_cost']))
                    <tr>
                        <td class="price-label">Additional Works</td>
                        <td>
                            <strong
                                style="font-size:12pt;color:#1a1a2e;">&pound;{{ number_format($pricingData['additional_cost'], 0) }}</strong>
                            @if(!empty($pricingData['additional_cost_label']))
                                <br><span style="font-size:9pt;color:#8a92a0;">{{ e($pricingData['additional_cost_label']) }}</span>
                            @endif
                        </td>
                    </tr>
                @endif

                @if(!empty($pricingData['price_breakdown']))
                    <tr>
                        <td class="price-label">Breakdown</td>
                        <td>{!! $breakdownHtml !!}</td>
                    </tr>
                @endif

                @if(!empty($pricingData['notes']))
                    <tr>
                        <td class="price-label">Notes</td>
                        <td>{!! $notesHtml !!}</td>
                    </tr>
                @endif

                @if(!empty($exclItems))
                    <tr>
                        <td class="price-label">Exclusions<br><span style="font-weight:normal;font-size:8pt;color:#b0b7c3;">(not
                                included in price)</span></td>
                        <td>
                            <table class="pn-item-table">
                                @foreach($exclItems as $item)
                                    <tr>
                                        <td class="pn-bullet">&rsaquo;</td>
                                        <td>{{ e($item) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                @endif

                @if(!empty($pricingData['total_cost']))
                    <tr class="price-total-row">
                        <td style="border-right:none;">
                            TOTAL
                            @if(!empty($pricingData['total_cost_label']))
                                <br><small
                                    style="font-size:8pt;font-weight:normal;opacity:0.7;">{{ e($pricingData['total_cost_label']) }}</small>
                            @endif
                        </td>
                        <td>
                            <span>&pound;{{ number_format($pricingData['total_cost'], 0) }}</span>
                            <br><small style="font-size:9pt;font-weight:normal;opacity:0.7;">inc. VAT where applicable</small>
                        </td>
                    </tr>
                @endif
            </table>

            <p class="valid-note">This quotation is valid for 30 days. A payment schedule and FMB contract will be provided
                upon acceptance.</p>

            {{-- Signatures --}}
            <table class="sig-table">
                <tr>
                    <td>
                        <div class="sig-line-block">
                            <div class="sig-lbl">Client Signature &amp; Date</div>
                            <div class="sig-nm">{{ $clientName }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="sig-line-block">
                            <div class="sig-lbl">Authorised by</div>
                            <div class="sig-nm">{{ $preparedBy }}<br><span
                                    style="font-size:8.5pt;font-weight:normal;color:#8a92a0;">Cheadle Construction
                                    Ltd</span></div>
                        </div>
                    </td>
                </tr>
            </table>

            <table class="page-foot-table">
                <tr>
                    <td><span class="pf-brand-name">Cheadle Construction Ltd</span></td>
                    <td style="text-align:right;">Page 4 of 5</td>
                </tr>
            </table>
        </div>
    @endif

    <div class="page-break"></div>

    {{-- ═══════════════════════════════════
    PAGE 5 — PROJECT NOTES
    ═══════════════════════════════════ --}}
    <div class="accent-bar"></div>

    <div class="inner-wrap">
        <table class="inner-header-table">
            <tr>
                <td>@if($logoBase64)<img src="{{ $logoBase64 }}" class="inner-logo" alt="">@endif</td>
                <td class="inner-page-title">Project Notes</td>
            </tr>
        </table>

        <div class="pn-title-text">Cheadle Construction <span>Project Notes</span></div>
        <div style="height:2px;background:#f0f2f5;margin:14px 0 20px;"></div>

        <div class="pn-section-title">General Notes &amp; Exclusions</div>
        <table class="pn-item-table">
            <tr>
                <td class="pn-bullet">&rsaquo;</td>
                <td>No allowance for floor covering at this stage unless stated otherwise.</td>
            </tr>
            <tr>
                <td class="pn-bullet">&rsaquo;</td>
                <td>Substructures are based on assumed good ground conditions and are without the benefit of a
                    geological survey. The depths of foundation and design may be subject to change by site conditions
                    and/or on the instruction of Building Control, client&rsquo;s Engineer or Architect. In the event of
                    change of foundation design the Contractor reserves the right to amend the Contract Sum by way of
                    re-measurement.</td>
            </tr>
            <tr>
                <td class="pn-bullet">&rsaquo;</td>
                <td>All waste to be disposed of.</td>
            </tr>
            <tr>
                <td class="pn-bullet">&rsaquo;</td>
                <td>Structural costs are subject to engineer&rsquo;s design/Calcs if not presented prior to costing.
                </td>
            </tr>
            <tr>
                <td class="pn-bullet">&rsaquo;</td>
                <td>No allowance for landscaping at this stage but have allowed to infill excavated areas with MOT.</td>
            </tr>
            <tr>
                <td class="pn-bullet">&rsaquo;</td>
                <td>No allowance for kitchen or utility purchase.</td>
            </tr>
            <tr>
                <td class="pn-bullet">&rsaquo;</td>
                <td>We have assumed that the existing RCD Board / Consumer Unit is suitable to remain.</td>
            </tr>
            <tr>
                <td class="pn-bullet">&rsaquo;</td>
                <td>No allowance for Building Control services at this stage but can be arranged at cost.</td>
            </tr>
            <tr>
                <td class="pn-bullet">&rsaquo;</td>
                <td>External drainage subject to inspection and final layout might differ from drawings.</td>
            </tr>
            <tr>
                <td class="pn-bullet">&rsaquo;</td>
                <td>Best endeavours to protect driveways from damage &mdash; we accept no responsibility. Once
                    protection is in place, any concerns please report to a member of staff.</td>
            </tr>
        </table>

        <div class="pn-section-title">Structural Works &mdash; Deflection, Movement and Settlement</div>
        <p class="pn-text">Whilst great care will be taken by our time served tradesmen, a tolerance for deflection,
            movement and settlement is to be expected during and following completion of structural works. This could
            result in settlement cracking to localised areas and damage to decor away from the work area. We will work
            with the client to address these issues at cost in the rare event remedial works are required.</p>

        <div class="pn-section-title">Dust Settlement</div>
        <p class="pn-text">Due to the nature of these works there may be residual dust settlement. Whilst we make best
            endeavours to keep the area clean, we cannot guarantee additional cleaning won&rsquo;t be required.</p>

        <div class="pn-section-title">Building Control</div>
        <p class="pn-text">These works are notifiable under building control laws. We can handle the application on the
            client&rsquo;s behalf, subject to fee quoted by our provider.</p>

        <div class="pn-section-title">Payments</div>
        <p class="pn-text">A payment schedule and FMB contract will be provided upon acceptance. Final payment is to be
            made once we reach the final build stage, regardless of any delays outside our control.</p>

        <table class="page-foot-table">
            <tr>
                <td><span class="pf-brand-name">Cheadle Construction Ltd</span> &middot; Registered &middot; Insured
                    &middot; FMB Member &middot; TrustMark Registered</td>
                <td style="text-align:right;">Page 5 of 5</td>
            </tr>
        </table>
    </div>

</body>

</html>