<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class QuoteController extends Controller
{
    /**
     * Dashboard — list all quotes with stats.
     */
    public function index(Request $request)
    {
        $quotes = Quote::leftJoin('pricings', 'pricings.quote_id', '=', 'quotes.id')
            ->select('quotes.*', 'pricings.total_cost')
            ->orderByDesc('quotes.created_at')
            ->get();

        $total = $quotes->count();
        $draft = $quotes->where('status', 'draft')->count();
        $sent = $quotes->where('status', 'sent')->count();
        $accepted = $quotes->where('status', 'accepted')->count();
        $declined = $quotes->where('status', 'declined')->count();
        $totalValue = $quotes->whereNotNull('total_cost')->sum('total_cost');

        // Bar chart data — last 7 months
        $months = [];
        $bars = [];
        for ($i = 6; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('M');
            $ym = now()->subMonths($i)->format('Y-m');
            $bars[] = $quotes->filter(fn($q) => substr($q->created_at, 0, 7) === $ym)->count();
        }

        $recent5 = $quotes->take(5);

        return view('quotes.index', compact(
            'quotes',
            'total',
            'draft',
            'sent',
            'accepted',
            'declined',
            'totalValue',
            'months',
            'bars',
            'recent5'
        ))->with('msg', $request->query('msg'));
    }

    /**
     * All Quotes listing page with filtering & sorting.
     */
    public function list(Request $request)
    {
        $query = Quote::leftJoin('pricings', 'pricings.quote_id', '=', 'quotes.id')
            ->select('quotes.*', 'pricings.total_cost');

        // Status filter
        $status = $request->query('status', 'all');
        if ($status !== 'all' && in_array($status, ['draft', 'sent', 'accepted', 'declined'])) {
            $query->where('quotes.status', $status);
        }

        // Search
        $search = $request->query('search', '');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('quotes.project_ref', 'like', "%{$search}%")
                    ->orWhere('quotes.client_name', 'like', "%{$search}%")
                    ->orWhere('quotes.prepared_by', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->query('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('quotes.created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('quotes.client_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('quotes.client_name', 'desc');
                break;
            case 'value_high':
                $query->orderByDesc('pricings.total_cost');
                break;
            case 'value_low':
                $query->orderBy('pricings.total_cost', 'asc');
                break;
            default:
                $query->orderByDesc('quotes.created_at');
        }

        $quotes = $query->get();

        // Stats for filter pills
        $allCount = Quote::count();
        $draftCount = Quote::where('status', 'draft')->count();
        $sentCount = Quote::where('status', 'sent')->count();
        $acceptedCount = Quote::where('status', 'accepted')->count();
        $declinedCount = Quote::where('status', 'declined')->count();

        return view('quotes.list', compact(
            'quotes',
            'status',
            'search',
            'sort',
            'allCount',
            'draftCount',
            'sentCount',
            'acceptedCount',
            'declinedCount'
        ))->with('msg', $request->query('msg'));
    }

    /**
     * Show the quote create / edit form.
     */
    public function form(Request $request)
    {
        $id = (int)$request->query('id', 0);
        $isEdit = $id > 0;

        $quote = [];
        $notes = [];
        $sections = [];
        $pricing = [];

        if ($isEdit) {
            $quote = Quote::findOrFail($id);
            $notes = $quote->revisionNotes()->get();
            $sections = $quote->scopeSections()->get();
            $pricing = $quote->pricing ?? [];
        }

        $serviceGroups = $this->getServiceGroups();

        // Default scope sections (all services flattened)
        $defaultSections = [];
        foreach ($serviceGroups as $items) {
            foreach ($items as $item) {
                $defaultSections[] = [
                    'section_name' => $item[0],
                    'section_description' => $item[1],
                    'is_heading' => $item[2],
                ];
            }
        }

        $rows = ($isEdit && count($sections)) ? $sections : $defaultSections;

        return view('quotes.form', compact(
            'isEdit',
            'id',
            'quote',
            'notes',
            'sections',
            'pricing',
            'serviceGroups',
            'defaultSections',
            'rows'
        ));
    }

    /**
     * Save a quote (create or update).
     */
    public function save(Request $request)
    {
        $request->validate([
            'project_ref' => 'required|string|max:100',
            'client_name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $id = (int)$request->input('id', 0);
        $isEdit = $id > 0;

        DB::beginTransaction();

        try {
            // Handle photo upload
            $projectPhoto = null;
            if ($request->hasFile('project_photo') && $request->file('project_photo')->isValid()) {
                $file = $request->file('project_photo');
                $filename = 'quote_' . time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $projectPhoto = $filename;
            }

            $data = $request->only([
                'date',
                'project_ref',
                'client_name',
                'client_address',
                'project_description',
                'architect',
                'structural_engineer',
                'prepared_by',
                'status',
            ]);
            $data['architect'] = $data['architect'] ?: 'Not yet appointed';
            $data['structural_engineer'] = $data['structural_engineer'] ?: 'Not yet appointed';
            $data['prepared_by'] = $data['prepared_by'] ?: 'Joanne Fowler';
            $data['status'] = in_array($data['status'] ?? '', ['draft', 'sent', 'accepted', 'declined'])
                ? $data['status'] : 'draft';

            if ($projectPhoto) {
                $data['project_photo'] = $projectPhoto;
            }

            if ($isEdit) {
                $quote = Quote::findOrFail($id);
                $quote->update($data);
            }
            else {
                $quote = Quote::create($data);
            }

            // Revision notes
            $quote->revisionNotes()->delete();
            $noteTexts = $request->input('notes', []);
            $noteBolds = $request->input('notes_bold', []);
            foreach ($noteTexts as $i => $text) {
                $text = trim($text);
                if ($text === '')
                    continue;
                $quote->revisionNotes()->create([
                    'note_text' => $text,
                    'is_bold' => isset($noteBolds[$i]) ? true : false,
                    'sort_order' => $i,
                ]);
            }

            // Scope sections
            $quote->scopeSections()->delete();
            $secNames = $request->input('sec_name', []);
            $secDescs = $request->input('sec_desc', []);
            $secVisible = $request->input('sec_visible', []);
            foreach ($secNames as $i => $name) {
                $name = trim($name);
                if ($name === '')
                    continue;
                // Only save items that are visible (checked)
                if (!isset($secVisible[$i]))
                    continue;
                $desc = trim($secDescs[$i] ?? '');
                $quote->scopeSections()->create([
                    'section_name' => $name,
                    'section_description' => $desc,
                    'is_heading' => $desc === '' ? true : false,
                    'sort_order' => $i,
                ]);
            }

            // Pricing
            $pricingData = [
                'base_cost_label' => trim($request->input('base_cost_label', '')),
                'base_cost' => $request->input('base_cost') ?: null,
                'additional_cost_label' => trim($request->input('additional_cost_label', '')),
                'additional_cost' => $request->input('additional_cost') ?: null,
                'total_cost' => $request->input('total_cost') ?: null,
                'total_cost_label' => trim($request->input('total_cost_label', '')),
                'price_breakdown' => trim($request->input('price_breakdown', '')),
                'notes' => trim($request->input('notes_pricing', '')),
                'exclusions' => trim($request->input('exclusions', '')),
            ];

            Pricing::updateOrCreate(
            ['quote_id' => $quote->id],
                $pricingData
            );

            DB::commit();
            return redirect()->route('quotes.index', ['msg' => 'saved']);

        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error saving quote: ' . $e->getMessage()]);
        }
    }

    /**
     * Autosave via AJAX — creates or updates, returns JSON.
     */
    public function autosave(Request $request)
    {
        $id = (int)$request->input('id', 0);
        $isEdit = $id > 0;

        DB::beginTransaction();
        try {
            $data = $request->only([
                'date',
                'project_ref',
                'client_name',
                'client_address',
                'project_description',
                'architect',
                'structural_engineer',
                'prepared_by',
                'status',
            ]);
            $data['architect'] = $data['architect'] ?: 'Not yet appointed';
            $data['structural_engineer'] = $data['structural_engineer'] ?: 'Not yet appointed';
            $data['prepared_by'] = $data['prepared_by'] ?: 'Joanne Fowler';
            $data['status'] = in_array($data['status'] ?? '', ['draft', 'sent', 'accepted', 'declined'])
                ? $data['status'] : 'draft';

            // Need at least a project_ref or client_name to save
            if (empty($data['project_ref']) && empty($data['client_name'])) {
                return response()->json(['ok' => false, 'msg' => 'Need ref or name']);
            }
            if (empty($data['date'])) {
                $data['date'] = now()->toDateString();
            }

            if ($isEdit) {
                $quote = Quote::findOrFail($id);
                $quote->update($data);
            }
            else {
                $quote = Quote::create($data);
            }

            // Revision notes
            $quote->revisionNotes()->delete();
            $noteTexts = $request->input('notes', []);
            $noteBolds = $request->input('notes_bold', []);
            if (is_array($noteTexts)) {
                foreach ($noteTexts as $i => $text) {
                    $text = trim($text);
                    if ($text === '')
                        continue;
                    $quote->revisionNotes()->create([
                        'note_text' => $text,
                        'is_bold' => isset($noteBolds[$i]),
                        'sort_order' => $i,
                    ]);
                }
            }

            // Scope sections
            $quote->scopeSections()->delete();
            $secNames = $request->input('sec_name', []);
            $secDescs = $request->input('sec_desc', []);
            $secVisible = $request->input('sec_visible', []);
            if (is_array($secNames)) {
                foreach ($secNames as $i => $name) {
                    $name = trim($name);
                    if ($name === '')
                        continue;
                    // Only save items that are visible (checked)
                    if (!isset($secVisible[$i]))
                        continue;
                    $desc = trim($secDescs[$i] ?? '');
                    $quote->scopeSections()->create([
                        'section_name' => $name,
                        'section_description' => $desc,
                        'is_heading' => $desc === '' ? true : false,
                        'sort_order' => $i,
                    ]);
                }
            }

            // Pricing
            $pricingData = [
                'base_cost_label' => trim($request->input('base_cost_label', '')),
                'base_cost' => $request->input('base_cost') ?: null,
                'additional_cost_label' => trim($request->input('additional_cost_label', '')),
                'additional_cost' => $request->input('additional_cost') ?: null,
                'total_cost' => $request->input('total_cost') ?: null,
                'total_cost_label' => trim($request->input('total_cost_label', '')),
                'price_breakdown' => trim($request->input('price_breakdown', '')),
                'notes' => trim($request->input('notes_pricing', '')),
                'exclusions' => trim($request->input('exclusions', '')),
            ];
            Pricing::updateOrCreate(
            ['quote_id' => $quote->id],
                $pricingData
            );

            DB::commit();
            return response()->json([
                'ok' => true,
                'id' => $quote->id,
                'msg' => 'Saved',
            ]);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['ok' => false, 'msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a quote.
     */
    public function destroy(Request $request)
    {
        $id = (int)$request->query('id', 0);
        if ($id > 0) {
            Quote::where('id', $id)->delete();
        }
        return redirect()->route('quotes.index', ['msg' => 'deleted']);
    }

    /**
     * Generate and download PDF.
     */
    public function generatePdf(Request $request)
    {
        $id = (int)$request->query('id', 0);
        if (!$id) {
            abort(404, 'No quote ID specified.');
        }

        $quote = Quote::findOrFail($id);
        $notes = $quote->revisionNotes;
        $sections = $quote->scopeSections;
        $pricing = $quote->pricing ?? [];

        // Logo as base64
        $logoPath = public_path('assets/img/logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // Work photos
        $workPhotos = [];
        if (!empty($quote->project_photo) && file_exists(public_path('uploads/' . $quote->project_photo))) {
            $ext = strtolower(pathinfo($quote->project_photo, PATHINFO_EXTENSION));
            $mime = in_array($ext, ['jpg', 'jpeg']) ? 'image/jpeg' : 'image/png';
            $workPhotos[] = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents(public_path('uploads/' . $quote->project_photo)));
        }
        foreach (['assets/img/work_photo1.jpg', 'assets/img/work_photo2.jpg'] as $p) {
            if (count($workPhotos) >= 2)
                break;
            $fullPath = public_path($p);
            if (file_exists($fullPath)) {
                $workPhotos[] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($fullPath));
            }
        }

        // FMB Certificate images as base64
        $fmbCert1Base64 = '';
        $fmbCert1Path = public_path('assets/img/fmb-certificate-1.jpg');
        if (file_exists($fmbCert1Path)) {
            $fmbCert1Base64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($fmbCert1Path));
        }

        $fmbCert2Base64 = '';
        $fmbCert2Path = public_path('assets/img/fmb-certificate-2.jpg');
        if (file_exists($fmbCert2Path)) {
            $fmbCert2Base64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($fmbCert2Path));
        }

        // Render the Blade view to HTML
        $html = view('quotes.pdf', compact('quote', 'notes', 'sections', 'pricing', 'logoBase64', 'workPhotos', 'fmbCert1Base64', 'fmbCert2Base64'))->render();

        // Create mPDF instance
        $mpdf = new Mpdf([
            'format' => 'A4',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
            'default_font' => 'helvetica',
            'default_font_size' => 10,
            'tempDir' => storage_path('app/mpdf'),
        ]);

        $mpdf->WriteHTML($html);

        $ref = preg_replace('/[^A-Za-z0-9\-_]/', '_', $quote->project_ref ?? 'Quote');
        $filename = 'Quote_' . $ref . '_' . date('Ymd') . '.pdf';

        return response($mpdf->Output($filename, 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Service groups data for quick-add chips.
     */
    private function getServiceGroups(): array
    {
        return [
            'Pre-Construction' => [
                ['Planning & Design Coordination', 'Coordinate with architect and design team to review and finalise drawings.', 0],
                ['Architectural Drawings & Revisions', 'Architectural drawings issued by HED Architecture. Any revisions to be agreed in writing.', 0],
                ['Structural Engineering Report', 'Structural engineer to provide report and calculations prior to commencement.', 0],
                ['Party Wall Agreement / Award', 'Party wall surveyor to be appointed. Cost of award to be shared as legally required.', 0],
                ['Building Control Application', 'Full plans application submitted to building control. All inspections to be arranged by contractor.', 0],
                ['Asbestos Survey', 'Type 2 asbestos refurbishment survey required prior to any demolition works.', 0],
                ['Ground Investigation / Trial Hole', 'Trial holes to be dug and assessed by structural engineer to confirm foundation type.', 0],
            ],
            'Site Setup' => [
                ['Enabling Works', "Site setup, Health and safety requirements in place, storage area allocated, driveway protected and ready for groundworks. Building control appointed.", 0],
                ['Scaffolding', 'Erect and dismantle scaffolding as required to carry out works safely. Scaffold design and loading calculations included.', 0],
                ['Site Hoarding & Security', 'Temporary hoarding and security fencing erected around working area for the duration of works.', 0],
                ['Waste Removal', 'All waste removed via skip or grab wagon throughout the duration of the project.', 0],
            ],
            'Demolition' => [
                ['Demolition & Strip Out', 'Careful demolition of existing structure as shown on drawings. All materials to be segregated and disposed of responsibly.', 0],
                ['Underpinning', 'Underpin existing foundations where required as confirmed by structural engineer.', 0],
            ],
            'Groundworks' => [
                ['Foundations', "Pile foundation advised but will be confirmed by Structural Engineers report and trial hole.\nFoundations to be excavated to the dimensions outlined in HED drawings.", 0],
                ['Drainage', 'New drainage to suit layout of the extension. All runs to be connected to assumed existing drainage system.', 0],
                ['Concrete Slab / Ground Floor', 'Concrete slab floor as per drawings, including insulation and damp proof membrane.', 0],
                ['Groundworks (General)', 'General groundworks including excavation, backfill, and compaction as required.', 0],
            ],
            'Main Structure' => [
                ['Build Main Structure', 'Structural phase of the construction.', 1],
                ['Structural Steelwork', 'All structural openings to comply with Structural Engineers design. Price based on steels to sit on pad stones TBC.', 0],
                ['Brickwork & Blockwork', 'Block and brick construction. Brick work to match existing property. DPC to external leaf, with full fill cavity insulation.', 0],
                ['Timber Frame Construction', 'Structural timber frame erected as per engineer\'s spec. All timber to be treated.', 0],
                ['Steel Frame / Portal Frame', 'Structural steel frame fabricated and erected as per engineers drawings.', 0],
                ['Roof Structure', "Insulated pitched roof, new tiles to match existing tiles or as closely as possible (to be determined by pitch).", 0],
                ['Roof Covering & Tiles', 'Roof tiles/slates to match existing. New underlay, battens and felt included.', 0],
                ['External Walls', 'Block and brick construction. Brick work to match existing property. DPC to external leaf, full fill cavity insulation.', 0],
                ['Roofline, Soffits, Fascias & Guttering', "All rainwater goods, soffits and fascia's to match existing property.", 0],
                ['Floor Construction', 'Concrete slab floor as per drawings. Includes insulation and screed where required.', 0],
                ['Internal Walls & Staircase', "Stud walls constructed to create rooms to dimensions provided in the drawings.\nStaircase moved to new position as per drawings.", 0],
            ],
            'External Envelope' => [
                ['External Windows & Doors', 'Re-use composite front door where possible. New aluminium bi-folding doors and windows as per schedule.', 0],
                ['External Cladding', 'External cladding system installed as per specification and architect drawings.', 0],
                ['Rendering / Brick Slips', 'External render / brick slip finish applied to new extension elevations as shown on drawings.', 0],
                ['Damp Proof Course / Waterproofing', 'DPC installed to all external walls. Tanking membrane applied to basement / below ground areas.', 0],
                ['External Wall Insulation (EWI)', 'EWI system installed to external elevations. U-value to comply with Part L of building regs.', 0],
            ],
            'Internal Works' => [
                ['Plastering & Dry Lining', 'All work affected areas plaster finished ready for decorating. Dry lining where required.', 0],
                ['Decorating', 'Not priced for at this stage.', 0],
                ['Internal Doors', 'Fit client supplied internal doors. Hang, fit ironmongery and seal.', 0],
                ['Joinery & Trim', "All internal joinery included, skirting boards, architraves and window boards.", 0],
                ['Staircase', 'New staircase supplied and fitted as per design. Balustrade and handrail included.', 0],
                ['Acoustic Insulation', 'Acoustic insulation installed between floors and party walls to comply with Part E of building regs.', 0],
                ['Fire Stopping / Compartmentation', 'Fire stopping installed at all service penetrations. Compartmentation as required by Part B.', 0],
                ['Tiling (Wall & Floor)', 'Supply and fix wall and floor tiles to wet areas as specified. Tile specification subject to client selection.', 0],
                ['Flooring & Floor Coverings', 'Floor coverings not included – client to arrange direct.', 0],
                ['Wardrobes & Built-In Storage', 'Supply and install built-in storage as per design. Spec subject to client selection.', 0],
            ],
            'Mechanicals & Electrics' => [
                ['Areas/rooms', '', 1],
                ['Electrics', 'All electrical work carried out by NICEIC registered electricians. Electrical layout and quantities subject to final design.', 0],
                ['Kitchen, Family / Living / Dining', "Electrical feed for kitchen appliances to suit new layout. Island light feed, LED spotlights throughout.\nX6 double sockets throughout, TV aerial feed, extractor fan.", 0],
                ['Utility', 'LED spotlights, all appliance feeds, 2x double sockets, extractor fan.', 0],
                ['Hallway', 'LED spotlight alteration.', 0],
                ['W/C', 'LED spotlights, extractor fan.', 0],
                ['Cloakroom', 'LED spotlights.', 0],
                ['General System', "Fire detectors installed to comply with building regulations.\nAllowance to connect to existing electrical system.", 0],
                ['EV Charging Point', 'Supply and install EV charging point to garage / drive. Dedicated circuit from consumer unit.', 0],
                ['Solar PV / Panels', 'Supply and install solar PV panels as per specification. Inverter, metering and grid connection included.', 0],
                ['CCTV & Security System', 'Supply and install CCTV cameras, recording unit, and intruder alarm system.', 0],
                ['Smart Home / AV System', 'Supply and install smart lighting, heating controls, and AV distribution as per spec.', 0],
                ['Plumbing', 'All works carried out and certified by Gas Safe registered engineers on any gas works.', 0],
                ['Main Heating & Water System', "Allowance made to connect to the existing system.\nBoiler moved to utility room (client to supply boiler and thermostat).", 0],
                ['Kitchen', 'Hot and cold water feeds.', 0],
                ['Utility', 'Hot and cold water feeds.', 0],
                ['W/C', 'Hot and cold water feeds and connect client supplied sanitaryware to drainage.', 0],
                ['Radiators', 'Fit radiators; client to supply. Positions TBC.', 0],
                ['Underfloor Heating (UFH)', 'Supply and install wet underfloor heating system to ground floor. Manifold, thermostat and controls included.', 0],
                ['Air Source Heat Pump', 'Supply and install air source heat pump. Refrigerant pipework, controls, and commissioning included.', 0],
                ['MVHR System', 'Supply and install MVHR unit with full duct distribution. Commissioning and balancing included.', 0],
                ['Gas Works', 'All gas work carried out by Gas Safe registered engineers. Gas meter relocation if required.', 0],
            ],
            'Fit Out & Finishes' => [
                ['Kitchen Supply & Installation', 'Supply and install kitchen units. Worktops, handles and sinks as per specification. Appliances not included.', 0],
                ['Bathrooms & En-Suites', 'Supply and install sanitaryware and bathroom furniture as per specification. Tiles not included.', 0],
            ],
            'External Works' => [
                ['Landscaping', 'Reinstatement of garden areas disturbed during works. Additional landscaping scheme not included.', 0],
                ['Paving, Drives & Paths', 'Supply and lay block paving / tarmac to driveway and path areas as shown on drawings.', 0],
                ['Fencing & Boundary Walls', 'Supply and erect fencing / boundary walls to site perimeter as specified.', 0],
                ['External Lighting', 'Supply and install external lighting including PIR sensor lights and feature lighting.', 0],
            ],
        ];
    }
}
