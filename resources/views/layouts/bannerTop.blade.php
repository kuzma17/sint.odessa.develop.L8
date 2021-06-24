@if(\App\Models\Banner::find(1)->active == 1)
    <div class="banner">{!! \App\Models\Banner::find(1)->banner !!}</div>
@endif
