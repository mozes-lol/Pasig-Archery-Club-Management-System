@props(['size' => '', 'label' => 'Loading', 'message' => '', 'fullscreen' => false])

@push('page-styles')
<link rel="stylesheet" href="/css/components/archery-loader.css">
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600&display=swap" rel="stylesheet">
@endpush

@if($fullscreen)
<div class="loader-overlay" id="archeryLoaderOverlay">
    <div class="loader-container">
        <div class="archery-loader {{ $size }}">
            <div class="loader-ring-wrap">
                <svg class="loader-svg" viewBox="0 0 100 100">
                    <!-- Outermost Ring (Gray) -->
                    <circle class="track" cx="50" cy="50" r="46" stroke="var(--loader-c1)"/>
                    <circle class="arc arc-1" cx="50" cy="50" r="46" stroke="var(--loader-c1)"
                            stroke-dasharray="289" style="--circ:289px"/>

                    <!-- 2nd Ring (Blue) -->
                    <circle class="track" cx="50" cy="50" r="34" stroke="var(--loader-c2)"/>
                    <circle class="arc arc-2" cx="50" cy="50" r="34" stroke="var(--loader-c2)"
                            stroke-dasharray="214" style="--circ:214px"/>

                    <!-- 3rd Ring (Red) -->
                    <circle class="track" cx="50" cy="50" r="22" stroke="var(--loader-c3)"/>
                    <circle class="arc arc-3" cx="50" cy="50" r="22" stroke="var(--loader-c3)"
                            stroke-dasharray="138" style="--circ:138px"/>

                    <!-- Innermost Ring (Gold) -->
                    <circle class="track" cx="50" cy="50" r="10" stroke="var(--loader-c4)"/>
                    <circle class="arc arc-4" cx="50" cy="50" r="10" stroke="var(--loader-c4)"
                            stroke-dasharray="63" style="--circ:63px"/>
                </svg>
                <div class="loader-dot"></div>
            </div>
            <div class="loader-label">{{ $label }}</div>
        </div>
        @if($message)
        <div>
            <div class="loader-message">{{ $message }}</div>
            @if($slot->isNotEmpty())
            <div class="loader-info">{{ $slot }}</div>
            @endif
        </div>
        @endif
    </div>
</div>
@else
<div class="archery-loader {{ $size }}">
    <div class="loader-ring-wrap">
        <svg class="loader-svg" viewBox="0 0 100 100">
            <!-- Outermost Ring (Gray) -->
            <circle class="track" cx="50" cy="50" r="46" stroke="var(--loader-c1)"/>
            <circle class="arc arc-1" cx="50" cy="50" r="46" stroke="var(--loader-c1)"
                    stroke-dasharray="289" style="--circ:289px"/>

            <!-- 2nd Ring (Blue) -->
            <circle class="track" cx="50" cy="50" r="34" stroke="var(--loader-c2)"/>
            <circle class="arc arc-2" cx="50" cy="50" r="34" stroke="var(--loader-c2)"
                    stroke-dasharray="214" style="--circ:214px"/>

            <!-- 3rd Ring (Red) -->
            <circle class="track" cx="50" cy="50" r="22" stroke="var(--loader-c3)"/>
            <circle class="arc arc-3" cx="50" cy="50" r="22" stroke="var(--loader-c3)"
                    stroke-dasharray="138" style="--circ:138px"/>

            <!-- Innermost Ring (Gold) -->
            <circle class="track" cx="50" cy="50" r="10" stroke="var(--loader-c4)"/>
            <circle class="arc arc-4" cx="50" cy="50" r="10" stroke="var(--loader-c4)"
                    stroke-dasharray="63" style="--circ:63px"/>
        </svg>
        <div class="loader-dot"></div>
    </div>
    <div class="loader-label">{{ $label }}</div>
</div>
@endif

<script>
/**
 * Archery Loader JavaScript Utilities
 * Usage:
 *   ArcheryLoader.show()         // Show fullscreen loader
 *   ArcheryLoader.hide()         // Hide fullscreen loader
 *   ArcheryLoader.setMessage(msg) // Update message
 */
window.ArcheryLoader = {
    overlay: null,

    init: function() {
        this.overlay = document.getElementById('archeryLoaderOverlay');
    },

    show: function() {
        if (this.overlay) {
            this.overlay.classList.remove('hidden');
        }
    },

    hide: function() {
        if (this.overlay) {
            this.overlay.classList.add('hidden');
        }
    },

    setMessage: function(msg) {
        if (this.overlay) {
            const msgElement = this.overlay.querySelector('.loader-message');
            if (msgElement) {
                msgElement.textContent = msg;
            }
        }
    },

    toggle: function() {
        if (this.overlay) {
            this.overlay.classList.toggle('hidden');
        }
    }
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    ArcheryLoader.init();
});
</script>
