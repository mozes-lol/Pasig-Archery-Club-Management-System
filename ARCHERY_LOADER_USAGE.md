# Archery Loader Component

A beautiful, archery-themed loading spinner component for the Pasig Archery Club Management System.

## Features

- 🏹 Archery-themed animated rings (4 concentric circles)
- ⚡ Smooth cascade animation with staggered rings
- 🎯 Center bullseye dot for visual impact
- 💫 Animated "Loading..." text with ellipsis
- 📱 Fully responsive design
- 🎨 Three size presets: small, medium (default), large
- 🔄 Easy to show/hide with JavaScript
- ✨ Customizable colors via CSS variables

## Installation

The component is already installed in your application:
- CSS: `/public/css/components/archery-loader.css`
- Blade Component: `/resources/views/components/archery-loader.blade.php`

## Usage

### 1. Inline Loader (Small, Medium, Large)

#### Medium (Default)
```blade
<x-archery-loader />
```

#### Small
```blade
<x-archery-loader size="sm" />
```

#### Large
```blade
<x-archery-loader size="lg" />
```

---

### 2. Fullscreen Overlay Loader

Perfect for page loads or async operations:

```blade
<x-archery-loader fullscreen />
```

#### With Custom Label
```blade
<x-archery-loader fullscreen label="PROCESSING" />
```

#### With Message
```blade
<x-archery-loader fullscreen label="LOADING" message="Fetching archer data..." />
```

#### With Additional Info
```blade
<x-archery-loader fullscreen label="LOADING" message="Initializing system">
    Please wait, this may take a few seconds...
</x-archery-loader>
```

---

## JavaScript API

When using `fullscreen="true"`, a global `ArcheryLoader` object is available:

```javascript
// Show the fullscreen loader
ArcheryLoader.show();

// Hide the fullscreen loader
ArcheryLoader.hide();

// Toggle loader visibility
ArcheryLoader.toggle();

// Update the message
ArcheryLoader.setMessage("Processing your request...");
```

### Example Usage

```javascript
// Show loader when submitting form
document.getElementById('myForm').addEventListener('submit', function() {
    ArcheryLoader.show();
});

// Hide after AJAX request completes
fetch('/api/archers')
    .then(response => response.json())
    .then(data => {
        ArcheryLoader.hide();
        // Process data...
    });
```

---

## Customization

### Size Variations

Three preset sizes are available:

| Class | Width | Stroke | Speed |
|-------|-------|--------|-------|
| sm    | 56px  | 6px    | 1.8s  |
| (default) | 100px | 9px | 2.2s |
| lg    | 160px | 13px   | 2.6s  |

### Color Customization

Customize loader colors using CSS variables:

```css
.archery-loader {
    --loader-c1: #c8d0de;  /* Outermost ring (gray) */
    --loader-c2: #5b9bd5;  /* 2nd ring (blue) */
    --loader-c3: #d63030;  /* 3rd ring (red) */
    --loader-c4: #e0b800;  /* Innermost ring (gold) */
}
```

### Speed Customization

```css
.archery-loader {
    --loader-speed: 2.2s;  /* Default: 2.2s */
}

.archery-loader.fast {
    --loader-speed: 1.5s;
}

.archery-loader.slow {
    --loader-speed: 3s;
}
```

---

## Examples

### Example 1: Page Load Indicator
```blade
@if($loading)
    <x-archery-loader fullscreen label="LOADING" message="Fetching training logs..." />
@endif
```

### Example 2: Form Submission
```blade
<form id="archersForm" onsubmit="handleSubmit(event)">
    <button type="submit">Add Archer</button>
</form>

<x-archery-loader fullscreen />

<script>
function handleSubmit(event) {
    event.preventDefault();
    ArcheryLoader.show();
    ArcheryLoader.setMessage("Creating new archer...");
    
    // Submit form
    setTimeout(() => {
        ArcheryLoader.hide();
    }, 2000);
}
</script>
```

### Example 3: AJAX Loading
```javascript
document.getElementById('refreshBtn').addEventListener('click', function() {
    ArcheryLoader.show();
    ArcheryLoader.setMessage("Refreshing data...");
    
    fetch('/api/archers')
        .then(response => response.json())
        .then(data => {
            // Process data
            ArcheryLoader.hide();
        })
        .catch(error => {
            console.error('Error:', error);
            ArcheryLoader.hide();
        });
});
```

---

## Animation Details

The loader features a sophisticated cascade animation:

1. **Ring 1 (Gray)** - Animates first (delay: 0s)
2. **Ring 2 (Blue)** - Follows with stagger (delay: ~0.26s)
3. **Ring 3 (Red)** - Continues cascade (delay: ~0.53s)
4. **Ring 4 (Gold)** - Completes ring animation (delay: ~0.79s)
5. **Bullseye Dot** - Fires after rings are full (delay: ~1.28s)

All rings fade out together, then the cycle repeats.

---

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- CSS animations and transforms required
- SVG support required
- ES6 JavaScript (for ArcheryLoader object)

---

## Component Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| size | string | '' | Size preset: 'sm' or 'lg' |
| label | string | 'Loading' | Text label below loader |
| message | string | '' | Main message text |
| fullscreen | boolean | false | Show as fullscreen overlay |
| slot | string | '' | Additional info text below message |

---

## Styling with Tailwind (Optional)

If using Tailwind CSS, you can add custom classes:

```css
@apply fixed inset-0 flex items-center justify-center z-9999;
```

---

## Tips & Best Practices

1. **Always hide after operations** - Use `ArcheryLoader.hide()` when done
2. **Add timeout fallback** - Prevent infinite loading if something fails
3. **Customize messages** - Help users understand what's happening
4. **Use for long operations** - Show loader for operations > 1 second
5. **Mobile friendly** - Loader is responsive and works on all devices

---

## License

Part of Pasig Archery Club Management System
