<?php
    $sql = "SELECT * FROM report_data";
    $reportData = Database::sqlQuery($sql); //[['typeID'=>'1','amount'=>23],['typeID'=>'4','amount'=>23],['typeID'=>'5','amount'=>23],['typeID'=>'4','amount'=>134],['typeID'=>'1','amount'=>23],['typeID'=>'1','amount'=>243],['typeID'=>'2','amount'=>123],['typeID'=>'5','amount'=>323],['typeID'=>'3','amount'=>243]];//

    $sql = "SELECT * FROM base_data";
    
    $baseData = Database::sqlQuery($sql); // [['id'=>1,'inicial_amount'=>400, 'name'=>'ככעא'],['id'=>2,'inicial_amount'=>400, 'name'=>'ררא'],['id'=>3,'inicial_amount'=>345, 'name'=>'אטרב'],['id'=>4,'inicial_amount'=>4050, 'name'=>'כרג'],['id'=>5,'inicial_amount'=>1060, 'name'=>'קרראד'],['id'=>6,'inicial_amount'=>740, 'name'=>'קרעה'],['id'=>7,'inicial_amount'=>4050, 'name'=>'כרג'],['id'=>8,'inicial_amount'=>1060, 'name'=>'קקקקקקד'],['id'=>9,'inicial_amount'=>740, 'name'=>'כככככה']];

    $sql = "SELECT * FROM language_data";
    $languageData = Database::sqlQuery($sql);

    $sql = "SELECT * FROM type_language";
    $typeLanguage = Database::sqlQuery($sql);
    
    function setLanguageData($languageData,$typeLanguage,$typeLanguageID){

    if($typeLanguageID == 1){
        echo "<script> ".
                "document.body.dir = 'ltr';".
            "</script>";
    } else {
        echo "<script> ".
                "document.body.dir = 'rtl';".
            "</script>";
    }

    echo '<script>let lanData = []</script>';
    foreach ($typeLanguage as $key => $value) {
        echo '<script>lanData.push({"id":'.$value['id'].',"name":"'.$value['name'].'"});</script>';
    }

    foreach ($languageData as $key => $value) {
        if($value['itemID'] == $typeLanguageID){
            return $value;
        }
    }
}

function getNameByid($data,$id){
    foreach ($data as $key => $value) {
        if($value['id'] == $id){
            return $value['name'];
        }
    }
}

function calcAmount($valBaseData,$dataReport) {
    $tempAmnt = intval($valBaseData['inicial_amount']);
    foreach ($dataReport as $key => $valReport) {
        if($valBaseData['id'] == $valReport['typeID']){
            $tempAmnt -= intval($valReport['amount']);
        }
    }
    return $tempAmnt;
}

function getFinalamount($baseData,$dataReport,$lanData) {
    $txt = '';
    foreach($baseData as $item => $valBaseData){
        
        $txt .= '<div class="div_ini_amnt">' . $valBaseData['name'] . ': ';
        $finalAmount = calcAmount($valBaseData,$dataReport);
        $txt .= $lanData['currency'] . $finalAmount . '<br></div>';
    }
    return $txt;
}

function showList($baseData,$reportData) {
    foreach ($reportData as $key => $value) {
            $name = getNameByid($baseData,$value['typeID']);
            echo "<dt>" . $value['date'] ."</dt><dd> $name: ". $value['amount'] ."</dd>";
    }
}
?>