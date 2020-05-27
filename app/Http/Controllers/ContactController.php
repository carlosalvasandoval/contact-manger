<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use App\Repositories\Contacts;
use App\Imports\ContactsImport;
use App\Http\Requests\StoreContact;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreCsvContact;

class ContactController extends Controller
{
	public function __construct()
	{
		$this->middleware('owner',['only'=>['edit','update','destroy']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$key = "contacts.page." . request('page', 1);
		$userId = Auth::id();
		$contacts = Cache::tags('contacts' . $userId)->rememberForever($key, function () use($userId)
		{
			return Contact::where('user_id', $userId)->paginate();
		});
		return view('contacts.index', compact('contacts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('contacts.create', ['contact' => new Contact]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StoreContact $request
	 * @return void
	 */
	public function store(StoreContact $request)
	{
		$userId = Auth::id();
		$validated = $request->validated();
		$validated['user_id'] = $userId;
		$validated['identifier'] = uniqid();
		Contact::create($validated);
		Cache::tags('contacts' .$userId)->flush();
		return redirect()->route('contacts.index')->with('status', 'Your contact was added successfully');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Contact $contact
	 * @return void
	 */
	public function edit(Contact $contact)
	{
		return view('contacts.edit', compact('contact'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param StoreContact $request
	 * @param Contact $contact
	 * @return void
	 */
	public function update(StoreContact $request, Contact $contact)
	{
		$contact->update($request->validated());
		Cache::tags('contacts' . Auth::id())->flush();
		return redirect()->route('contacts.index')->with('status', 'Your contact was edited successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Contact $contact
	 * @return void
	 */
	public function destroy(Contact $contact)
	{
		$contact->delete();
		Cache::tags('contacts' . Auth::id())->flush();
		return redirect()->route('contacts.index')->with('status', 'Your contact was removed successfully');
	}

	/**
	 * Import view form
	 *
	 * @return void
	 */
	public function import()
	{
		return view('contacts.import');
	}

	/**
	 * Store csv contacts
	 *
	 * @param StoreCsvContact $request
	 * @return void
	 */
	public function storeCsvContacts(StoreCsvContact $request)
	{
		$extension = $request->file('file')->getClientOriginalExtension();
		$fileName = Auth::id() . '_' . uniqid() . '.' . $extension;
		$path = $request->file->storeAs('csv', $fileName);
		$storagePath = storage_path('app/' . $path);
		$import = (new ContactsImport(Auth::user()))->userIdfromFile($fileName);
		Excel::import($import, $storagePath);
		return redirect()->back()->with('status', 'Your contacts will be imported soon. We will send you an email if something fails.');
	}
}
