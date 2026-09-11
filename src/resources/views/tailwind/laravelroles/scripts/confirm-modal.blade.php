{{--
    The Tailwind confirm modal is driven by Alpine.js: trigger buttons dispatch
    a `roles-confirm` window event carrying the modal id, title, message and the
    form to submit, and the modal component in
    laravelroles::laravelroles.modals.confirm-modal listens for it.

    No imperative wiring is needed here, so this include is intentionally empty.
    It is kept so the shared include path resolves for every CSS framework.
--}}
