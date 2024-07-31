@component('mail::message')
# Document Status Updated

Hello {{ $userName }},

The status of your document titled "{{ $documentTitle }}" has been updated to "{{ $documentStatus }}".

@component('mail::button', ['url' => url('/documents/' . $document->id)])
View Document
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent