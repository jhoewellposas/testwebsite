document.addEventListener('DOMContentLoaded', function () {
    const rankSelect = document.getElementById('next_rank');
    const nextRequirementsCell = document.getElementById('next-requirements');

    // Define rank requirements (these will be dynamically added from the server-side)
    const basicRequirements = window.basicRequirements || {};
    const higherRequirements = window.higherRequirements || {};

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
        'Full Professor 3 SQ': 'Full Professor 3',
    };

    rankSelect.addEventListener('change', function () {
        let selectedRank = rankSelect.value;

        // Map SQ rank to its corresponding base rank if applicable
        if (sqRankMapping[selectedRank]) {
            selectedRank = sqRankMapping[selectedRank];
        }

        // Get requirements based on rank type
        let requirements = basicRequirements[selectedRank] || higherRequirements[selectedRank];

        // Update the requirements in the DOM
        if (requirements) {
            nextRequirementsCell.innerHTML = requirements
                .map(req => `<li>${req}</li>`)
                .join('');
        } else {
            nextRequirementsCell.textContent = 'No requirements available for the selected rank.';
        }
    });

    // Trigger change event on page load to set default values
    rankSelect.dispatchEvent(new Event('change'));
});
