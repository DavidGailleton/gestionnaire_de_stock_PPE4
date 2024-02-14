<?php

function show_medic_card($labelle, $cis, $description, $stock, $forme)
{
    $in_stock = "";

    if ($stock == true){
        $in_stock = "En Stock";
    } else {
        $in_stock = "Indisponible";
    }


    echo "
       <li> 
            <div>
                <div>
                    $labelle - $cis
                </div>
                <div>$forme</div>
            </div>
            <div>
                <p>
                $description
                </p>
                <div>$in_stock</div>
            </div>
       </li>
    ";
    }

?>