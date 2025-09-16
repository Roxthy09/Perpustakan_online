@component('mail::message')
# Halo Pengguna!

Ada pesan baru dari: **{{ $data['name'] }}**  
Email: {{ $data['email'] }}

**Pesan:**  
{{ $data['message'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent 