<?php

namespace App\Observers;

use App\Contact;
use Klaviyo;

class ContactObserver
{
	/**
	 * Handle the contact "created" event.
	 *
	 * @param  \App\Contact  $contact
	 * @return void
	 */
	public function created(Contact $contact)
	{
		$tracker = new Klaviyo(env('KLAVIYO_API_KEY'));
		return $tracker->identify(
			[
				'email' => $contact->email,
				'$first_name' => $contact->first_name,
				'$phone_number' => $contact->phone,
				'$id' => $contact->identifier,
			]
		);
	}

	/**
	 * Handle the contact "updated" event.
	 *
	 * @param  \App\Contact  $contact
	 * @return void
	 */
	public function updated(Contact $contact)
	{
		return $this->created($contact);
	}

	/**
	 * Handle the contact "deleted" event.
	 *
	 * @param  \App\Contact  $contact
	 * @return void
	 */
	public function deleted(Contact $contact)
	{

	}

	/**
	 * Handle the contact "restored" event.
	 *
	 * @param  \App\Contact  $contact
	 * @return void
	 */
	public function restored(Contact $contact)
	{
		//
	}

	/**
	 * Handle the contact "force deleted" event.
	 *
	 * @param  \App\Contact  $contact
	 * @return void
	 */
	public function forceDeleted(Contact $contact)
	{
		//
	}
}
