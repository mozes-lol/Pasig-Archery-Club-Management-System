@props([
    'color' => 'primary',
    'type' => 'button',
    'size' => 'md',
    'disabled' => false,
    'href' => null,
])

@php
    $baseClasses = 'btn btn-' . $color;
    $sizeClasses = match($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => '',
    };
    $classes = trim($baseClasses . ' ' . $sizeClasses);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button 
        type="{{ $type }}" 
        @disabled($disabled)
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </button>
@endif

<style>
    /* Button Base Styles */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 1rem;
    }

    .btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn:active:not(:disabled) {
        transform: translateY(0);
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Color Variants */
    .btn-primary {
        background: linear-gradient(135deg, #3a86ff 0%, #265dcc 100%);
        color: white;
    }

    .btn-primary:hover:not(:disabled) {
        background: linear-gradient(135deg, #4d96ff 0%, #1e4ab8 100%);
        box-shadow: 0 4px 15px rgba(58, 134, 255, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-success:hover:not(:disabled) {
        background: linear-gradient(135deg, #1ac693 0%, #037857 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .btn-warning:hover:not(:disabled) {
        background: linear-gradient(135deg, #f7b41d 0%, #c46d05 100%);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-danger:hover:not(:disabled) {
        background: linear-gradient(135deg, #f55555 0%, #cc1515 100%);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #9ABDD5 0%, #6D7392 100%);
        color: white;
    }

    .btn-secondary:hover:not(:disabled) {
        background: linear-gradient(135deg, #a8c9e0 0%, #5a647f 100%);
        box-shadow: 0 4px 15px rgba(106, 115, 146, 0.4);
    }

    .btn-outline {
        background-color: transparent;
        color: #3a86ff;
        border: 2px solid #3a86ff;
    }

    .btn-outline:hover:not(:disabled) {
        background: linear-gradient(135deg, #3a86ff 0%, #265dcc 100%);
        color: white;
        border-color: transparent;
    }

    /* Size Variants */
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .btn-lg {
        padding: 1rem 2rem;
        font-size: 1.125rem;
    }
</style>
