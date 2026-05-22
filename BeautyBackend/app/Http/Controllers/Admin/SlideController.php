<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SlideController extends Controller
{
    public function index(): View
    {
        $slides = Slide::orderBy('sort_order')->get();

        return view('admin.slides.index', compact('slides'));
    }

    public function create(): View
    {
        return view('admin.slides.form', ['slide' => new Slide()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,webp,gif|max:10240',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('slides', 'public');
        }

        Slide::create($validated);

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide created successfully.');
    }

    public function edit(Slide $slide): View
    {
        return view('admin.slides.form', compact('slide'));
    }

    public function update(Request $request, Slide $slide): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,webp,gif|max:10240',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($slide->image) {
                Storage::disk('public')->delete($slide->image);
            }
            $validated['image'] = $request->file('image')->store('slides', 'public');
        }

        $slide->update($validated);

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide updated successfully.');
    }

    public function destroy(Slide $slide): RedirectResponse
    {
        if ($slide->image) {
            Storage::disk('public')->delete($slide->image);
        }

        $slide->delete();

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide deleted.');
    }
}
