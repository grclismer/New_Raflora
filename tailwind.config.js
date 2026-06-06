//
// ================================================================================
// DEVELOPER DOCUMENTATION - tailwind.config.js
// ================================================================================
// Purpose: Tailwind CSS v4 configuration with content paths for Blade files.
// Stack: JavaScript - Tailwind CSS configuration.
// Dependencies:
//   - Tailwind CSS v4
// Process Logic:
//   - Content paths: Scans all .blade.php, .js, and .vue files for class usage
//   - Enables JIT compilation for optimized CSS output
// AI Context: PROJECT_CONTEXT: Frontend-focused Laravel/Tailwind build. AI Analysis integration in progress.
// ================================================================================

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}