<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">

    <script src="scripts.js" type="text/javascript"></script>

    <title>Sklep z ubraniami</title>
</head>

<body>
    <header>
        <p id="header1">SKLEP Z UBRANIAMI</p>
        <p id="header2">SKLEP Z UBRANIAMI</p>
    </header>
    <nav>
        <ul id="nav-ul">
            <li class="nav-li"><a class="nav-link" href="index.html">Home</a></li>
            <li class="nav-li"><a class="nav-link" href="items.php">Sklep</a></li>
            <li class="nav-li"><a class="nav-link" href="#">Podstrona</a></li>
            <li style="float: right; margin-right: 2rem; padding: 1rem;">
                <form method="post" action="items.php"><input type="text" placeholder="nazwa ubrania" name="nazwaU">
                    <input type="submit" name="submit" value="Wyszukaj"> </form>
            </li>
        </ul>

    </nav>
    <aside>
        <form method="post" action="items.php" id="find_items">
            <p>
                Podaj nazwę ubrania:
                <input type="text" placeholder="nazwa ubrania" name="nazwaU">
            </p> <br>
            <div style="overflow-x:auto;">
                <details>
                    <summary>Kategoria</summary>
                    <label name="kategoria">
                        <input type="checkbox" name="checkKat[]" id="swetry_kardigany" value="swetry_kardigany">
                        swetry i kardigany <br>
                        <input type="checkbox" name="checkKat[]" id="bluzy" value="bluzy"> bluzy <br>
                        <input type="checkbox" name="checkKat[]" id="odziez_wierzchnia" value="odziez_wierzchnia">
                        odzież wierzchnia <br>
                        <input type="checkbox" name="checkKat[]" id="tshirty" value="tshirty"> tshirty <br>
                        <input type="checkbox" name="checkKat[]" id="bluzki" value="bluzki"> bluzki <br>
                        <input type="checkbox" name="checkKat[]" id="sukienki" value="sukienki"> sukienki <br>
                        <input type="checkbox" name="checkKat[]" id="kombinezony" value="kombinezony">
                        kombinezony dwuczęściowe <br>
                        <input type="checkbox" name="checkKat[]" id="dol_stroju" value="dol_stroju"> dół stroju
                        <br>
                    </label>
                </details>
                <details>
                    <summary>Kolor </summary>
                    <label name="kolor">
                        <input type="checkbox" name="checkKolor[]" id="czarny" value="czarny"> czarny <br>
                        <input type="checkbox" name="checkKolor[]" id="bialy" value="bialy"> biały <br>
                        <input type="checkbox" name="checkKolor[]" id="szary" value="szary"> szary <br>
                        <input type="checkbox" name="checkKolor[]" id="czerwony" value="czerwony"> czerwony <br>
                        <input type="checkbox" name="checkKolor[]" id="pomaranczowy" value="pomaranczowy"> pomarańczowy <br>
                        <input type="checkbox" name="checkKolor[]" id="zolty" value="zolty"> żółty <br>
                        <input type="checkbox" name="checkKolor[]" id="zielony" value="zielony"> zielony <br>
                        <input type="checkbox" name="checkKolor[]" id="blekitny" value="blekitny"> błękitny <br>
                        <input type="checkbox" name="checkKolor[]" id="fioletowy" value="fioletowy"> fioletowy <br>
                        <input type="checkbox" name="checkKolor[]" id="granatowy" value="granatowy"> granatowy <br>
                        <input type="checkbox" name="checkKolor[]" id="brazowy" value="brazowy"> brązowy <br>
                        <input type="checkbox" name="checkKolor[]" id="bezowy" value="bezowy"> beżowy <br>
                        <input type="checkbox" name="checkKolor[]" id="rozowy" value="rozowy"> różowy <br>
                    </label>
                </details>
                <details>
                    <summary>Typ materiału </summary>
                    <label name="material">
                        <input type="checkbox" name="checkMat[]" id="bawelna" value="bawelna"> bawełna <br>
                        <input type="checkbox" name="checkMat[]" id="wiskoza" value="wiskoza"> wiskoza <br>
                        <input type="checkbox" name="checkMat[]" id="dzins" value="dzins"> dżins <br>
                        <input type="checkbox" name="checkMat[]" id="elastan" value="elastan"> elastan <br>
                        <input type="checkbox" name="checkMat[]" id="poliester" value="poliester"> poliester
                        <br>
                        <input type="checkbox" name="checkMat[]" id="mieszane" value="mieszane"> mieszane <br>
                    </label>
                </details>

            </div> <br>
            <label name="sortuj">
                <input type="radio" name="sortowanie" id="odniskiej" value="ASC"> Od ceny najniższej do najwyższej <br>
                <input type="radio" name="sortowanie" id="odwysokiej" value="DESC"> Od ceny najwyższej do najniższej
            </label> <br><br>
            <p id="valueU">
                Cena do: <a id="value">150 zł</a>
                <input type="range" id="cena" name="cena" min="20" max="150" value="150" onchange="showValue()">
            </p>
            <input type="submit" name="submit" value="Wyszukaj" id="submit">
        </form>
    </aside>
    <main id="show-items">
        <?php
        

            $host = 'localhost';
            $user = 'root';
            $password = '';
            $database = 'sklep';
            $conn = mysqli_connect($host, $user, $password, $database);

            //sortowanie po cenie
            if(isset($_POST["cena"]))
            {
                $cena = "<=" . $_POST["cena"];
            }
            else
            {
                $cena = "IS NOT NULL";
            }
            
            //sortowanie po kategorii ubrania
            if(!empty($_POST['checkKat']))
            {
                $typT = "IN(";
                foreach($_POST['checkKat'] as $typ)
                {
                    $typT .= "'" . $typ . "'" . ",";
                }
                $typT = substr($typT, 0, -1);
                $typT .= ")";
            } 
            else 
            {
                $typT = "IS NOT NULL";
            }
            
            //sortowanie po kolorze
            if(!empty($_POST['checkKolor']))
            {
                $kolorK = "IN(";
                foreach($_POST['checkKolor'] as $kolor)
                {
                    $kolorK .= "'" . $kolor . "'" . ",";
                }
                $kolorK = substr($kolorK, 0, -1);
                $kolorK .= ")";
            } 
            else 
            {
                $kolorK = "IS NOT NULL";
            }

            //sortowanie po materiale
            if(!empty($_POST['checkMat']))
            {
                $materialM = "IN(";
                foreach($_POST['checkMat'] as $material)
                {
                    $materialM .= "'" . $material . "'" . ",";
                }
                $materialM = substr($materialM, 0, -1);
                $materialM .= ")";
            } 
            else 
            {
                $materialM = "IS NOT NULL";
            }

            //Wyszukiwanie po wpisanym słowie
            if(isset($_POST["nazwaU"])){
                $nazwa = $_POST["nazwaU"];
                $nazwaU = " LIKE '%" . $nazwa . "%'"; }
            else{
                $nazwaU = "IS NOT NULL";
            }

            //sortowanie wyników
            if(isset($_POST["sortowanie"])){
                $sortujU = $_POST["sortowanie"]; }
            else{
                $sortujU = "ASC";
            }
            
            $zapytanie = "SELECT ubrania.nazwaU, ubrania.cenaU, ubrania.zdjecieU, kolorubran.kolorK, materialubran.materialM, typubran.typT FROM ubrania 
            INNER JOIN kolorubran ON kolorubran.idK = ubrania.kolorU 
            INNER JOIN materialubran ON materialubran.idM = ubrania.materialU 
            INNER JOIN typubran ON typubran.idT = ubrania.typU 
            WHERE ubrania.cenaU $cena
            AND ubrania.nazwaU $nazwaU 
            AND kolorubran.kolorK $kolorK 
            AND materialubran.materialM $materialM 
            AND typubran.typT $typT 
            ORDER BY ubrania.cenaU $sortujU;";

            if (mysqli_connect_errno()==0)
            {
                $result = mysqli_query($conn, $zapytanie) or die('Problemy z odczytem danych!<br>');
                $ile = mysqli_num_rows($result);
                
                while($row = mysqli_fetch_assoc($result))
                {   
                    $image_data = $row['zdjecieU'];
                    $encoded_image = base64_encode($image_data);
                    echo '<div class="item_pos">'. "<div class='item-text'><b>" .
                    $row['nazwaU'] . 
                    "</b><br><span style='color: red; font-size:larger;'>cena: " . $row["cenaU"] . "zł </span>". 
                    "<br>" . "kolor: " . $row["kolorK"] . ", materiał: " . $row["materialM"] . "</div><div class='item-pic'>" . 
                    "<img class='zdjecie' src='data:image/jpeg;base64,{$encoded_image}'><img src='images/basket.png' style='display: none;' id='hidden'>" 
                    . "</div></div>";
                }
            }
            else
            {
                mysqli_connect_error();
                exit;
            }
            mysqli_close($conn);
        
        ?>
    </main>
    <footer>
        <p>©Copyright 2021 by Alicja Janeczko. All rights reversed.</p>
    </footer>
</body>

</html>