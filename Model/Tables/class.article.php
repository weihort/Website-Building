<?php
/**
 * description  article表数据库sql预处理架设，
 * @context PHP 5
 * @version 3.0
 * @author liyusky
 * @datetime 2017-1-12 10:34:58+080
 */

namespace Model\Tables;

use \Model\DateBase;
use PDO;

/**
 * customer表处理类
 * @className DateBase
 * @version 1.0
 * @datetime 2016-11-28T17:40:06+080
 * @author liyusky
 */
class Article extends DateBase
{

    /**
     * [__construct 连接数据库].
     * @method   __construct
     * @param [boolean] $mark [false/调试环境，true/生产环境]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-11-28T17:33:51+080
     */
    public function __construct($Mark)
    {
        $this->arguments = array(                   //数据库需外部填入的所有字段
            'aid'          => null,
            'author'       => null,
            'genre'        => null,
            'title'        => null,
            'description'  => null,
            'content_link' => null,
            'image_link'   => null,
            'agree'        => null,
            'oppose'       => null,
            'favorite'     => null,
            'report'       => null,
        );
        $this->goals     = array(                   //数据库预处理状态名称
            'recommendSelect'       => null,                  //推荐页下查询文章信息
            'recommendInsert'       => null,
            'articleAgreeUpdate'    => null,
            'articleOpposeUpdate'   => null,
            'articleFavoriteUpdate' => null,
            'articleReportUpdate'   => null,
        );
        $this->device    = array(                   //数据库预处理状态明细
            'recommendSelect'       => array(         //登录时查询该用户名是否存在
                'mark' => true,
                'sql'  => 'SELECT * FROM article WHERE genre = :genre ORDER BY aid DESC LIMIT 6',
                'data' => array('genre'),
            ),
            'recommendInsert'       => array(
                'mark' => true,
                'sql'  => '
                    INSERT INTO article(author, genre, title, description, content_link, image_link, agree, hate, favorite, report)
                    values(:author, :genre, :title, :description, :content_link, :image_link, :agree, :hate, :favorite, :report)
                ',
                'data' => array('author', 'genre', 'title', 'description', 'content_link', 'image_link', 'agree', 'hate', 'favorite', 'report'),
            ),
            'articleAgreeUpdate'    => array(
                'mark' => true,
                'sql'  => 'UPDATE article SET agree = agree + 1 WHERE aid = :aid',
                'data' => array('aid'),
            ),
            'articleOpposeUpdate'   => array(
                'mark' => true,
                'sql'  => 'UPDATE article SET oppose = oppose + 1 WHERE aid = :aid',
                'data' => array('aid'),
            ),
            'articleFavoriteUpdate' => array(
                'mark' => true,
                'sql'  => 'UPDATE article SET favorite = favorite + 1 WHERE aid = :aid',
                'data' => array('aid'),
            ),
            'articleReportUpdate'   => array(
                'mark' => true,
                'sql'  => 'UPDATE article SET report = report + 1 WHERE aid = :aid',
                'data' => array('aid'),
            ),

        );
        $this->chooseBase($Mark);                   //选择数据库
        $this->connectBase();                       //连接数据库
        $this->disposeEffect();                     //架设sql预处理语句
    }
}
