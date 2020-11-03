<?php
    if ($result-> num_rows > 0) {
        while($row = $result -> fetch_assoc()){
            echo '<td><img class="foodIcon" src="Images/'.$row["meal_pic"]' alt=""><br>' .$row["meal_name"]'</td>';
        }
    }
?>


<table>
    <tbody>
        <tr>
            <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Sunday"; ?>
            <input type="hidden" id= "1" name="1" value=""/></td>
            <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Monday"; ?>
            <input type="hidden" id="2" name="2" value=""/></td>
            <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Tuesday"; ?>
            <input type="hidden" id="3" name="3" value=""/></td>
            <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Wednesday"; ?>
            <input type="hidden" id= "4" name="4" value=""/></td>
            <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Thursday"; ?>
            <input type="hidden" id= "5" name="5" value=""/></td>
            <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Friday"; ?>
            <input type="hidden" id= "6" name="6" value=""/></td>
            <td><img class="foodIcon" src="Images/emptyIcon.png" alt=""><br><?php  echo "Saturday"; ?>
            <input type="hidden" id= "7" name="7" value=""/></td> 
            <td><input type="submit" id="list_btn" value="Get List"></td>
        </tr>
    </tbody>
</table>


</tr>
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

<?php
    // class Ingredient {
    //     public $ingredientName;
    //     public $ingredentAmount;

    //     function set_ingredientName($ingredientName) {
    //         $this->ingredientName = $ingredientName;
    //     }
    //     function get_ingredientName(){
    //         return $this->$ingredientName;
    //     }
    // }

    
    //Creating the objects
    $meal1 = new Recipe();
    $meal2 = new Recipe();
    $meal3 = new Recipe();
    $meal4 = new Recipe();
    $meal5 = new Recipe();
    $meal6 = new Recipe();
    $meal7 = new Recipe();


// I was hoping to get this to work with the mock data but it may be easier with the database call
    // function ajax_call(){
    //     cur = document.getElementById('current').value;
    //     _1 = document.getElementById('one').value;
    //     _2 = document.getElementById('two').value;
    //     _3 = document.getElementById('three').value;
    //     _4 = document.getElementById('four').value;
    //     _5 = document.getElementById('five').value;
    //     _6 = document.getElementById('six').value;
    //     _7 = document.getElementById('seven').value;
    //     $.ajax({
    //         type:'post',
    //         data:{current:cur, one:_1,two:_2,three:_3,four:_4, five:_5, six:_6, seven:_7}
    //     });
    //     // location.reload();
    // }
    ?>