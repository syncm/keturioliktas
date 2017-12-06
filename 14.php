<!DOCTYPE html>
<html>
    <head>
        <title>14 Užduotis</title>
        <meta charset="UTF-8">
    </head>
<body>
<?php 
/*Sukurkite su phpMyAdmin bent 15 automobilių greičių įrašų. 
Parašykite programą, kuri išvestų įrašus puslapiais po 10. 
Padarykite, kad būtų du mygtukai “Pirmyn” ir/arba “Atgal” vaikščiojimui per puslapius.*/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "auto";
$datatable = "radars"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Nepavyko prisijungti: " . $conn->connect_error);
} 
$page = 5;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
if ($page != 2) $page = 10;
if (isset($_GET['offset'])) {
    $offset = $_GET['offset'];
} else {
    $offset = 0;
}
$sql = 'SELECT `id`,`number`, `distance`,`time`,`distance`/`time`*3.6 as `speed`, `data` FROM radars ORDER BY `id`, `data` DESC LIMIT ' . ($page + 1) . ' OFFSET ' . $offset;
$result = $conn->query($sql);
if ($result->num_rows > 0) { 
    ?>
    <?php if ($offset > 0): ?>
    <!-- <form>
        <input type="hidden" name="offset" value="<?= $offset >= $page ? $offset - $page : 0 ?>">
        <button>Atgal</button>    
    </form> -->
        <a href="<?= "?offset=".($offset >= $page ? $offset - $page : 0) ?>">Atgal</a>
    <?php endif; ?>

    <?php if ($result->num_rows == $page + 1): ?>
    <!-- <form>
        <input type="hidden" name="offset" value="<?= $offset + $page ?>">
        <button>Pirmyn</button>    
    </form> -->
        <a href="<?= "?offset=".($offset + $page) ?>">Pirmyn</a>
    <?php endif; ?>

    <table border=1>
        <tr>
            <th>Id</th>
            <th>Data ir laikas</th>
            <th>Automobilio numeris</th>
            <th>Atstumas, m</th>
            <th>Laikas, s</th>
            <th>Greitis, Km/h</th>
        </tr>
    
    <?php
    // output data of each row
    //while($row = $result->fetch_assoc()) {
    for ($i = 0; $i < $page; $i++) {
        if (!($row = $result->fetch_assoc())) break;
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['data']; ?></td>
            <td><?php echo ($row['number']); ?></td>
            <td><?php echo ($row['distance']); ?></td>
            <td><?php echo ($row['time']); ?></td>
            <td><?php echo round($row['speed']); ?></td>
        </tr>
        <?php
    }
    echo '</table>';
} else {
    echo 'Nėra duomenų';
}
$conn->close();
?>
</body>
</html>