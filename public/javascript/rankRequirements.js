document.addEventListener('DOMContentLoaded', function () {
    const rankSelect = document.getElementById('rank');
    const nextRankCell = document.getElementById('next-rank');
    const nextRequirementsCell = document.getElementById('next-requirements');

    const requirements = window.rankRequirements || {};

    rankSelect.addEventListener('change', function () {
        const currentRank = rankSelect.value;

        // Get the next rank
        let nextRank = null;
        const rankOrder = Object.keys(requirements);
        const currentIndex = rankOrder.indexOf(currentRank);
        if (currentIndex !== -1 && currentIndex < rankOrder.length - 1) {
            nextRank = rankOrder[currentIndex + 1];
        }

        // Update the table
        if (nextRank) {
            nextRankCell.textContent = nextRank;
            nextRequirementsCell.innerHTML = requirements[nextRank]
                .map(req => `<li>${req}</li>`)
                .join('');
        } else {
            nextRankCell.textContent = 'No further rank';
            nextRequirementsCell.textContent = 'No further requirements';
        }
    });

    // Trigger change event on page load to set default values
    rankSelect.dispatchEvent(new Event('change'));
});