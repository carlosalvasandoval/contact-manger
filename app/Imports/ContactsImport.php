<?php

namespace App\Imports;

use App\User;
use App\Contact;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreContact;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Notifications\ImportHasFailedNotification;

class ContactsImport extends DefaultValueBinder implements
	ToCollection,
	WithHeadingRow,
	WithChunkReading,
	WithBatchInserts,
	WithValidation,
	ShouldQueue,
	SkipsOnFailure,
	WithEvents
{
	use Importable;
	protected $userId;

	public function __construct(User $importedBy)
	{
		$this->importedBy = $importedBy;
	}

	public function userIdfromFile(string $fileName)
	{
		$this->userId = strstr($fileName, '_', true);
		return $this;
	}

	public function collection(Collection $rows)
	{
		/* if (!isset($row['first_name'], $row['email'], $row['phone']))
		{
			return null;
		} */

		foreach ($rows as $row)
		{
			Contact::create([
				'user_id' => $this->userId,
				'first_name' => $row['first_name'],
				'email' => $row['email'],
				'phone' => $row['phone'],
				'identifier' => uniqid(),
			]);
		}
	}

	public function chunkSize(): int
	{
		return 1000;
	}

	public function batchSize(): int
	{
		return 1000;
	}

	public function rules(): array
	{
		$storeContact = new StoreContact();
		return $storeContact->rules();
	}

	public function onFailure(Failure...$failures)
	{
		$this->importedBy->notify(new ImportHasFailedNotification($failures));
	}

	public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
				Cache::tags('contacts' . $this->userId)->flush();
            },              
        ];
    }

}
