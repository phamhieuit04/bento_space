<?php

namespace App\Console\Commands\Drive;

use App\Enums\Drive\TrashedStatus;
use App\Repositories\File\FileRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessEmptyTrashBin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drive:process-empty-trash-bin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform empty google drive trashbin after 30 days';

    /**
     * Execute the console command.
     */
    public function handle(FileRepository $fileRepo)
    {
        DB::transaction(function () use ($fileRepo) {
            foreach ($fileRepo->all() as $item) {
                if (
                    $item->updated_at->addDays(30)->lessThan(now())
                    && $item->trashed == TrashedStatus::TRASHED->value
                ) {
                    $fileRepo->delete($item->id);
                    Log::info("Successfully delete file [{$item->drive_id}, {$item->name}] (trashed more than 30 days).");
                }
            }
        });
    }
}
