<x-mail::message>
# Exportação completa

{{ $content }}

<x-mail::button :url="$attachment">
Download CSV
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
