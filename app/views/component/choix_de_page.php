<?php
function choix_de_page(int $no_page, int $nb_page, string $page):void
{
    echo '<div class="choix_de_page" style="grid-template-columns: '; for($i=0; $i < $nb_page && $i < 11; $i++) echo '1fr '; echo '">';

        if ($no_page != 1 && $nb_page > 9) {
            echo '<button onclick="redirect('.$no_page - 1 .')"><</button>';
        }
        echo '<button onclick="redirect(1)">1</button>';
        if ($nb_page > 1){
            if ($nb_page < 10 || $no_page < 4 || $no_page > $nb_page - 3){
                echo '<button onclick="redirect(2)">2</button>';
            } else {
              echo '<button>...</button>';
            }
        }
        if ($nb_page  > 2) {
            if ($nb_page < 10 || $no_page > $nb_page - 3 || $no_page < 4){
                echo '<button onclick="redirect(3)">3</button>';
            }else{
                echo '<button onclick="redirect('.$no_page - 2 .')">'.$no_page - 2 .'</button>';
            }
        }
        if ($nb_page > 3){
            if ($nb_page < 10 || $no_page > $nb_page - 3 || $no_page < 4){
                echo '<button onclick="redirect(4)">4</button>';
            } else {
                echo '<button onclick="redirect('.$no_page - 1 .')">'. $no_page - 1 .'</button>';
            }
        }
        if ($nb_page > 4){
            if ($nb_page < 10){
                echo '<button onclick="redirect(5)">5</button>';
            } else if ($no_page < 4 || $no_page > $nb_page - 3){
                echo '<button>...</button>';
            } else {
                echo '<button>'. $no_page .'</button>';
            }
        }
        if ($nb_page > 5){
            if ($nb_page < 10){
                echo '<button onclick="redirect(6)">6</button>';
            } else if ($no_page < 4 || $no_page > $nb_page - 3){
                echo '<button onclick="redirect('.$nb_page - 3 .')">'.$nb_page - 3 .'</button>';
            } else {
                echo '<button onclick="redirect('.$no_page + 1 .')">'. $no_page + 1 .'</button>';
            }
        }
        if ($nb_page > 6){
            if ($nb_page < 10){
                echo '<button onclick="redirect(7)">7</button>';
            } else if ($no_page < 4 || $no_page > $nb_page - 3){
                echo '<button onclick="redirect('.$nb_page - 2 .')">'.$nb_page - 2 .'</button>';
            } else {
                echo '<button onclick="redirect('.$no_page + 2 .')">'. $no_page + 2 .'</button>';
            }
        }
        if ($nb_page > 7){
            if ($nb_page < 10){
                echo '<button onclick="redirect(8)">8</button>';
            } else if ($no_page < 4 || $no_page > $nb_page - 3){
                echo '<button onclick="redirect('.$nb_page - 1 .')">'.$nb_page - 1 .'</button>';
            } else {
                echo '<button>...</button>';
            }
        }
        if ($nb_page > 8){
            echo '<button onclick="redirect('.$nb_page.')">'. $nb_page .'</button>';
        }
        if ($nb_page > 9 && $no_page != $nb_page){
            echo '<button onclick="redirect('.$no_page + 1 .')">></button>';
        }
        echo '
    </div>
    <script>
        function redirect (no_page){
            ';
            if (isset($_GET['recherche'])){
                echo 'window.location.href = "'.SERVER_URL.'index.php?page='.$page.'&recherche='.$_GET['recherche'].'&no_page="+no_page';
            }else{
                echo 'window.location.href = "'.SERVER_URL.'index.php?page='.$page.'&no_page="+no_page';
            };
        echo '}
    </script>';
}
