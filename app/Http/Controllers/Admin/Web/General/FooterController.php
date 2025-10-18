<?php

namespace App\Http\Controllers\Web\General;

use App\Http\Controllers\Controller;
use App\Models\FooterTitle;
use App\Models\FooterItem;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    // --- Footer Titles ---
    public function titleIndex()
    {
        $titles = FooterTitle::ordered()->get();
        return view('admin.web.general.footer.titles.index', compact('titles'));
    }

    public function titleCreate()
    {
        return view('admin.web.general.footer.titles.create');
    }

    public function titleStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        FooterTitle::create($request->only(['title', 'sort_order', 'is_active']));

        return redirect()->route('admin.web.general.footer.titles.index')->with('success', 'Footer title created successfully.');
    }

    public function titleEdit(FooterTitle $title)
    {
        return view('admin.web.general.footer.titles.edit', compact('title'));
    }

    public function titleUpdate(Request $request, FooterTitle $title)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $title->update($request->only(['title', 'sort_order', 'is_active']));

        return redirect()->route('admin.web.general.footer.titles.index')->with('success', 'Footer title updated successfully.');
    }

    public function titleDestroy(FooterTitle $title)
    {
        $title->delete();
        return back()->with('success', 'Footer title deleted.');
    }

    // --- Footer Items ---
    public function itemIndex()
    {
        $items = FooterItem::with('title')->ordered()->get();
        return view('admin.web.general.footer.items.index', compact('items'));
    }

    public function itemCreate()
    {
        $titles = FooterTitle::ordered()->get();
        return view('admin.web.general.footer.items.create', compact('titles'));
    }

    public function itemStore(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'boolean',
            'footer_title_id' => 'required|exists:footer_titles,id',
        ]);

        FooterItem::create($request->only(['text', 'url', 'sort_order', 'is_active', 'footer_title_id']));

        return redirect()->route('admin.web.general.footer.items.index')->with('success', 'Footer item created successfully.');
    }

    public function itemEdit(FooterItem $item)
    {
        $titles = FooterTitle::ordered()->get();
        return view('admin.web.general.footer.items.edit', compact('item', 'titles'));
    }

    public function itemUpdate(Request $request, FooterItem $item)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'boolean',
            'footer_title_id' => 'required|exists:footer_titles,id',
        ]);

        $item->update($request->only(['text', 'url', 'sort_order', 'is_active', 'footer_title_id']));

        return redirect()->route('admin.web.general.footer.items.index')->with('success', 'Footer item updated successfully.');
    }

    public function itemDestroy(FooterItem $item)
    {
        $item->delete();
        return back()->with('success', 'Footer item deleted.');
    }
}
