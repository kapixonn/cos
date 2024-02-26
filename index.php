<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Nagłowek strony</h1>
    </header>
    <div id="container">
        <?php
        
        $db = new mysqli('localhost', 'root', '', 'cms');
        
        $q = $db->prepare("SELECT post.id, post.imgUrl, post.title, 
                                    post.timestamp, user.email 
                            FROM `post` 
                            INNER JOIN user ON post.author = user.ID
                            ORDER BY post.timestamp DESC;");
        //wywołaj kwerendę
        $q->execute();
        //pobierz dane
        $result = $q->get_result();
        while($row = $result->fetch_assoc()) {
            //$row to jeden wiersz z bazy danych
            echo '<div class="post-block">';
            echo '<h2 class="post-title">'.$row['title'].'</h3>';
            echo '<h3 class="post-author">'.$row['email'].'</h6>';
            echo '<img src="'.$row['imgUrl'].'" alt="obrazek posta" class="post-image">';
            echo '<p class="post-description">TODO: Opis posta</p>';
            echo '<div class="post-footer">
                <span class="post-meta">'.$row['timestamp'].'</span>
                <span class="post-score">TODO: punkty</span>
                </div>';
            echo '</div>'; //post-block
        }
        ?>

        <!--<div class="post-block">
            <h2 class="post-title">Tytuł posta</h3>
            <h3 class="post-author">Autor posta</h6>
            <img src="https://picsum.photos/800/600" alt="obrazek posta" class="post-image">
            <p class="post-description">Opis posta</p>
            <div class="post-footer">
                <span class="post-meta">Data i czas</span>
                <span class="post-score">+ i -</span>
            </div>
            
        </div>
    -->
    </div>
</body>
</html>