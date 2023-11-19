{{-- For submenu --}}
<ul class="menu-content">
  @if(isset($menu))
  @foreach($menu as $submenu)
    @php
        $custom_classes_submenu='';
        if(isset($submenu->permission) && auth()->user()->cannot($submenu->permission)){
            $custom_classes_submenu = 'hidden';
        }
        //var_dump($submenu->permission);
    @endphp

  <li @if($submenu->slug === Route::currentRouteName()) class="active {{$custom_classes_submenu}}" @else class="{{$custom_classes_submenu}}" @endif>
    <a href="{{isset($submenu->url) ? url($submenu->url):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'}}">
      @if(isset($submenu->icon))
      <i data-feather="{{$submenu->icon}}"></i>
      @endif
      <span class="menu-item text-truncate">{{ __($submenu->name) }}</span>
    </a>
    @if (isset($submenu->submenu))
    @include('panels/submenu', ['menu' => $submenu->submenu])
    @endif
  </li>
  @endforeach
  @endif
</ul>
