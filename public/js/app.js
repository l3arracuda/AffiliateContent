document.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-copy-link]');
    if (!button) return;
    const feedback = document.getElementById('copy-feedback');
    try {
        await navigator.clipboard.writeText(button.dataset.copyLink);
        feedback.textContent = 'Affiliate link copied.';
        const response = await fetch(button.dataset.logUrl, {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json'},
        });
        if (!response.ok) feedback.textContent = 'Link copied. Activity could not be logged.';
    } catch (error) {
        feedback.textContent = 'Copy failed. Please copy the URL shown above manually.';
    }
});
