# Blade View Guidelines

This document captures the expectations for building and maintaining Blade views in DubDex. It focuses on composing pages from reusable components so that shared UI patterns stay consistent across the application.

## When to Create or Use a Component

- **Reach for existing components first.** Review `resources/views/components` and `resources/views/partials` before introducing new markup. Reuse components like `components.layouts.*`, `components.settings.*`, and shared partials when they already satisfy the requirement.
- **Create a component when markup repeats.** If a fragment appears in three or more places (or is likely to), extract it into `resources/views/components`. Name the file after the intent of the fragment (`search-filter.blade.php`, `empty-state.blade.php`, etc.).
- **Prefer slot-based APIs.** When you introduce a new component, structure it so that content areas are passed as slots (`<x-component>…</x-component>`). Slots keep components flexible and reduce duplication.
- **Keep layout concerns inside layout components.** Views under `resources/views/layouts` or `resources/views/components/layouts` should encapsulate structural HTML, head metadata, and navigation so feature views only render their unique content.

## Authoring Views

- **Group feature views together.** Keep domain-specific views in a folder (for example, `resources/views/animes`) and compose them from smaller components. Shared logic should live in components or view-model classes, not repeated blade directives.
- **Use partials for single-use helpers.** If a view needs a helper that is unlikely to be reused elsewhere, place it under `resources/views/partials` and include it with `@include`.
- **Document parameters.** Add a leading Blade comment describing any data a component expects. That context shortens onboarding for future contributors.
- **Style with utility classes.** Follow the existing Tailwind-style class conventions used in the repository. Avoid embedding raw `<style>` blocks inside Blade files.

## Reviewing Pull Requests for Reuse

- **Scan new or updated views for repeated patterns.** During code review, compare the change against recently merged views to spot duplication.
- **Encourage component extraction.** When repetition is identified, suggest converting the shared snippet into a component or partial following the rules above.
- **Schedule periodic audits.** At least once per iteration, review the `resources/views` tree for opportunities to extract reusable components from recently added pages.

Keeping these guidelines in mind ensures DubDex grows with a consistent, maintainable interface.
