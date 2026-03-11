@props([
    'title' => null,
    'subtitle' => null,
    'header' => null,
    'footer' => null,
])

<div class="card" {{ $attributes }}>
    @if($header)
        <div class="card-header">
            {{ $header }}
        </div>
    @elseif($title)
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            @if($subtitle)
                <p class="card-subtitle">{{ $subtitle }}</p>
            @endif
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>

<style>
    .card {
        background: white;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .card-header {
        padding: 1.5rem;
        border-bottom: 2px solid #6D7392;
        background: linear-gradient(135deg, #e0eef8 0%, #f0f6fc 100%);
        border-left: 4px solid #156EC4;
    }

    .card-title {
        margin: 0 0 0.5rem 0;
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
    }

    .card-subtitle {
        margin: 0;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .card-body {
        padding: 1.5rem;
        color: #374151;
    }

    .card-footer {
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
        background-color: #f9fafb;
    }
</style>
