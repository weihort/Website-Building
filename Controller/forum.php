<?php
namespace Controller;
use Modal\Forum\Forum, \PDO;
include '../Model/Forum.Class.php ';
header('Content-Type:text/html;charset=utf-8');
$tabNum     = 0;
$forum      = new Forum(false);
$selectAttr = array(
    "role" => "reviewSelect",
    "data" => array(
        "fid" => 1,
    )
);
try {
    $forum->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forum->dbObj->beginTransaction();
    $selectResult = $forum->selectDB($selectAttr);
    getContent($forum, $selectAttr, $tabNum);
} catch (Exception $e) {
    $forum->rollBack();
    die("Error!: " . $e->getMessage() . "<br />");
}

function getContent($forum, $selectAttr, $tabNum)
{
    $selectResult = $forum->selectDB($selectAttr);
    $num = $tabNum++;
    if ($selectResult) {
        foreach ($selectResult as $row) {
            foreach ($row as $key => $value) {
                if ($key !== 0) {
                    if ($key == "id") {
                        $selectAttr["data"]["fid"] = $value;
                    }
                    if ($key == "content") {
                        echo "<div style='margin-left:" . $num* 30 ."px;'>" . $value . "</div>";
                    }
                }
            }
            getContent($forum,$selectAttr,$tabNum);
        }
    }
}
 ?>
