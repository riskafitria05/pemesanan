@if(session('success'))<div class="flash success" role="status">{{ session('success') }}</div>@endif
@if(session('error'))<div class="flash error" role="alert">{{ session('error') }}</div>@endif
@if($errors->any())
<div class="flash error" role="alert"><strong>Periksa kembali isian Anda:</strong>
<ul style="margin:.3rem 0 0 1.1rem;padding:0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif
