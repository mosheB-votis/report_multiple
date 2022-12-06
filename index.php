<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Report</title>
        <link rel="stylesheet" href="./css.css"></link>
    </head>
    <body>
        tst git ok

        <?php
            include "database.php";
            include "fun.php";

            // def the language system TODO-M set config by cookies
            $typeLanguageID = 1;

            if (isset($_POST['defLanID'])) {
                $typeLanguageID = $_POST['defLanID'];
                if($typeLanguageID == 1){
                    echo "<script>var defDirMenu = 'direction: rtl; padding-left: 20px; padding-right: 5px;';</script>";
                } else {
                    echo "<script>var defDirMenu = 'direction: ltr; padding-left: 5px; padding-right: 20px;';</script>";
                }
            }

            $lanData = setLanguageData($languageData,$typeLanguage,$typeLanguageID);
        ?>
        <div id="displayCurrentAmount">
            <?php 
                echo getFinalamount($baseData,$reportData,$lanData);
            ?>
        </div>
        <hr>
        <div id="form">
            <form class="formAmount" action="index.php"  method="GET" > <!-- onsubmit="setTimeout(function(){window.location.reload();},10);" -->
                <br>
                <select name="typeID" required>
                    <option value="" selected disabled><?php echo $lanData['select_options'] ?></option>
                    <?php
                        foreach ($baseData as $key => $value) {
                            echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                        }
                    ?>
                </select>
                <br>
                <input type="number" name="amount" placeholder="<?php echo $lanData['amount'] ?>"required>
                <button type="submit" name="submit" value="data" style="width:100px"><?php echo $lanData['send'] ?></button>
            </form>
        </div>
        <!-- TODO-M rename div.. -->
        <div class="dropdown">
            <button onclick="openMenu()" class="dropbtn"><?php echo $lanData['menu_app'] ?></button>
            <div id="myDropdown" class="dropdown-content">
                <p id="menuNewItem" onclick="setNewItem()"><?php echo $lanData['new_item'] ?></p>
                <p ><?php echo $lanData['update_item'] ?></p>
                <p id="menuBtnLan" onClick="setLanguage()"><?php echo $lanData['language'] ?></p>
                <p onClick="resetList()"><?php echo $lanData['clear_list'] ?></p>
            </div>
        </div>
        <div id="displayListData">
            <dl>
            <?php
                showList($baseData,$reportData);
            ?>
            </dl>
        </div>
        <!-- TODO-M rename div.. -->
        <!-- The Modal -->
        <div id="myModal" onclick="closeModal(event)" class="modal backGroundModal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close" onclick="closeByX()">&times;</span>
                <p id="textModal"></p>
            </div>

        </div>
    </body>
    <script src="js.js"></script>
    <script>
        function resetList() {
            let res = confirm('<?php echo $lanData['msg_reset_all'] ?>');
            if(res){
                let url = window.location.href.split('?')[0];
                window.location.href = url + '?resetList=true';
            }
        }
        function setNewItem() {
            let val = document.getElementById('menuNewItem').textContent;
            let txt = "<span>"+val+"</span>";
            txt += '<form class="formModal" action="index.php" method="GET">';
            txt += "<input type='text' name='category' placeholder='<?php echo $lanData['category'] ?>' required>";
            txt += "<input type='number' name='inicialAmount' placeholder='<?php echo $lanData['inicial_amount'] ?>' required>";
            txt += "<button type='submit' name='newItem' value='save'><?php echo $lanData['save_config'] ?></button>";
            txt += '</form>';
            openModal(txt);
        }
    </script>
    <?php
        // get the data & update on DB \\ 
        date_default_timezone_set("Israel");
        $dateInput = date("d-m-Y H:i:s");
        if (isset($_GET['typeID'])) {
            if ($_GET['typeID'] != '' && $_GET['amount'] != '') {
                $typeID = $_GET['typeID'];
                $amount = $_GET['amount'];
                $sql = "INSERT INTO report_data (id, date, typeID, amount) VALUES (null,'$dateInput',$typeID, $amount);";
                Database::sqlCommand($sql);
                echo "<script> window.location.href = window.location.href.split('?')[0]; </script>";
            }
        }

        if (isset($_GET['resetList'])) {
            $sql = "DELETE from report_data";
            $res = Database::sqlCommand($sql);
            echo "<script> window.location.href = window.location.href.split('?')[0]; </script>";
        }

        if (isset($_GET['newItem'])) {
            $category = $_GET['category'];
            $inicialAmount = $_GET['inicialAmount'];
            $sql = "INSERT INTO base_data (id, name, inicial_amount) VALUES (null,'$category',$inicialAmount);";
            $res = Database::sqlCommand($sql);
            echo "<script> window.location.href = window.location.href.split('?')[0]; </script>";
        }
    ?>
</html>