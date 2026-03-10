<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de votre rendez-vous</title>
</head>

<body style="margin:0; padding:0; background-color:#f5f7fa; font-family:Arial, sans-serif;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background-color:#ffffff; border-radius:8px; overflow:hidden;">
        <!-- Header -->
        <tr>
            <td style="background-color:#0d6efd; padding:25px; text-align:center; color:#ffffff;">
                <h1 style="margin:0; font-size:22px;">Confirmation de rendez-vous</h1>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding:25px; color:#333333; font-size:16px; line-height:1.6;">
                <p>Bonjour <strong>{{ $user->name }}</strong>,</p>
                <p>Votre rendez-vous a bien été confirmé.</p>

                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:15px; border:1px solid #e0e0e0; border-radius:5px;">
                    <tr>
                        <td style="padding:10px; font-weight:bold; background-color:#f8f9fa; width:40%;">Date du rendez-vous :</td>
                        <td style="padding:10px;">{{ \Carbon\Carbon::parse($appointment->selectedStart)->translatedFormat('d F Y à H:i') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:10px; font-weight:bold; background-color:#f8f9fa;">Véhicule :</td>
                        <td style="padding:10px;">{{ $cars->make }} {{ $cars->model }} ({{ $cars->year }})</td>
                    </tr>
                </table>

                <p style="margin-top:25px;">
                    Pour toute question ou modification, vous pouvez nous contacter directement depuis votre espace client.
                </p>

                <p style="margin-top:30px; text-align:center;">
                    <a href="{{ url('/mon-espace') }}"
                       style="display:inline-block; background-color:#0d6efd; color:#ffffff; padding:12px 25px; text-decoration:none; border-radius:5px; font-weight:bold;">
                       Voir mon rendez-vous
                    </a>
                </p>

                <p style="margin-top:25px; font-size:13px; color:#777777;">
                    Si vous n’avez pas pris de rendez-vous chez Garage Auto, vous pouvez ignorer cet email.
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color:#f0f0f0; color:#888888; text-align:center; font-size:12px; padding:15px;">
                &copy; {{ date('Y') }} Garage Auto — Tous droits réservés
            </td>
        </tr>
    </table>
</body>
</html>
