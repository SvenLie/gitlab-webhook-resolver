<?php

namespace App\Http\Controllers\PipelineEvent;

use App\Http\Controllers\EventControllerInterface;
use App\Mail\PipelineFailed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Routing\Controller;

class MailController extends Controller implements EventControllerInterface
{
    public function reactToEvent(Request $request)
    {
        $requestBodyJson = $request->getContent();
        $requestBody = json_decode($requestBodyJson, true);

        if ($requestBody['object_kind'] != 'pipeline') return response()->json(['message' => 'No pipeline event'], 500);
        if (empty($requestBody['project']) || empty($requestBody['builds']) || empty($requestBody['object_attributes'])) return response()->json(['message' => 'No valid project or build'], 501);

        $project = $requestBody['project'];
        $builds = $requestBody['builds'];
        $pipelineAttributes = $requestBody['object_attributes'];

        $projectName = $project['namespace'] . ' - ' . $project['name'];
        $pipelineUrl = $project['web_url'] . '/-/pipelines/' . $pipelineAttributes['id'];
        $failedSteps = [];

        if ($pipelineAttributes['detailed_status'] != 'failed') {
            return response()->json(['message' => 'No action needed', 201]);
        }

        foreach ($builds as $build) {

            if ($build['status'] == 'failed' && !$build['allow_failure']) {
                $failedSteps[] = $build['name'];
            }

        }

        $recipients = $this->getRecipients();

        if (!$recipients) return response()->json(['message' => 'Wrong configuration'], 502);

        Mail::to($request->user())->to($recipients)->send(new PipelineFailed($projectName, $failedSteps, $pipelineUrl));

        return response()->json(['message' => 'Done']);
    }

    protected function getRecipients(): array|bool
    {
        $recipientString = env('MAIL_TO_PIPELINE_EVENT');

        if (empty($recipientString)) return false;

        $recipients = explode(',', $recipientString);

        if (empty($recipients)) return false;

        return $recipients;
    }
}
