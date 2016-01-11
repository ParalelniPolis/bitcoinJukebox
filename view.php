<html>
    <head>
        <link rel=stylesheet href="style.css">
    </head>
    <body>
        <?php foreach ($songs as $s) {
            echo('<div class="song">');
            if (!empty($s['title'])) echo($s['title'] . ' from ' . $s['artist']);
            else echo($s['nameOfFile']);
            echo ('</div>');
        } ?>
    </body>
</html>

