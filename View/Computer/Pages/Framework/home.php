<?php
namespace View\Computer\Pages\Framework;

session_start();

 ?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <title>New&nbsp;&middot;&nbsp;Liyusky</title>
    <link rel="stylesheet" href="../../css/bootstrap.css" />
    <link rel="stylesheet" href="../../css/general.min.css" />
    <link rel="stylesheet" type="text/css" href="../../css/iconfont.css" />
    <script src="../../javascript/jquery.min.js"></script>
    <script src="../../javascript/bootstrap.js"></script>
    <script type="text/javascript">
        function setRecommend (genre, goalId, callback) {
            if (typeof(Storage) !== "undefined") {
                recommendMessageJson = JSON.parse(localStorage[genre]);
                var recommendMessageStr = "";
                for (var unitRecommendMessage of recommendMessageJson) {
                    if(callback){
                        recommendMessageStr += callback(unitRecommendMessage);
                    }
                }
                jQuery("#" + goalId).append(recommendMessageStr);
            }
        }
    </script>
</head>

<body>

    <!-- start header -->
    <?php include $_SESSION['ROOT_DIRECTORY'] . '/View/Computer/Pages/Framework/header.php'; ?>
    <!-- end header -->

    <!-- start content -->
    <?php
    $page = $_GET['page'];
    switch ($page) {
        case 'new':
            include $_SESSION['ROOT_DIRECTORY'] . '/View/Computer/Pages/Composition/new.php';
            break;
        case 'comic':
            include $_SESSION['ROOT_DIRECTORY'] . '/View/Computer/Pages/Composition/comic.php';
            break;
        case 'skill':
            include $_SESSION['ROOT_DIRECTORY'] . '/View/Computer/Pages/Composition/skill.php';
            break;
        case 'communication':
            include $_SESSION['ROOT_DIRECTORY'] . '/View/Computer/Pages/Composition/communication.php';
            break;
        case 'game':
            include $_SESSION['ROOT_DIRECTORY'] . '/View/Computer/Pages/Composition/game.php';
            break;
        case 'party':
            include $_SESSION['ROOT_DIRECTORY'] . '/View/Computer/Pages/Composition/party.php';
            break;
        default:
            echo "大家井水不犯河水，兄台请绕路！";
            break;
    }
     ?>
    <!-- end content -->

    <!-- start footer -->
    <?php include $_SESSION['ROOT_DIRECTORY'] . '/View/Computer/Pages/Framework/footer.php'; ?>
    <!-- end footer -->

    <script type="text/javascript">
        jQuery("header").ready(function() {
            jQuery("#" + "<?php echo $_GET['page'] ?>" + "-page").addClass("active");
        });

        var view = {};

        function agree (thisDom) {
            lightIcon(
                thisDom,
                "text-red",
                function () {
                    changeState(thisDom.next(), "text-red");
                    changeState(thisDom.nextAll().eq(2), "text-green");
                }
            );
        }

        function oppose (thisDom) {
            lightIcon(
                thisDom,
                "text-red",
                function () {
                    changeState(thisDom.prev(), "text-red");
                    changeState(thisDom.nextAll().eq(1), "text-green");
                }
            );
        }

        function favorite (thisDom) {
            lightIcon(
                thisDom,
                "glyphicon-star text-blue",
                function (iconDom) {
                    iconDom.removeClass("glyphicon-star-empty");
                },
                function (iconDom) {
                    iconDom.addClass("glyphicon-star-empty");
                }
            );
        }

        function report (thisDom) {
            lightIcon(
                thisDom,
                "text-green",
                function () {
                    changeState(thisDom.prevAll().eq(1), "text-red");
                    changeState(thisDom.prevAll().eq(2), "text-red");
                }
            );
        }

        function changeState (dom, colorClass) {
            if (!dom.attr("data-allow")) {
                dom.find("span:eq(0)").removeClass(colorClass);
                dom.find("span:eq(2)").text(function (index, text) {
                    return String(text * 1 - 1);
                });
                dom.attr("data-allow", true);
                setView(dom, "0");
            }
        }

        function lightIcon (dom, colorClass, choose, renounce) {
            var mark     = dom.attr("data-allow");
            var countDom = dom.find("span:eq(2)");
            var iconDom  = dom.find("span:eq(0)");
            iconDom.toggleClass(colorClass);
            if (mark) {
                countDom.text(function (index, text) {
                    return String(text * 1 + 1);
                });
                dom.attr("data-allow", "");
                setView(dom, "1");
                if (choose) choose(iconDom);
            }
            else {
                countDom.text(function (index, text) {
                    return String(text * 1 - 1);
                });
                dom.attr("data-allow", true);
                setView(dom, "0");
                if (renounce) renounce(iconDom);
            }
        }

        function setView (dom, flag) {
            var aid     = dom.parent().attr("data-aid");
            var opinion = dom.attr("data-opinion");
            if (view[aid]) {
                view[aid][opinion]  = flag;
            }
            else {
                var temporaryView = {};
                temporaryView[opinion] = flag;
                view[aid] = temporaryView;
            }
        }

        window.onbeforeunload = function (evnet) {
            jQuery.ajax({
                type: 'POST',
                async: false,
                url: '../../../../Controller/Recommend/takeAdvice.php',
                data: {
                    uid: 0,
                    view: view,
                },
                error: function () {
                    if (typeof(Storage) !== "undefined") {
                        localStorage["<?php echo $_SESSION['ip'] ?>".replaceAll(".", "-")] = JSON.stringify(view);
                    }
                }
            });
        }
    </script>
</body>

</html>
