<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LegalDocument;
use App\Models\LegalSection;
use App\Models\LegalListItem;
use DB;

class WebLegalController extends Controller
{
    // Show all legal documents
    public function index()
    {
        $documents = LegalDocument::orderBy('created_at', 'desc')->get();
        return view('admin.web.legal.index', compact('documents'));
    }

    // Show form to create new document
    public function create()
    {
        $document = new LegalDocument();
        $document->sections = collect();
        return view('admin.web.legal.form', compact('document'));
    }

    // Store new document + nested data
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        DB::transaction(function () use ($validated) {
            $document = LegalDocument::create([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'is_active' => $validated['is_active'],
            ]);

            if (!empty($validated['sections'])) {
                foreach ($validated['sections'] as $sectionData) {
                    $section = $document->sections()->create([
                        'heading' => $sectionData['heading'],
                        'body' => $sectionData['body'] ?? null,
                        'order' => $sectionData['order'] ?? 0,
                    ]);

                    if (!empty($sectionData['list_items'])) {
                        foreach ($sectionData['list_items'] as $itemData) {
                            $section->listItems()->create([
                                'item_text' => $itemData['item_text'],
                                'order' => $itemData['order'] ?? 0,
                            ]);
                        }
                    }
                }
            }
        });

        return redirect()->route('admin.web.legal.index')->with('success', 'Legal document created successfully.');
    }

    // Show edit form for a document
    public function edit($id)
    {
        $document = LegalDocument::with('sections.listItems')->findOrFail($id);
        return view('admin.web.legal.form', compact('document'));
    }

    // Update document + nested data
    public function update(Request $request, $id)
    {
        $validated = $this->validateRequest($request, $id);

        DB::transaction(function () use ($validated, $id) {
            $document = LegalDocument::findOrFail($id);
            $document->update([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'is_active' => $validated['is_active'],
            ]);

            // Track existing and submitted section IDs to delete removed ones
            $existingSectionIds = $document->sections()->pluck('id')->toArray();
            $submittedSectionIds = [];

            if (!empty($validated['sections'])) {
                foreach ($validated['sections'] as $sectionData) {
                    if (!empty($sectionData['id'])) {
                        $section = LegalSection::findOrFail($sectionData['id']);
                        $section->update([
                            'heading' => $sectionData['heading'],
                            'body' => $sectionData['body'] ?? null,
                            'order' => $sectionData['order'] ?? 0,
                        ]);
                        $submittedSectionIds[] = $section->id;
                    } else {
                        $section = $document->sections()->create([
                            'heading' => $sectionData['heading'],
                            'body' => $sectionData['body'] ?? null,
                            'order' => $sectionData['order'] ?? 0,
                        ]);
                        $submittedSectionIds[] = $section->id;
                    }

                    // Sync list items
                    $existingListItemIds = $section->listItems()->pluck('id')->toArray();
                    $submittedListItemIds = [];

                    if (!empty($sectionData['list_items'])) {
                        foreach ($sectionData['list_items'] as $itemData) {
                            if (!empty($itemData['id'])) {
                                $listItem = LegalListItem::findOrFail($itemData['id']);
                                $listItem->update([
                                    'item_text' => $itemData['item_text'],
                                    'order' => $itemData['order'] ?? 0,
                                ]);
                                $submittedListItemIds[] = $listItem->id;
                            } else {
                                $listItem = $section->listItems()->create([
                                    'item_text' => $itemData['item_text'],
                                    'order' => $itemData['order'] ?? 0,
                                ]);
                                $submittedListItemIds[] = $listItem->id;
                            }
                        }
                    }

                    // Delete removed list items
                    $toDeleteListItems = array_diff($existingListItemIds, $submittedListItemIds);
                    if (!empty($toDeleteListItems)) {
                        LegalListItem::whereIn('id', $toDeleteListItems)->delete();
                    }
                }
            }

            // Delete removed sections
            $toDeleteSections = array_diff($existingSectionIds, $submittedSectionIds);
            if (!empty($toDeleteSections)) {
                LegalSection::whereIn('id', $toDeleteSections)->delete();
            }
        });

        return redirect()->route('admin.web.legal.index')->with('success', 'Legal document updated successfully.');
    }

    // Delete a document (and related sections & list items)
    public function destroy($id)
    {
        $document = LegalDocument::findOrFail($id);
        $document->delete();
        return redirect()->route('admin.web.legal.index')->with('success', 'Legal document deleted successfully.');
    }

    // Validation rules for document + nested arrays
    protected function validateRequest(Request $request, $id = null)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:legal_documents,slug,' . $id,
            'is_active' => 'required|boolean',
            'sections' => 'nullable|array',
            'sections.*.id' => 'nullable|exists:legal_sections,id',
            'sections.*.heading' => 'required|string|max:255',
            'sections.*.body' => 'nullable|string',
            'sections.*.order' => 'nullable|integer',
            'sections.*.list_items' => 'nullable|array',
            'sections.*.list_items.*.id' => 'nullable|exists:legal_list_items,id',
            'sections.*.list_items.*.item_text' => 'required|string',
            'sections.*.list_items.*.order' => 'nullable|integer',
        ]);
    }
}
