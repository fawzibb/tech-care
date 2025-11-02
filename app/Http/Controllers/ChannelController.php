<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    // عرض جميع القنوات (الواجهة العامة)
    public function index()
    {
        $channels = Channel::all();
        return view('live-tv.index', compact('channels'));
    }

    // ------------------- Admin -------------------

    public function adminIndex()
    {
        $channels = Channel::all();
        return view('admin.channels.index', compact('channels'));
    }

    public function create()
    {
        return view('admin.channels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stream_url' => 'required|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->only(['name', 'stream_url', 'category']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('channels', 'public');
        }

        Channel::create($data);

        return redirect()->route('admin.channels.index')->with('success', 'Channel added successfully!');
    }

    public function edit(Channel $channel)
    {
        return view('admin.channels.edit', compact('channel'));
    }

    public function update(Request $request, Channel $channel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stream_url' => 'required|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->only(['name', 'stream_url', 'category']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('channels', 'public');
        }

        $channel->update($data);

        return redirect()->route('admin.channels.index')->with('success', 'Channel updated successfully!');
    }

    public function destroy(Channel $channel)
    {
        $channel->delete();
        return redirect()->back()->with('success', 'Channel deleted.');
    }

    public function show(Channel $channel)
{
    return view('live-tv.show', compact('channel'));
}

}
