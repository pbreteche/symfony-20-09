'use strict';

document.addEventListener('DOMContentLoaded', function(){
    const links = document.querySelectorAll('.delete-link');

    for (const link of links) {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            if (window.confirm('Supprimer l\'article?')) {
                fetch(this.href, {
                    method: 'DELETE',
                }).then(response => {
                    if (response.redirected) {
                        // redirect page is loaded twice => not optimal
                        window.location.href = response.url;
                    }
                });
            }
        });
    }
});
