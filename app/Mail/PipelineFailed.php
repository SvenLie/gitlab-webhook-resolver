<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PipelineFailed extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string */
    public $projectName;

    /** @var array */
    public $failedSteps;

    /** @var string */
    public $linkToPipeline;

    /**
     * @param $projectName
     * @param $failedSteps
     * @param $linkToPipeline
     */
    public function __construct($projectName, $failedSteps, $linkToPipeline)
    {
        $this->projectName = $projectName;
        $this->failedSteps = $failedSteps;
        $this->linkToPipeline = $linkToPipeline;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->projectName . ' | ' . trans('pipeline_failed.pipeline_failed');
        return $this->from(env('MAIL_FROM_ADDRESS'), $this->projectName)->subject($subject)->markdown('emails.pipeline.failed');
    }
}
