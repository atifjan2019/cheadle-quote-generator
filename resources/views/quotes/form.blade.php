@extends('layouts.app')

@section('title')
    {{ $isEdit ? 'Edit — ' . e($quote->project_ref ?? '') : 'New Quote' }} — Cheadle Construction
@endsection

@section('nav-form', 'active')
@section('nav-form-label', $isEdit ? 'Edit Quote' : 'New Quote')

@section('sidebar-promo-content')
    <h4>Live Builder</h4>
    <p>Edit left, preview right</p>
    <a href="{{ route('quotes.index') }}">← Dashboard</a>
@endsection

@section('content')
    @php
        $dateVal = $isEdit ? $quote->date->format('Y-m-d') : date('Y-m-d');
    @endphp

    <div class="main builder-main">

        <!-- Breadcrumb bar -->
        <div class="builder-breadcrumb" style="flex-shrink:0;">
            <a href="{{ route('quotes.index') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <span class="breadcrumb-sep">/</span>
            <a href="{{ route('quotes.list') }}">All Quotes</a>
            <span class="breadcrumb-sep">/</span>
            <span class="breadcrumb-current">{{ $isEdit ? e($quote->project_ref ?? 'Edit Quote') : 'New Quote' }}</span>

        </div>

        <!-- ══ SPLIT LAYOUT ══════════════════════════ -->
        <form id="quoteForm" action="{{ route('quotes.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($isEdit)<input type="hidden" name="id" value="{{ $id }}">@endif

            <div class="builder-layout">

                <!-- LEFT — FORM PANE -->
                <div class="builder-form-pane">
                    <div class="builder-form-inner">

                        <!-- SECTION 1: Project Details -->
                        <div class="fs-card">
                            <div class="fs-card-header" onclick="toggleSection(this)">
                                <h3><span class="sec-icon" style="background:#ffe4e8;">🏗️</span> Project Details</h3>
                                <svg class="fs-chevron open" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24" width="16" height="16">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </div>
                            <div class="fs-card-body">
                                <div class="fg">
                                    <div class="form-group">
                                        <label>Date *</label>
                                        <input type="date" id="f_date" name="date" value="{{ e($dateVal) }}" required
                                            oninput="syncFieldToPreview('f_date','p_date','date')">
                                    </div>
                                    <div class="form-group">
                                        <label>Project Reference *</label>
                                        <input type="text" id="f_project_ref" name="project_ref"
                                            value="{{ e($quote['project_ref'] ?? '') }}" placeholder="e.g. RES.128/2025"
                                            required oninput="syncFieldToPreview('f_project_ref','p_project_ref','text')">
                                    </div>
                                    <div class="form-group">
                                        <label>Client Name(s) *</label>
                                        <input type="text" id="f_client_name" name="client_name"
                                            value="{{ e($quote['client_name'] ?? '') }}" placeholder="e.g. Jason & Julie"
                                            required oninput="syncFieldToPreview('f_client_name','p_client_name','text')">
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select id="f_status" name="status" onchange="markUnsaved()">
                                            @foreach(['draft', 'sent', 'accepted', 'declined'] as $s)
                                                <option value="{{ $s }}" {{ ($quote['status'] ?? 'draft') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group fg-full">
                                        <label>Client Address</label>
                                        <textarea id="f_client_address" name="client_address"
                                            placeholder="12 Orchard Vale&#10;Stockport&#10;SK3 9RS"
                                            oninput="syncFieldToPreview('f_client_address','p_client_address','textarea')">{{ e($quote['client_address'] ?? '') }}</textarea>
                                    </div>
                                    <div class="form-group fg-full">
                                        <label>Project Description</label>
                                        <textarea id="f_project_description" name="project_description"
                                            placeholder="Single storey rear extension..."
                                            oninput="syncFieldToPreview('f_project_description','p_project_description','textarea')">{{ e($quote['project_description'] ?? '') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Architect</label>
                                        <input type="text" id="f_architect" name="architect"
                                            value="{{ e($quote['architect'] ?? 'Not yet appointed') }}"
                                            oninput="syncFieldToPreview('f_architect','p_architect','text')">
                                    </div>
                                    <div class="form-group">
                                        <label>Structural Engineer</label>
                                        <input type="text" id="f_structural_engineer" name="structural_engineer"
                                            value="{{ e($quote['structural_engineer'] ?? 'Not yet appointed') }}"
                                            oninput="syncFieldToPreview('f_structural_engineer','p_structural_engineer','text')">
                                    </div>
                                    <div class="form-group">
                                        <label>Prepared By</label>
                                        <input type="text" id="f_prepared_by" name="prepared_by"
                                            value="{{ e($quote['prepared_by'] ?? 'Joanne Fowler') }}"
                                            oninput="syncFieldToPreview('f_prepared_by','p_prepared_by','text')">
                                    </div>
                                    <div class="form-group fg-full">
                                        <label>Project Photo <span style="font-weight:400;color:var(--text-muted);">(appears
                                                in PDF — optional)</span></label>
                                        @if(!empty($quote['project_photo']))
                                            <div style="margin-bottom:8px;">
                                                <img src="{{ asset('uploads/' . $quote['project_photo']) }}"
                                                    style="height:80px;border-radius:6px;border:1px solid var(--border);"
                                                    alt="Current photo">
                                                <span style="font-size:11px;color:var(--text-muted);margin-left:8px;">Current
                                                    photo (upload a new one to replace)</span>
                                            </div>
                                        @endif
                                        <input type="file" id="f_project_photo" name="project_photo"
                                            accept="image/jpeg,image/png" onchange="markUnsaved();previewPhoto(this)"
                                            style="padding:6px 0;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: Revision Notes -->
                        <div class="fs-card">
                            <div class="fs-card-header" onclick="toggleSection(this)">
                                <h3><span class="sec-icon" style="background:#dbeafe;">📋</span> Revision Notes</h3>
                                <svg class="fs-chevron open" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24" width="16" height="16">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </div>
                            <div class="fs-card-body">
                                <p style="font-size:11px;color:var(--text-muted);margin-bottom:10px;">These appear as bullet
                                    points on the Scope of Work intro page.</p>
                                <div class="notes-list" id="notesList">
                                    @if($isEdit && count($notes))
                                        @foreach($notes as $n)
                                            <div class="note-row">
                                                <input type="text" name="notes[]" value="{{ e($n['note_text']) }}"
                                                    placeholder="Bullet point..." oninput="renderPreview()">
                                                <label class="bl"><input type="checkbox" name="notes_bold[]" value="1" {{ $n['is_bold'] ? 'checked' : '' }} onchange="renderPreview()"> Bold</label>
                                                <button type="button" class="rm-btn"
                                                    onclick="this.parentElement.remove();renderPreview()">✕</button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="note-row">
                                            <input type="text" name="notes[]"
                                                value="Two storey extension to the side of the property running to the full length of the existing house."
                                                placeholder="Bullet point..." oninput="renderPreview()">
                                            <label class="bl"><input type="checkbox" name="notes_bold[]" value="1"
                                                    onchange="renderPreview()"> Bold</label>
                                            <button type="button" class="rm-btn"
                                                onclick="this.parentElement.remove();renderPreview()">✕</button>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline btn-sm" style="margin-top:10px;width:100%;"
                                    onclick="addNote()">+ Add Bullet Point</button>
                            </div>
                        </div>

                        <!-- SECTION 3: Scope of Work -->
                        <div class="fs-card">
                            <div class="fs-card-header" onclick="toggleSection(this)">
                                <h3><span class="sec-icon" style="background:#fef3c7;">🔨</span> Scope of Work</h3>
                                <svg class="fs-chevron" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24" width="16" height="16">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </div>
                            <div class="fs-card-body collapsed" style="padding:0 16px 14px;">
                                <p style="font-size:11px;color:var(--text-muted);padding:12px 0 8px;">Quick-add a service
                                    group, or add rows manually below.</p>
                                <div class="service-groups">
                                    @foreach(array_keys($serviceGroups) as $grp)
                                        <button type="button" class="sg-chip"
                                            onclick="addServiceGroup('{{ addslashes($grp) }}')">{{ $grp }}</button>
                                    @endforeach
                                </div>

                                <div class="scope-cards" id="scopeBody">
                                    @foreach($rows as $sec)
                                        @php
                                            $secName = is_array($sec) ? ($sec['section_name'] ?? '') : ($sec->section_name ?? '');
                                            $secDesc = is_array($sec) ? ($sec['section_description'] ?? '') : ($sec->section_description ?? '');
                                            $secHdg = is_array($sec) ? ($sec['is_heading'] ?? false) : ($sec->is_heading ?? false);
                                        @endphp
                                        <div class="scope-card">
                                            <div class="scope-card-fields">
                                                <input type="text" class="sn scope-card-name" name="sec_name[]"
                                                    value="{{ e($secName) }}" placeholder="Section / Trade name..." oninput="renderPreview()">
                                                <textarea class="sd scope-card-desc" name="sec_desc[]"
                                                    placeholder="Description..." oninput="renderPreview()">{{ e($secDesc) }}</textarea>
                                            </div>
                                            <div class="scope-card-actions">
                                                <label class="scope-toggle" title="Show in PDF">
                                                    <input type="checkbox" name="sec_visible[]" value="1" {{ ($isEdit && count($sections)) ? 'checked' : '' }}
                                                        onchange="renderPreview()">
                                                    <span class="scope-toggle-slider"></span>
                                                    <span class="scope-toggle-label">PDF</span>
                                                </label>
                                                <button type="button" class="scope-card-del"
                                                    onclick="this.closest('.scope-card').remove();renderPreview()" title="Remove">✕</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" class="btn btn-outline btn-sm" style="margin-top:10px;width:100%;"
                                    onclick="addScopeRow()">+ Add Row</button>
                            </div>
                        </div>

                        <!-- SECTION 4: Pricing & Totals -->
                        <div class="fs-card">
                            <div class="fs-card-header" onclick="toggleSection(this)">
                                <h3><span class="sec-icon" style="background:#dcfce7;">£</span> Pricing & Totals</h3>
                                <svg class="fs-chevron open" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24" width="16" height="16">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </div>
                            <div class="fs-card-body">
                                <div class="fg">
                                    <div class="form-group">
                                        <label>Base Cost Label</label>
                                        <input type="text" id="f_base_cost_label" name="base_cost_label"
                                            value="{{ e($pricing['base_cost_label'] ?? 'Single storey as per drawings') }}"
                                            oninput="renderPreview()">
                                    </div>
                                    <div class="form-group">
                                        <label>Base Cost (£ inc. VAT)</label>
                                        <input type="number" id="f_base_cost" name="base_cost"
                                            value="{{ e($pricing['base_cost'] ?? '') }}" placeholder="88000" step="1"
                                            oninput="renderPreview()">
                                    </div>
                                    <div class="form-group">
                                        <label>Additional Cost Label</label>
                                        <input type="text" id="f_additional_cost_label" name="additional_cost_label"
                                            value="{{ e($pricing['additional_cost_label'] ?? 'Additional cost for two storey side elevation') }}"
                                            oninput="renderPreview()">
                                    </div>
                                    <div class="form-group">
                                        <label>Additional Cost (£ inc. VAT)</label>
                                        <input type="number" id="f_additional_cost" name="additional_cost"
                                            value="{{ e($pricing['additional_cost'] ?? '') }}" placeholder="38000" step="1"
                                            oninput="renderPreview()">
                                    </div>
                                    <div class="form-group">
                                        <label>Total Cost Label</label>
                                        <input type="text" id="f_total_cost_label" name="total_cost_label"
                                            value="{{ e($pricing['total_cost_label'] ?? 'Total cost revised quotation') }}"
                                            oninput="renderPreview()">
                                    </div>
                                    <div class="form-group">
                                        <label>Total Cost (£ inc. VAT)</label>
                                        <input type="number" id="f_total_cost" name="total_cost"
                                            value="{{ e($pricing['total_cost'] ?? '') }}" placeholder="126000" step="1"
                                            oninput="renderPreview()">
                                    </div>
                                    <div class="form-group fg-full">
                                        <label>Price Breakdown (one item per line)</label>
                                        <textarea id="f_price_breakdown" name="price_breakdown"
                                            oninput="renderPreview()">{{ e($pricing['price_breakdown'] ?? '') }}</textarea>
                                    </div>
                                    <div class="form-group fg-full">
                                        <label>Notes / Terms</label>
                                        <textarea id="f_notes_pricing" name="notes_pricing"
                                            oninput="renderPreview()">{{ e($pricing['notes'] ?? "All certification supplied upon completion.\nDuration of work 12/14 weeks approximately\nSchedule of work provided upon acceptance; payment is via a stage payment contract.\nCheadle Construction Ltd are fully insured and supply a copy of our insurance upon request.") }}</textarea>
                                    </div>
                                    <div class="form-group fg-full">
                                        <label>Not Included in Price (one per line)</label>
                                        <textarea id="f_exclusions" name="exclusions"
                                            oninput="renderPreview()">{{ e($pricing['exclusions'] ?? "Boiler\nInternal doors\nRadiators\nKitchen\nUtility\nW/C furniture\nFinished floor coverings") }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- /builder-form-inner -->

                    <!-- Action bar -->
                    <div class="builder-actions">
                        <button type="submit" class="btn btn-primary">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="15"
                                height="15">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z" />
                                <path d="M17 21v-8H7v8M7 3v5h8" />
                            </svg>
                            Save Quote
                        </button>

                        <a href="{{ route('quotes.index') }}" class="btn btn-outline">Cancel</a>
                        <div class="autosave-bar">
                            <div class="autosave-dot" id="autosaveDot"></div>
                            <span id="autosaveText">All changes saved</span>
                        </div>
                    </div>
                </div><!-- /builder-form-pane -->


                <!-- RIGHT — LIVE PREVIEW PANE -->
                <div class="builder-preview-pane">
                    <div class="preview-toolbar">
                        <div class="pt-title">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="16"
                                height="16">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            Live Preview
                        </div>
                        <span class="pt-badge">✏️ Click any text in the preview to edit it directly</span>
                        <div class="preview-toolbar-actions">
                            @if($isEdit)
                                <a href="{{ route('quotes.pdf', ['id' => $id]) }}" class="btn btn-primary btn-sm"
                                    target="_blank">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="13"
                                        height="13">
                                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" />
                                    </svg>
                                    Download PDF
                                </a>
                            @else
                                <span style="font-size:11px;color:var(--text-muted);">Save first to download PDF</span>
                            @endif
                        </div>
                    </div>

                    <div class="preview-scroll-wrap">
                        <div class="preview-scroll">
                            <div class="preview-doc" id="previewDoc">

                                <!-- PAGE 1: COVER -->
                                <div class="pdoc-page">
                                    <div class="pdoc-accent-bar"></div>
                                    <div class="pdoc-cover-header">
                                        <table class="pdoc-logo-tbl">
                                            <tr>
                                                <td><img src="{{ asset('assets/img/logo.png') }}" class="pdoc-cover-logo"
                                                        alt="CC"></td>
                                                <td style="text-align:right;vertical-align:middle;">
                                                    <div class="pdoc-cover-brand">Cheadle <span>Construction</span></div>
                                                    <div class="pdoc-cover-tagline">Building Excellence &middot; Greater
                                                        Manchester</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="pdoc-cover-hero">
                                        <div class="pdoc-doc-label">Formal Quotation</div>
                                        <div class="pdoc-doc-title">QUOTATION</div>
                                        <div class="pdoc-doc-ref">Ref:&nbsp;<span
                                                id="p_project_ref_hdr">{{ e($quote['project_ref'] ?? '') }}</span>&nbsp;&middot;&nbsp;<span
                                                id="p_date_hdr">{{ $isEdit ? $quote->date->format('d/m/Y') : date('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="pdoc-cover-divider"></div>
                                    <table class="pdoc-meta-tbl">
                                        <tr>
                                            <td>
                                                <span class="pdoc-meta-lbl">Date</span>
                                                <span class="pdoc-meta-val" id="p_date" contenteditable="true"
                                                    data-placeholder="dd/mm/yyyy" data-field="f_date" data-type="date"
                                                    onblur="syncPreviewToField(this)">
                                                    {{ $isEdit ? $quote->date->format('d/m/Y') : date('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="pdoc-meta-lbl">Reference</span>
                                                <span class="pdoc-meta-val" id="p_project_ref" contenteditable="true"
                                                    data-placeholder="e.g. RES.128/2025" data-field="f_project_ref"
                                                    data-type="text" onblur="syncPreviewToField(this)">
                                                    {{ e($quote['project_ref'] ?? '') }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="pdoc-meta-lbl">Prepared By</span>
                                                <span class="pdoc-meta-val" id="p_prepared_by" contenteditable="true"
                                                    data-placeholder="Name" data-field="f_prepared_by" data-type="text"
                                                    onblur="syncPreviewToField(this)">
                                                    {{ e($quote['prepared_by'] ?? 'Joanne Fowler') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="pdoc-meta-lbl">Status</span>
                                                <span class="pdoc-meta-val" id="p_status" style="color:#C8102E;">
                                                    {{ e(ucfirst($quote['status'] ?? 'Quotation')) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="pdoc-cover-client">
                                        <div class="pdoc-cl-lbl">Prepared For</div>
                                        <div class="pdoc-cl-name" id="p_client_name" contenteditable="true"
                                            data-placeholder="Client Name" data-field="f_client_name" data-type="text"
                                            onblur="syncPreviewToField(this)">
                                            {{ e($quote['client_name'] ?? '') }}
                                        </div>
                                        <div class="pdoc-cl-addr" id="p_client_address" contenteditable="true"
                                            data-placeholder="Address..." data-field="f_client_address" data-type="textarea"
                                            onblur="syncPreviewToField(this)">
                                            {{ e($quote['client_address'] ?? '') }}
                                        </div>
                                    </div>
                                    <table class="pdoc-project-tbl">
                                        <tr>
                                            <td class="pdoc-proj-lbl">Project</td>
                                            <td id="p_project_description" contenteditable="true"
                                                data-placeholder="Describe the project..."
                                                data-field="f_project_description" data-type="textarea"
                                                onblur="syncPreviewToField(this)">
                                                {{ e($quote['project_description'] ?? '') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pdoc-proj-lbl">Architect</td>
                                            <td id="p_architect" contenteditable="true"
                                                data-placeholder="e.g. HED Architecture" data-field="f_architect"
                                                data-type="text" onblur="syncPreviewToField(this)">
                                                {{ e($quote['architect'] ?? 'Not yet appointed') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pdoc-proj-lbl">Structural Engineer</td>
                                            <td id="p_structural_engineer" contenteditable="true"
                                                data-placeholder="e.g. Not yet appointed" data-field="f_structural_engineer"
                                                data-type="text" onblur="syncPreviewToField(this)">
                                                {{ e($quote['structural_engineer'] ?? 'Not yet appointed') }}
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="pdoc-photo-placeholder" id="p_photo_preview" style="display:none;">
                                        <img id="p_photo_img" src="" alt="Project photo" class="pdoc-cover-photo">
                                    </div>
                                    <div class="pdoc-cover-footer">
                                        <table class="pdoc-foot-tbl">
                                            <tr>
                                                <td><strong>Cheadle Construction Ltd</strong> &middot; Building Excellence,
                                                    Greater Manchester</td>
                                                <td style="text-align:right;">Page 1 of 7 &nbsp;&middot;&nbsp; <span
                                                        id="p_ref_foot1">{{ e($quote['project_ref'] ?? '') }}</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- PAGE 2: SCOPE OF WORK -->
                                <div class="pdoc-page">
                                    <div class="pdoc-accent-bar"></div>
                                    <div class="pdoc-inner-page">
                                        <table class="pdoc-inner-header">
                                            <tr>
                                                <td><img src="{{ asset('assets/img/logo.png') }}" class="pdoc-inner-logo"
                                                        alt=""></td>
                                                <td class="pdoc-inner-title">Scope of Work</td>
                                            </tr>
                                        </table>
                                        <div class="pdoc-sec-heading">Revision Notes</div>
                                        <p class="pdoc-rn-intro">This quotation has been revised as of <strong id="p_date2"
                                                style="color:#C8102E;">{{ $isEdit ? $quote->date->format('d/m/Y') : date('d/m/Y') }}</strong>
                                            to include the following changes:</p>
                                        <ul class="pdoc-rn-list" id="p_notes_list"></ul>
                                        <table class="pdoc-foot-tbl" style="margin-top:40px;">
                                            <tr>
                                                <td><strong>Cheadle Construction Ltd</strong></td>
                                                <td style="text-align:right;">Page 2 of 7</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- PAGE 3: SPECIFICATION -->
                                <div class="pdoc-page">
                                    <div class="pdoc-accent-bar"></div>
                                    <div class="pdoc-inner-page">
                                        <table class="pdoc-inner-header">
                                            <tr>
                                                <td><img src="{{ asset('assets/img/logo.png') }}" class="pdoc-inner-logo"
                                                        alt=""></td>
                                                <td class="pdoc-inner-title">Specification</td>
                                            </tr>
                                        </table>
                                        <div class="pdoc-sec-heading">Scope &amp; Specification</div>
                                        <table class="pdoc-scope-tbl" id="p_scope_table"></table>
                                        <table class="pdoc-foot-tbl" style="margin-top:32px;">
                                            <tr>
                                                <td><strong>Cheadle Construction Ltd</strong></td>
                                                <td style="text-align:right;">Page 3 of 7</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- PAGE 4: PRICING -->
                                <div class="pdoc-page" id="p_pricing_page">
                                    <div class="pdoc-accent-bar"></div>
                                    <div class="pdoc-inner-page">
                                        <table class="pdoc-inner-header">
                                            <tr>
                                                <td><img src="{{ asset('assets/img/logo.png') }}" class="pdoc-inner-logo"
                                                        alt=""></td>
                                                <td class="pdoc-inner-title">Pricing</td>
                                            </tr>
                                        </table>
                                        <div class="pdoc-sec-heading">Pricing Summary</div>
                                        <table class="pdoc-price-tbl" id="p_pricing_table"></table>
                                        <p class="pdoc-valid-note">This quotation is valid for 30 days. A payment schedule
                                            and FMB contract will be provided upon acceptance.</p>
                                        <table class="pdoc-sig-tbl">
                                            <tr>
                                                <td>
                                                    <div class="pdoc-sig-line">
                                                        <div class="pdoc-sig-label">Client Signature &amp; Date</div>
                                                        <div class="pdoc-sig-name" id="p_sig_client">
                                                            {{ e($quote['client_name'] ?? '') }}</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="pdoc-sig-line">
                                                        <div class="pdoc-sig-label">Authorised by</div>
                                                        <div class="pdoc-sig-name">
                                                            {{ e($quote['prepared_by'] ?? 'Joanne Fowler') }}<br><small
                                                                style="font-size:7.5pt;font-weight:normal;color:#888;">Cheadle
                                                                Construction Ltd</small></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="pdoc-foot-tbl" style="margin-top:32px;">
                                            <tr>
                                                <td><strong>Cheadle Construction Ltd</strong></td>
                                                <td style="text-align:right;">Page 4 of 7</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- PAGE 5: FMB CERTIFICATE 1 -->
                                <div class="pdoc-page">
                                    <div class="pdoc-accent-bar"></div>
                                    <div class="pdoc-inner-page">
                                        <table class="pdoc-inner-header">
                                            <tr>
                                                <td><img src="{{ asset('assets/img/logo.png') }}" class="pdoc-inner-logo" alt=""></td>
                                                <td class="pdoc-inner-title">FMB Membership</td>
                                            </tr>
                                        </table>
                                        <div style="text-align:center;padding:20px 0;">
                                            <img src="{{ asset('assets/img/fmb-certificate-1.jpg') }}" style="max-width:100%;max-height:750px;width:auto;height:auto;" alt="FMB Membership Certificate">
                                        </div>
                                        <table class="pdoc-foot-tbl" style="margin-top:32px;">
                                            <tr>
                                                <td><strong>Cheadle Construction Ltd</strong></td>
                                                <td style="text-align:right;">Page 5 of 7</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- PAGE 6: FMB CERTIFICATE 2 -->
                                <div class="pdoc-page">
                                    <div class="pdoc-accent-bar"></div>
                                    <div class="pdoc-inner-page">
                                        <table class="pdoc-inner-header">
                                            <tr>
                                                <td><img src="{{ asset('assets/img/logo.png') }}" class="pdoc-inner-logo" alt=""></td>
                                                <td class="pdoc-inner-title">FMB Membership</td>
                                            </tr>
                                        </table>
                                        <div style="text-align:center;padding:20px 0;">
                                            <img src="{{ asset('assets/img/fmb-certificate-2.jpg') }}" style="max-width:100%;max-height:750px;width:auto;height:auto;" alt="FMB Membership Certificate">
                                        </div>
                                        <table class="pdoc-foot-tbl" style="margin-top:32px;">
                                            <tr>
                                                <td><strong>Cheadle Construction Ltd</strong></td>
                                                <td style="text-align:right;">Page 6 of 7</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- PAGE 7: PROJECT NOTES -->
                                <div class="pdoc-page">
                                    <div class="pdoc-accent-bar"></div>
                                    <div class="pdoc-inner-page">
                                        <table class="pdoc-inner-header">
                                            <tr>
                                                <td><img src="{{ asset('assets/img/logo.png') }}" class="pdoc-inner-logo"
                                                        alt=""></td>
                                                <td class="pdoc-inner-title">Project Notes</td>
                                            </tr>
                                        </table>
                                        <div class="pdoc-pn-title">Cheadle Construction <span>Project Notes</span></div>
                                        <div style="height:1px;background:#e0e0e0;margin:12px 0 16px;"></div>
                                        <div class="pdoc-pn-section">General Notes &amp; Exclusions</div>
                                        <div class="pdoc-pn-item">No allowance for floor covering at this stage unless
                                            stated otherwise.</div>
                                        <div class="pdoc-pn-item">Substructures are based on assumed good ground conditions
                                            and are without the benefit of a geological survey; The depths of foundation and foundation design may be subject to change by
                                            site conditions and/or on the instruction of Building Control or clients Engineer or Architect. In the
                                            event of change of design and/or depth of foundation the Contractor reserves the right to amend
                                            the Contract Sum by way of re-measurement of the revised foundation design and depth.</div>
                                        <div class="pdoc-pn-item">All waste to be disposed of</div>
                                        <div class="pdoc-pn-item">Structural costs are subject to engineer's design/Calcs if
                                            not presented prior to costing.</div>
                                        <div class="pdoc-pn-item">No allowance for landscaping at this stage but have
                                            allowed to infill excavated areas with MOT</div>
                                        <div class="pdoc-pn-item">Please note we have not allowed for any re screeding of floor levels at this stage, unless stated
                                            otherwise.</div>
                                        <div class="pdoc-pn-item">No allowance for kitchen or utility purchase</div>
                                        <div class="pdoc-pn-item">We have assumed that the existing RCD Board / Consumer
                                            Unit is suitable to remain</div>
                                        <div class="pdoc-pn-item">No allowance for Building Control services at this stage
                                            but can be arranged at cost</div>
                                        <div class="pdoc-pn-item">External drainage subject to inspection and final layout might differ from drawings.</div>
                                        <div class="pdoc-pn-item">Best endeavours to protect driveways from damage we accept no reasonability for damage.
                                            Once protection is in place any concerns please report to a member of staff</div>
                                        <div class="pdoc-pn-section">Undertaking Structural Works &mdash; Deflection, Movement and
                                            Settlement</div>
                                        <p class="pdoc-pn-text">Please note that whilst great care will be taken by our time served
                                            tradesmen to undertake these works, with all structural works, a tolerance for deflection, movement
                                            and settlement is to be expected during and following the completion of the works.
                                            This could result in the appearance of settlement cracking to localised areas and
                                            damage to decor in areas away from the work area. In some cases, easing of doors to
                                            the floor above the work area might be required.</p>
                                        <p class="pdoc-pn-text">Whilst we have not allowed for these issues in our cost, we will work with the client to
                                            address these issues at cost in the rare event that remedial works are required.
                                            If you have any concerns, please just ask a member of our team.</p>
                                        <div class="pdoc-pn-section">Dust Settlement</div>
                                        <p class="pdoc-pn-text">Please note, due to the nature of these works there may be some residual dust
                                            settlement. Whilst we will make best endeavours to keep the area clean, we can't
                                            guarantee that additional cleaning won't be required.</p>
                                        <div class="pdoc-pn-section">Building Control</div>
                                        <p class="pdoc-pn-text">Please note that these works are notifiable under building control laws &mdash; We can handle the
                                            application on the client's behalf subject to fee quoted by our provider.</p>
                                        <div class="pdoc-pn-section">Payments</div>
                                        <p class="pdoc-pn-text"><strong>Payments</strong> &ndash; A payment schedule will be provided, along with an FMB contract upon acceptance of the
                                            quotation. Final payment is to be paid in line with schedule, however, sometimes circumstances out
                                            of our control may affect the completion of your project, eg delays in kitchen appliances, building
                                            control to issue certificates and other services not provided by ourselves.</p>
                                        <p class="pdoc-pn-text">Final payment is to be made once we reach the final build stage regardless of these circumstances.</p>
                                        <table class="pdoc-foot-tbl" style="margin-top:32px;">
                                            <tr>
                                                <td><strong>Cheadle Construction Ltd</strong> &middot; Registered &middot;
                                                    Insured &middot; FMB Member &middot; TrustMark Registered</td>
                                                <td style="text-align:right;">Page 7 of 7</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div><!-- /preview-doc -->
                        </div><!-- /preview-scroll -->
                    </div><!-- /preview-scroll-wrap -->
                </div><!-- /builder-preview-pane -->

            </div><!-- /builder-layout -->
        </form>
    </div><!-- /main -->
@endsection

@push('scripts')
    <script>
        // Service group data
        const serviceGroups = @json($serviceGroups);

        // Accordion toggle
        function toggleSection(header) {
            const body = header.nextElementSibling;
            const chevron = header.querySelector('.fs-chevron');
            body.classList.toggle('collapsed');
            chevron.classList.toggle('open');
        }

        // Autosave indicator
        function markUnsaved() {
            const dot = document.getElementById('autosaveDot');
            const txt = document.getElementById('autosaveText');
            dot.className = 'autosave-dot unsaved';
            txt.textContent = 'Unsaved changes';
        }

        // input/change listeners are attached below with the auto-save logic
        document.getElementById('quoteForm').addEventListener('submit', () => {
            document.getElementById('autosaveDot').className = 'autosave-dot saving';
            document.getElementById('autosaveText').textContent = 'Saving…';
        });

        // Form → Preview sync
        function fmtDate(v) {
            if (!v) return '';
            const parts = v.split('-');
            if (parts.length === 3) return parts[2] + '/' + parts[1] + '/' + parts[0];
            return v;
        }

        function setText(id, txt) {
            const el = document.getElementById(id);
            if (el) el.textContent = txt;
        }

        function syncAllFieldsToPreview() {
            const dateRaw = (document.getElementById('f_date') || {}).value || '';
            const dateFmt = fmtDate(dateRaw);
            setText('p_date', dateFmt);
            setText('p_date_hdr', dateFmt);
            setText('p_date2', dateFmt);

            const ref = (document.getElementById('f_project_ref') || {}).value || '';
            setText('p_project_ref', ref);
            setText('p_project_ref_hdr', ref);
            setText('p_ref_foot1', ref);

            const cname = (document.getElementById('f_client_name') || {}).value || '';
            setText('p_client_name', cname);
            setText('p_sig_client', cname);

            const caddrEl = document.getElementById('p_client_address');
            const caddrVal = (document.getElementById('f_client_address') || {}).value || '';
            if (caddrEl) caddrEl.textContent = caddrVal;

            const statusEl = document.getElementById('f_status');
            const statusVal = statusEl ? statusEl.options[statusEl.selectedIndex].text : '';
            setText('p_status', statusVal);

            const pdescEl = document.getElementById('p_project_description');
            const pdescVal = (document.getElementById('f_project_description') || {}).value || '';
            if (pdescEl) pdescEl.textContent = pdescVal;

            setText('p_architect', (document.getElementById('f_architect') || {}).value || '');
            setText('p_structural_engineer', (document.getElementById('f_structural_engineer') || {}).value || '');
            setText('p_prepared_by', (document.getElementById('f_prepared_by') || {}).value || '');

            renderNotesList();
            renderScopeTable();
            renderPricingTable();
        }

        function syncFieldToPreview() { syncAllFieldsToPreview(); }

        // Preview → Form sync
        function syncPreviewToField(el) {
            const formId = el.getAttribute('data-field');
            const type = el.getAttribute('data-type');
            const formEl = document.getElementById(formId);
            if (!formEl) return;
            let v = el.innerText.trim();
            if (type === 'date') {
                const parts = v.split('/');
                if (parts.length === 3) v = parts[2] + '-' + parts[1] + '-' + parts[0];
            }
            formEl.value = v;
            markUnsaved();
            syncAllFieldsToPreview();
        }

        function renderNotesList() {
            const ul = document.getElementById('p_notes_list');
            if (!ul) return;
            const rows = document.querySelectorAll('#notesList .note-row');
            let html = '';
            rows.forEach(function (row) {
                const txt = (row.querySelector('input[type=text]') || {}).value;
                const bold = row.querySelector('input[type=checkbox]') && row.querySelector('input[type=checkbox]').checked;
                if (!txt || !txt.trim()) return;
                html += '<li' + (bold ? ' style="font-weight:700;"' : '') + '>' + escHtml(txt.trim()) + '</li>';
            });
            ul.innerHTML = html || '<li style="color:#ccc;font-style:italic;">No revision notes added.</li>';
        }

        function renderScopeTable() {
            var tbl = document.getElementById('p_scope_table');
            if (!tbl) return;
            var cards = document.querySelectorAll('#scopeBody .scope-card');
            var html = '';
            cards.forEach(function (card) {
                var nameEl = card.querySelector('input.sn');
                var descEl = card.querySelector('textarea.sd');
                var visEl = card.querySelector('input[type=checkbox]');
                var name = nameEl ? nameEl.value.trim() : '';
                var desc = descEl ? descEl.value.trim() : '';
                var visible = visEl && visEl.checked;
                if (!name || !visible) return;
                var safeName = name.replace(/</g, '&lt;').replace(/>/g, '&gt;');
                var safeDesc = desc.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br>');
                if (!desc) {
                    html += '<tr class="scope-group"><td colspan="2">' + safeName + '</td></tr>';
                } else {
                    html += '<tr class="scope-row"><td class="scope-label">' + safeName + '</td><td>' + safeDesc + '</td></tr>';
                }
            });
            tbl.innerHTML = html || '<tr><td colspan="2" style="color:#bbb;padding:12px;text-align:center;font-size:8pt;font-style:italic;">No scope sections added yet.</td></tr>';
        }

        function renderPricingTable() {
            var tbl = document.getElementById('p_pricing_table');
            if (!tbl) return;
            function gv(id) { var el = document.getElementById(id); return el ? el.value : ''; }
            var baseLabel = gv('f_base_cost_label');
            var baseCost = parseFloat(gv('f_base_cost')) || 0;
            var addLabel = gv('f_additional_cost_label');
            var addCost = parseFloat(gv('f_additional_cost')) || 0;
            var totCost = parseFloat(gv('f_total_cost')) || 0;
            var totLabel = gv('f_total_cost_label');
            var breakdown = gv('f_price_breakdown');
            var notes = gv('f_notes_pricing');
            var excl = gv('f_exclusions');

            var html = '';
            if (baseCost) {
                html += '<tr><td class="pl">Contract Sum</td><td>';
                html += '<strong>\u00a3' + fmtNum(baseCost) + '</strong>';
                if (baseLabel) html += ' \u00a0\u2014\u00a0 ' + escHtml(baseLabel);
                html += '</td></tr>';
            }
            if (addCost) {
                html += '<tr><td class="pl">Additional Works</td><td>';
                if (addLabel) html += escHtml(addLabel) + ': ';
                html += '<strong>\u00a3' + fmtNum(addCost) + '</strong>';
                html += '</td></tr>';
            }
            if (breakdown) {
                html += '<tr><td class="pl">Breakdown</td><td>' + escHtml(breakdown).replace(/\n/g, '<br>') + '</td></tr>';
            }
            if (notes) {
                html += '<tr><td class="pl">Notes</td><td>' + escHtml(notes).replace(/\n/g, '<br>') + '</td></tr>';
            }
            if (excl) {
                var items = excl.split('\n').filter(function (l) { return l.trim(); });
                html += '<tr><td class="pl">Exclusions<br><small style="font-weight:normal;color:#aaa;">(not included)</small></td><td>';
                items.forEach(function (item) { html += '<div style="padding:2px 0;">\u203a ' + escHtml(item.trim()) + '</div>'; });
                html += '</td></tr>';
            }
            if (totCost) {
                html += '<tr class="total-row"><td>TOTAL';
                if (totLabel) html += '<br><small style="font-size:7pt;font-weight:normal;opacity:0.7;">' + escHtml(totLabel) + '</small>';
                html += '</td><td style="font-size:14pt;">';
                html += '<span>\u00a3' + fmtNum(totCost) + '</span>';
                html += ' <small style="font-size:8pt;font-weight:normal;opacity:0.7;">inc. VAT where applicable</small>';
                html += '</td></tr>';
            }
            if (!html) {
                html = '<tr><td colspan="2" style="color:#bbb;padding:12px;text-align:center;font-size:8pt;font-style:italic;">No pricing added yet.</td></tr>';
            }
            tbl.innerHTML = html;
        }

        function renderPreview() {
            renderNotesList();
            renderScopeTable();
            renderPricingTable();
        }

        function val(id) { var el = document.getElementById(id); return el ? el.value : ''; }
        function escHtml(str) { var d = document.createElement('div'); d.appendChild(document.createTextNode(str)); return d.innerHTML; }
        function fmtNum(n) { return n.toLocaleString('en-GB'); }

        function addNote() {
            const list = document.getElementById('notesList');
            const div = document.createElement('div');
            div.className = 'note-row';
            div.innerHTML = '<input type="text" name="notes[]" placeholder="Enter bullet point..." oninput="renderPreview()">'
                + '<label class="bl"><input type="checkbox" name="notes_bold[]" value="1" onchange="renderPreview()"> Bold</label>'
                + '<button type="button" class="rm-btn" onclick="this.parentElement.remove();renderPreview()">\u2715</button>';
            list.appendChild(div);
        }

        function addScopeRow(name, desc, heading) {
            name = name || ''; desc = desc || ''; heading = !!heading;
            const container = document.getElementById('scopeBody');
            const card = document.createElement('div');
            card.className = 'scope-card';
            card.innerHTML = '<div class="scope-card-fields">'
                + '<input type="text" class="sn scope-card-name" name="sec_name[]" value="' + escHtml(name) + '" placeholder="Section / Trade name..." oninput="renderPreview()">'
                + '<textarea class="sd scope-card-desc" name="sec_desc[]" placeholder="Description..." oninput="renderPreview()">' + escHtml(desc) + '</textarea>'
                + '</div>'
                + '<div class="scope-card-actions">'
                + '<label class="scope-toggle" title="Show in PDF">'
                + '<input type="checkbox" name="sec_visible[]" value="1" onchange="renderPreview()">'
                + '<span class="scope-toggle-slider"></span>'
                + '<span class="scope-toggle-label">PDF</span>'
                + '</label>'
                + '<button type="button" class="scope-card-del" onclick="this.closest(\'.scope-card\').remove();renderPreview()" title="Remove">\u2715</button>'
                + '</div>';
            container.appendChild(card);
            renderPreview();
        }

        function addServiceGroup(groupName) {
            const items = serviceGroups[groupName];
            if (!items) return;
            items.forEach(function (item) { addScopeRow(item[0], item[1], item[2] == 1); });
        }

        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const wrap = document.getElementById('p_photo_preview');
                    const img = document.getElementById('p_photo_img');
                    if (wrap && img) {
                        img.src = e.target.result;
                        wrap.style.display = 'block';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // ── AUTO-SAVE LOGIC ───────────────────────────
        let autosaveTimer = null;
        let autosaveQuoteId = {{ $isEdit ? $id : 0 }};
        let isSaving = false;

        function scheduleAutosave() {
            if (autosaveTimer) clearTimeout(autosaveTimer);
            autosaveTimer = setTimeout(doAutosave, 3000);
        }

        function setAutosaveStatus(state, msg) {
            const dot = document.getElementById('autosaveDot');
            const txt = document.getElementById('autosaveText');
            if (!dot || !txt) return;
            dot.className = 'autosave-dot ' + state;
            txt.textContent = msg || '';
        }

        function collectFormData() {
            const fd = new FormData();
            fd.append('_token', document.querySelector('input[name="_token"]').value);

            if (autosaveQuoteId > 0) {
                fd.append('id', autosaveQuoteId);
            }

            // Simple fields
            const fields = ['date', 'project_ref', 'client_name', 'client_address',
                'project_description', 'architect', 'structural_engineer', 'prepared_by', 'status'];
            fields.forEach(function (name) {
                const el = document.getElementById('f_' + name) || document.querySelector('[name="' + name + '"]');
                if (el) fd.append(name, el.value);
            });

            // Notes
            document.querySelectorAll('#notesList .note-row').forEach(function (row, i) {
                const textEl = row.querySelector('input[type=text]');
                const boldEl = row.querySelector('input[type=checkbox]');
                if (textEl) fd.append('notes[' + i + ']', textEl.value);
                if (boldEl && boldEl.checked) fd.append('notes_bold[' + i + ']', '1');
            });

            // Scope sections
            document.querySelectorAll('#scopeBody .scope-card').forEach(function (card, i) {
                var nameEl = card.querySelector('input.sn');
                var descEl = card.querySelector('textarea.sd');
                var visEl = card.querySelector('input[type=checkbox]');
                if (nameEl) fd.append('sec_name[' + i + ']', nameEl.value);
                if (descEl) fd.append('sec_desc[' + i + ']', descEl.value);
                // Auto-detect heading from empty description
                var desc = descEl ? descEl.value.trim() : '';
                if (!desc && nameEl && nameEl.value.trim()) fd.append('sec_heading[' + i + ']', '1');
                // Track visibility
                if (visEl && visEl.checked) fd.append('sec_visible[' + i + ']', '1');
            });

            // Pricing
            const pricingFields = [
                'base_cost_label', 'base_cost', 'additional_cost_label', 'additional_cost',
                'total_cost', 'total_cost_label', 'price_breakdown', 'notes_pricing', 'exclusions'
            ];
            pricingFields.forEach(function (name) {
                const el = document.getElementById('f_' + name);
                if (el) fd.append(name, el.value);
            });

            return fd;
        }

        function doAutosave() {
            // Need at least a project_ref or client_name
            const ref = (document.getElementById('f_project_ref') || {}).value || '';
            const name = (document.getElementById('f_client_name') || {}).value || '';
            if (!ref.trim() && !name.trim()) {
                setAutosaveStatus('unsaved', 'Need ref or client name to auto-save');
                return;
            }

            if (isSaving) return;
            isSaving = true;

            setAutosaveStatus('saving', 'Saving…');

            const fd = collectFormData();

            fetch('{{ route("quotes.autosave") }}', {
                method: 'POST',
                body: fd,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                isSaving = false;
                if (data.ok) {
                    // Store the ID for subsequent saves
                    if (data.id && autosaveQuoteId === 0) {
                        autosaveQuoteId = data.id;
                        // Add hidden input so manual submit also updates correctly
                        const form = document.getElementById('quoteForm');
                        let hiddenId = form.querySelector('input[name="id"]');
                        if (!hiddenId) {
                            hiddenId = document.createElement('input');
                            hiddenId.type = 'hidden';
                            hiddenId.name = 'id';
                            form.appendChild(hiddenId);
                        }
                        hiddenId.value = autosaveQuoteId;

                        // Update browser URL so reload goes to edit mode
                        const newUrl = '{{ route("quotes.form") }}?id=' + autosaveQuoteId;
                        window.history.replaceState({}, '', newUrl);
                    }

                    const now = new Date();
                    const timeStr = now.getHours().toString().padStart(2, '0') + ':' +
                                    now.getMinutes().toString().padStart(2, '0') + ':' +
                                    now.getSeconds().toString().padStart(2, '0');
                    setAutosaveStatus('', 'Saved at ' + timeStr);
                } else {
                    setAutosaveStatus('unsaved', 'Save failed: ' + (data.msg || 'Unknown error'));
                }
            })
            .catch(function (err) {
                isSaving = false;
                setAutosaveStatus('unsaved', 'Auto-save error');
                console.error('Autosave error:', err);
            });
        }

        // Wire up form events to trigger auto-save
        document.getElementById('quoteForm').addEventListener('input', function () {
            markUnsaved();
            syncAllFieldsToPreview();
            scheduleAutosave();
        });
        document.getElementById('quoteForm').addEventListener('change', function () {
            markUnsaved();
            syncAllFieldsToPreview();
            scheduleAutosave();
        });

        // Override the original event listeners (remove duplicates)
        // The markUnsaved + sync is now handled above, so remove old listeners
        // by redefining them on DOMContentLoaded

        window.addEventListener('DOMContentLoaded', function () {
            syncAllFieldsToPreview();
            document.getElementById('autosaveText').textContent = '{{ $isEdit ? "Last saved" : "Not yet saved" }}';
            document.getElementById('autosaveDot').className = 'autosave-dot {{ $isEdit ? "" : "unsaved" }}';
            @if($isEdit && !empty($quote['project_photo']))
                (function () {
                    var wrap = document.getElementById('p_photo_preview');
                    var img = document.getElementById('p_photo_img');
                    if (wrap && img) {
                        img.src = '{{ asset("uploads/" . ($quote["project_photo"] ?? "")) }}';
                        wrap.style.display = 'block';
                    }
                })();
            @endif
        });
    </script>
@endpush