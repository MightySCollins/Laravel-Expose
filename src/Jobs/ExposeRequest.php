<?php

namespace SCollins\LaravelExpose\Jobs;

use Cache;
use Expose;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExposeRequest extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $id;
    protected $ip;

    /**
     * Create a new job instance.
     * @param array $input
     * @param string $ip
     */
    public function __construct(string $id, string $ip)
    {
        $this->id = $id;
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (Cache::has($this->id)) {
            Expose::run(Cache::pull($this->id));
            if (Expose::getImpact() > 0) {
                Expose::getLogger()->warning('Expose risk level ' . Expose::getImpact() . ' for ' . $this->ip);
            }
        }
    }

    /**
     * @todo Implement
     */
    protected function formatReports($reports)
    {
        $detected = '';
        foreach ($reports as $report) {
            $detected .= 'VarName ' . $report->getVarName;
            $detected .= ' VarValue '  . $report->getVarValue;
            $detected .= ' VarPath ' . $report->getVarPath;
        }
        return $detected;
    }
}
