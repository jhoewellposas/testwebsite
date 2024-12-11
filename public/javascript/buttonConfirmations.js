document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            const confirmation = confirm('Do you want to delete this certificate?');
            if (confirmation) {
                form.submit();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const updateButtons = document.querySelectorAll('.update-button');

    updateButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            const confirmation = confirm('Do you want to update this profile?');
            if (confirmation) {
                form.submit();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const deleteAllButtons = document.querySelectorAll('.delete-all-button');

    deleteAllButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            const confirmation = confirm('!WARNING!\n\nYou are about to delete ALL certificates from this profile!\n\n!WARNING!');
            if (confirmation) {
                form.submit();
            }
        });
    });
});