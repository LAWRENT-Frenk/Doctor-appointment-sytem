<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;

class GenerateCustomIds extends Command
{
    protected $signature = 'generate:custom_ids';
    protected $description = 'Generate custom IDs for existing appointments';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $appointments = Appointment::whereNull('custom_id')->get();
        foreach ($appointments as $appointment) {
            $appointment->custom_id = $this->generateCustomId($appointment->id);
            $appointment->save();
        }

        $this->info('Custom IDs generated for existing appointments.');
    }

    private function generateCustomId($id)
    {
        return 'APP' . str_pad($id, 3, '0', STR_PAD_LEFT);
    }
}
