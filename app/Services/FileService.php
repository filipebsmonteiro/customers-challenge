<?php

namespace App\Services;

use App\Http\Traits\RulesTrait;
use App\Models\File;
use App\Repositories\AddressRepository;
use App\Repositories\CreditCardRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Json;

class FileService
{
    use RulesTrait;

    /**
     * @var FileRepository
     */
    private $fileRepository;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var AddressRepository
     */
    private $addressRepository;

    /**
     * @var CreditCardRepository
     */
    private $creditCardRepository;

    public function __construct(
        FileRepository       $fileRepository,
        CustomerRepository   $customerRepository,
        AddressRepository    $addressRepository,
        CreditCardRepository $creditCardRepository
    )
    {
        $this->fileRepository = $fileRepository;
        $this->customerRepository = $customerRepository;
        $this->addressRepository = $addressRepository;
        $this->creditCardRepository = $creditCardRepository;
    }

    public function create(array $attributes): File
    {
        return $this->fileRepository->create($attributes);
    }

    public function findByUrl(string $url): File
    {
        return $this->fileRepository->findByUrl($url);
    }

    public function processFile(File $file): int
    {
        $contents = Storage::get($file->url);
        $records = Json::decode($contents);
        if (!is_array($records)) {
            throw new \Exception('File ' . $file->url . ' was corrupted!');
        }

        try {
            DB::beginTransaction();

            foreach ($records as $index => $record) {
                if ($this->validate($record)) {
                    $input = collect($record);
                    $customerInput = $input->only(['name', 'checked', 'description', 'interest', 'email', 'account'])->toArray();
                    $customer = $this->customerRepository->create(array_merge(
                        $customerInput, ['date_of_birth' => $this->parseDate($record->date_of_birth)]
                    ));
                    $customer->adresses()->create(['complete' => $record->address]);

                    $credit_card = collect($record->credit_card);
                    $customer->creditCards()->create( $credit_card->toArray() );
                }
            }

            $pathArray = explode('/', $file->url);
            Storage::move($file->url, 'processed/' . end($pathArray));
            $file->setProcessed();

            DB::commit();

            return sizeof($records);

        } catch (Exception $exception) {
            DB::rollBack();
            Log::info(__CLASS__ . ' ' . __FUNCTION__ . ' - ' . $exception->getLine() . ' - ' . $exception->getMessage());
            return $exception->getMessage();
        }
    }
}
