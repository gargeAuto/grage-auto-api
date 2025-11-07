<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendez-vous</title>
</head>

<body>
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:0 auto; background-color:#ffffff; border-collapse:collapse;">
        <!-- Header -->
        <tr>
            <td style="background-color:#0d6efd; color:#ffffff; padding:20px; text-align:center;">
                <h1 style="margin:0; font-size:24px;">Bonjour {{ $user->name }},</h1>
            </td>
        </tr>
        <!-- Body -->
        <tr>
            <td style="padding:20px; color:#333333; font-size:16px; line-height:1.5;">
                <p>Merci pour votre commande.</p>
                <p>Votre rendez-vous à bien été pris pour le: {{ $appointment->date }}</p>
                <p>Votre voiture: {{ $cars->make }} {{ $cars->model }} {{ $cars->year }}</p>
                

                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-top:10px;">
                  
                    <tr>
                        <td style="padding:5px 0;"></td>
                        <td style="padding:5px 0; text-align:right;"> €</td>
                    </tr>
                  
                    <tr>
                        <td style="padding:10px 0; font-weight:bold;">Total</td>
                        <td style="padding:10px 0; text-align:right; font-weight:bold;" €</td>
                    </tr>
                </table>

                <p style="margin-top:20px;">
                    <a href=""
                        style="display:inline-block; background-color:#0d6efd; color:#ffffff; padding:10px 20px; text-decoration:none; border-radius:5px;">
                        Payer maintenant
                    </a>
                </p>

                <p style="margin-top:20px; font-size:12px; color:#888888;">
                    Si vous n'avez pas demandé cette facture, ignorez cet email.
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color:#f4f4f4; color:#888888; text-align:center; font-size:12px; padding:10px;">
                &copy; {{ date('Y') }} Garage Auto. Tous droits réservés.
            </td>
        </tr>
    </table>

</body>

</html>