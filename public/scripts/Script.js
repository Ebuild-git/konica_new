
/////////////Testimonial//////////
$(document).ready(function() {
    $('#testimonialForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(response) {

                $('#testimonialModal').modal('hide');

                $('#successMessage').text(
                    'Témoignage créé avec succès! Il sera valide après confirmation des administrateurs'

                ).show();

                setTimeout(function() {
                    location.reload();
                }, 5000);
            },
            error: function(response) {

                $('#errorMessage').text('Une erreur est survenue.')
                    .show();
            }
        });
    });
});