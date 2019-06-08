<h1>{{ $subject }}</h1>

<h4>User Details</h4>
<p>Username: {{ $user }}</p>
<p>URL: {{ $url }}</p>
<p>IP: {{ $ip }}</p>

<h4>Message</h4>
@if ($error->getMessage())
  {{ $error->getMessage() }}
@else
  <p>No message.</p>
@endif

<h4>Error Code</h4>
{{ $error->getCode() }}

<h4>Occurred At</h4>
{{ $error->getFile() }}

<h4>Error as String</h4>
{{ $error }}
