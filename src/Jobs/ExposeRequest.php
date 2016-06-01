<?php

namespace SCollins\LaravelExpose\Jobs;

use Expose;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExposeRequest extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $input;
    protected $ip;

    /**
     * Create a new job instance.
     * @param array $input
     * @param string $ip
     */
    public function __construct(array $input, string $ip)
    {
        $this->input = $input;
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Expose::run($this->input);
        if (Expose::getImpact() > 0) {
            Expose::getLogger()->warning('Expose risk level ' . Expose::getImpact() . ' for ' . $this->ip . ':'.
                Expose::getReports());
        }
    }
}
