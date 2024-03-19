<?php
function choix_de_page(int $numero_page, int $nombre_page, string $page):void
{
    echo '<div class="choix_de_page" style="grid-template-columns: '; for($i=0; $i < $nombre_page && $i < 11; $i++) echo '1fr '; echo '">';

        if ($numero_page != 1 && $nombre_page > 9) {
            echo '<button onclick="redirect('.$numero_page - 1 .')"><</button>';
        }
        echo '<button onclick="redirect(1)">1</button>';
        if ($nombre_page > 1){
            if ($nombre_page < 10 || $numero_page < 4 || $numero_page > $nombre_page - 3){
                echo '<button onclick="redirect(2)">2</button>';
            } else {
              echo '<button>...</button>';
            }
        }
        if ($nombre_page  > 2) {
            if ($nombre_page < 10 || $numero_page > $nombre_page - 3 || $numero_page < 4){
                echo '<button onclick="redirect(3)">3</button>';
            }else{
                echo '<button onclick="redirect('.$numero_page - 2 .')">'.$numero_page - 2 .'</button>';
            }
        }
        if ($nombre_page > 3){
            if ($nombre_page < 10 || $numero_page > $nombre_page - 3 || $numero_page < 4){
                echo '<button onclick="redirect(4)">4</button>';
            } else {
                echo '<button onclick="redirect('.$numero_page - 1 .')">'. $numero_page - 1 .'</button>';
            }
        }
        if ($nombre_page > 4){
            if ($nombre_page < 10){
                echo '<button onclick="redirect(5)">5</button>';
            } else if ($numero_page < 4 || $numero_page > $nombre_page - 3){
                echo '<button>...</button>';
            } else {
                echo '<button>'. $numero_page .'</button>';
            }
        }
        if ($nombre_page > 5){
            if ($nombre_page < 10){
                echo '<button onclick="redirect(6)">6</button>';
            } else if ($numero_page < 4 || $numero_page > $nombre_page - 3){
                echo '<button onclick="redirect('.$nombre_page - 3 .')">'.$nombre_page - 3 .'</button>';
            } else {
                echo '<button onclick="redirect('.$numero_page + 1 .')">'. $numero_page + 1 .'</button>';
            }
        }
        if ($nombre_page > 6){
            if ($nombre_page < 10){
                echo '<button onclick="redirect(7)">7</button>';
            } else if ($numero_page < 4 || $numero_page > $nombre_page - 3){
                echo '<button onclick="redirect('.$nombre_page - 2 .')">'.$nombre_page - 2 .'</button>';
            } else {
                echo '<button onclick="redirect('.$numero_page + 2 .')">'. $numero_page + 2 .'</button>';
            }
        }
        if ($nombre_page > 7){
            if ($nombre_page < 10){
                echo '<button onclick="redirect(8)">8</button>';
            } else if ($numero_page < 4 || $numero_page > $nombre_page - 3){
                echo '<button onclick="redirect('.$nombre_page - 1 .')">'.$nombre_page - 1 .'</button>';
            } else {
                echo '<button>...</button>';
            }
        }
        if ($nombre_page > 8){
            echo '<button onclick="redirect('.$nombre_page.')">'. $nombre_page .'</button>';
        }
        if ($nombre_page > 9 && $numero_page != $nombre_page){
            echo '<button onclick="redirect('.$numero_page + 1 .')">></button>';
        }
        echo '
    </div>
    <script>
        function redirect (no_page){
            ';
            if (isset($_GET['recherche'])){
                echo 'window.location.href = "index.php?page='.$page.'&recherche='.$_GET['recherche'].'&no_page="+no_page';
            }else{
                echo 'window.location.href = "index.php?page='.$page.'&no_page="+no_page';
            };
        echo '}
    </script>';
}
