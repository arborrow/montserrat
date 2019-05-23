<h1>Polanco Error Detected</h1>

<h4>Message</h4>
@if ($error->getMessage())
  {{!! $error->getMessage() !!}}
@else
  <p>No message.</p>
@endif

<h4>Error Code</h4>
{{!! $error->getCode() !!}}

<h4>Occurred At</h4>
{{!! $error->getFile() !!}}

<h4>Error as String</h4>
{{!! $error->__toString() !!}}