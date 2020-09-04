{{-- Currently unused - default is en_US --}}
<h1>{{ $subject }}</h1>

<h4>Details del usuario</h4>
<p>Usuario: {{ $user }}</p>
<p>URL: {{ $url }}</p>
<p>IP: {{ $ip }}</p>

<h4>Mensaje</h4>
@if ($error->getMessage())
  {{ $error->getMessage() }}
@else
  <p>No hay mensaje.</p>
@endif

<h4>Codigo del Error</h4>
{{ $error->getCode() }}

<h4>Ocurio con el archive</h4>
{{ $error->getFile() }}

<h4>Error</h4>
{{ $error }}
