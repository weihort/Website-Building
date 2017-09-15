<?php
namespace Model\Tables;

use \Model\DateBase;
use PDO;

class Viewpoint extends DateBase{

    function __construct($mark)
    {
        $this->arguments = array(           //数据库需外部填入的所有字段
            'aid'      => null,             //文章id
            'uid'      => null,             //用户id
            'agree'    => null,             //赞同
            'oppose'   => null,             //反对
            'favorite' => null,             //收藏
            'report'   => null,             //举报
        );
        $this->goals     = array(           //数据库预处理状态名称
            'viewInsert' => null,                //插入某用户对某文章的观点
            'viewSelect' => null,
        );
        $this->device    = array(           //数据库预处理状态明细
            'viewInsert' => array(         //将注册数据插入temp表
                'mark' => true,
                'sql'  => '
                    INSERT INTO Viewpoint(aid, uid, agree, oppose, favorite, report)
                    VALUES (:aid, :uid, :agree, :oppose, :favorite, :report);
                ',
                'data' => array("aid", "uid", "agree", "oppose", "favorite", "report"),
            ),
            'viewSelect' => array(         //将注册数据插入temp表
                'mark' => true,
                'sql'  => 'SELECT * FROM Viewpoint WHERE aid = :aid AND uid = :uid',
                'data' => array("aid", "uid"),
            ),
        );
        $this->chooseBase($mark);
        $this->connectBase();
        $this->disposeEffect();
    }
}
 ?>
