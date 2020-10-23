<?php include "header.php"; ?>

<?php 



    $foodName1 = "Banana Break";
    $foodName2 = "Deer Meat Spicy Jerky";
    $foodName3 = "Spagethi";
    $foodName4 = "That One thing I can't think of";
    $foodName5 = "Quick and Easy";
    $foodName6 = "Names are super confusing!";
?>

<main>
    <table id="menu">
        <tbody>
            <tr>
                <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName1; ?></td>
                <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName2; ?></td>
                <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName3; ?></td>
            </tr>
            <tr>
                <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName4; ?></td>
                <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName5; ?></td>
                <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo $foodName6; ?></td>
            </tr>
        </tbody>
    </table>
    <div id="howToMakeBox">
        this should be working!
    </div>
</main>

<?php include "footer.php"; ?>