@component('mail::message', ['header' => $projectName])
# Pipeline ist fehlgeschlagen

Die folgenden Steps sind fehlgeschlagen:


@component('mail::table')
    | Step       |
    |  :--------|
    @foreach($failedSteps as $failedStep)
    | {{$failedStep}}    |
    @endforeach
@endcomponent

@component('mail::button', ['url' => $linkToPipeline])
Link zur Pipeline
@endcomponent
@endcomponent
