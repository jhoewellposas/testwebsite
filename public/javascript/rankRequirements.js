document.addEventListener('DOMContentLoaded', function () {
    const rankSelect = document.getElementById('rank');
    const nextRankCell = document.getElementById('next-rank');
    const nextRequirementsCell = document.getElementById('next-requirements');

    const requirements = window.rankRequirements || {};

    // Create a mapping for SQ ranks to their corresponding base ranks
    const sqRankMapping = {
        'Teacher 1 SQ': 'Teacher 1',
        'Teacher 2 SQ': 'Teacher 2',
        'Teacher 3 SQ': 'Teacher 3',
        'Teacher 4 SQ': 'Teacher 4',
        'Teacher 5 SQ': 'Teacher 5',
        'Senior Teacher 1 SQ': 'Senior Teacher 1',
        'Senior Teacher 2 SQ': 'Senior Teacher 2',
        'Senior Teacher 3 SQ': 'Senior Teacher 3',
        'Senior Teacher 4 SQ': 'Senior Teacher 4',
        'Senior Teacher 5 SQ': 'Senior Teacher 5',
        'Master Teacher 1 SQ': 'Master Teacher 1',
        'Master Teacher 2 SQ': 'Master Teacher 2',
        'Master Teacher 3 SQ': 'Master Teacher 3',
        'Master Teacher 4 SQ': 'Master Teacher 4',
        'Lecturer 1 SQ': 'Lecturer 1',
        'Lecturer 2 SQ': 'Lecturer 2',
        'Lecturer 3 SQ': 'Lecturer 3',
        'Assistant Instructor SQ': 'Assistant Instructor',
        'Instructor 1 SQ': 'Instructor 1',
        'Instructor 2 SQ': 'Instructor 2',
        'Instructor 3 SQ': 'Instructor 3',
        'Assistant Professor 1 SQ': 'Assistant Professor 1',
        'Assistant Professor 2 SQ': 'Assistant Professor 2',
        'Associate Professor 1 SQ': 'Associate Professor 1',
        'Associate Professor 2 SQ': 'Associate Professor 2',
        'Full Professor 1 SQ': 'Full Professor 1',
        'Full Professor 2 SQ': 'Full Professor 2',
        'Full Professor 3 SQ': 'Full Professor 3'
    };

    rankSelect.addEventListener('change', function () {
        let currentRank = rankSelect.value;

        // If the selected rank is an SQ rank, map it to the base rank
        if (sqRankMapping[currentRank]) {
            currentRank = sqRankMapping[currentRank];
        }

        // Define the rank orders for basic and higher requirements
        const basicRankOrder = Object.keys(requirements).filter(rank =>
            ['Teacher', 'Senior Teacher', 'Master Teacher'].some(prefix => rank.startsWith(prefix))
        );
        const higherRankOrder = Object.keys(requirements).filter(rank =>
            ['Lecturer', 'Assistant Instructor', 'Instructor', 'Assistant Professor', 'Associate Professor', 'Full Professor'].some(prefix => rank.startsWith(prefix))
        );

        let nextRank = null;

        if (basicRankOrder.includes(currentRank)) {
            const currentIndex = basicRankOrder.indexOf(currentRank);
            if (currentIndex !== -1 && currentIndex < basicRankOrder.length - 1) {
                nextRank = basicRankOrder[currentIndex + 1];
            }
        } else if (higherRankOrder.includes(currentRank)) {
            const currentIndex = higherRankOrder.indexOf(currentRank);
            if (currentIndex !== -1 && currentIndex < higherRankOrder.length - 1) {
                nextRank = higherRankOrder[currentIndex + 1];
            }
        }

        // Update the table
        if (currentRank === 'Master Teacher 4') {
            // Special case: Master Teacher 4 is the last rank in basicRequirements
            nextRankCell.textContent = 'No further rank';
            nextRequirementsCell.textContent = 'No further requirements';
        } else if (nextRank) {
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
