<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $request->user()->chirps()->create($validate);

        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param Chirp $chirp
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Chirp $chirp): View
    {
        $this->authorize('update', $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        $chirp->delete();

        return redirect(route('chirps.index'));
    }
}
