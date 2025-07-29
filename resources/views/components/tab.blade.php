@props(['title', 'text', 'icon' => 'fas fa-info-circle', 'theme' => 'primary', 'items' => [], 'contents' => []])

@php

    if (is_array($items)) {
        $items = collect($items)
            ->map(function ($item, $index) {
                return [
                    'id' => 'tab-' . $index,
                    'label' => $item,
                ];
            })
            ->toArray();
    }

    $classes = "card card-{$theme} card-tabs";
    $linkClasses = "nav-link link-{$theme}";
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <div class="card-header p-0 pt-1 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
            @if (is_array($items))
                @foreach ($items as $item)
                    <li class="nav-item">
                        <a class="{{ $linkClasses }} {{ $loop->first ? 'active' : '' }}" id="{{ $item['id'] }}-tab"
                            data-toggle="pill" href="#{{ $item['id'] }}" role="tab"
                            aria-controls="{{ $item['id'] }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            @else
                {{ $items }}
            @endif
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-three-tabContent">
            @if (is_array($contents))
                @foreach ($contents as $key => $content)
                    <div class="tab-pane fade {{ $loop->first ? 'active show' : '' }}" id="{{ $items[$key]['id'] }}"
                        role="tabpanel" aria-labelledby="{{ $items[$key]['id'] }}-tab">
                        {!! $content !!}
                    </div>
                @endforeach
            @else
                {{ $contents }}
            @endif
        </div>
    </div>
</div>
