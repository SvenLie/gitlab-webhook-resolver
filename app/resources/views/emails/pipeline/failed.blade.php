@component('mail::message', ['header' => $projectName])
# {{ trans('pipeline_failed.heading') }}

{{ trans('pipeline_failed.description') }}

@component('mail::table')
    | {{ trans('pipeline_failed.step') }}       |
    |  :--------|
    @foreach($failedSteps as $failedStep)
    | {{$failedStep}}    |
    @endforeach
@endcomponent

@component('mail::button', ['url' => $linkToPipeline])
    {{ trans('pipeline_failed.link_text') }}
@endcomponent
@endcomponent
