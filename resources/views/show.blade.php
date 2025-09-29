<!DOCTYPE html>
<html>
<head>
    <title>Conseiller</title>
</head>
<body>
    <h1>Bonjour !</h1>
    <p>
        Vous avez {{ $age }} ans.
        @if($interet === 'developpement')
            Conseil : Continuez à apprendre de nouveaux langages et frameworks !
        @elseif($interet === 'design')
            Conseil : Travaillez votre créativité et inspirez-vous des tendances UI/UX.
        @else
            Conseil : Profitez de vos passions et développez vos compétences.
        @endif
    </p>
</body>
</html>
