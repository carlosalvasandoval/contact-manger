<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Klaviyo;

class TrackController extends Controller
{
	public function track()
	{
		$user = auth()->user();
		$tracker = new Klaviyo(env('KLAVIYO_API_KEY'));
		return $tracker->track(
			'Button pressed',
			['$id' => $user->id, '$email' => $user->email, '$first_name' => $user->name],
			Carbon::now()->timestamp
		);

	}
}
