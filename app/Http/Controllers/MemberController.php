<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function addMember(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|unique:members,phone|max:15',
        ]);

        $member = Member::create($validatedData);

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    public function editMember(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|unique:members,phone,' . $member->id . '|max:15',
        ]);

        $member->update($validatedData);

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function deleteMember(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }

    // Get a member by phone number
    public function getMember(Request $request)
    {
        $phone = $request->input('phone');
        $member = Member::where('phone', $phone)->firstOrFail();

        return view('members.show', compact('member'));
    }

    // Display a listing of the members
    public function index()
    {
        $members = Member::all();
        return view('members.index', compact('members'));
    }

    // Show the form for creating a new member
    public function create()
    {
        return view('members.create');
    }


    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }
}
