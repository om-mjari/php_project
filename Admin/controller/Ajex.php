<?php
$id = $_GET['a'];

$a = mysqli_connect("localhost", "root", "", "div") or die();
$q = "SELECT * FROM student WHERE id LIKE '$id%' OR name LIKE '$id%' OR gmail LIKE '$id%'";
$r = mysqli_query($a, $q);
echo "<table border='5'>";
while ($b = mysqli_fetch_row($r)) {
    echo "<tr><td>$b[0]</td>";
    echo "<td>$b[1]</td>";
    echo "<td>$b[2]</td>";
    
    
    
}

//while ($row = $result->fetch_assoc()) {
//                echo '<div class="product">';
//                echo '<img src="' . $row['image_url'] . '" alt="' . $row['product_name'] . '">';
//                echo '<h2>' . $row['product_name'] . '</h2>';
//                echo '<p>' . $row['description'] . '</p>';
//                echo '<p>₹' . $row['price'] . '</p>';
//                echo '</div>';
//            }
echo "</table>";
?>
