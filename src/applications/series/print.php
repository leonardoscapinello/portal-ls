<?php
require_once("../../properties/index.php");

ob_end_clean();
define("DOMPDF_FONT_HEIGHT_RATIO", 0.75);

$contentsPrint = new ContentsPrint();

$cover = "static/document-cover-portal-ls-compressed.jpg";
$id_account = get_request("id_account");
$filename = get_request("filename");
$hash = get_request("hash");
if ($hash === null || $filename === null) {
    die("Unable to print");
}
$contents = new Contents();
$contentsNotes = new ContentsNotes();

$contents->loadByHash($hash);
$content_edited = $contentsNotes->getContent($contents->getIdContent(), $id_account);
if (notempty($content_edited)) {
    $ctn = $text->base64_decode($content_edited);
    $ctn = utf8_decode($ctn);
} else {
    $ctn = ($contents->getContentHtml());
}
$author = new Accounts($contents->getIdAuthor());
ob_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leve com você: <?= $contents->getTitle() ?></title>
    <style>
        /*
            PAGE SIZE: 794PX VS 1122PX
         */

        @page {
            margin: 0 !important;
        }

        .container, .row {
            padding: 0 !important;
            margin: 0 !important;
        }

        * {
            font-smooth: always;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            padding: 0;
            margin: 0;
            cursor: default;
        }


        .page {
            font-family: 'Gilroy', sans-serif;
            width: 100vw;
            max-width: 794px;
            height: calc(100vh - 10px);
            position: relative;
            margin: 0 auto;
            page-break-after: always;
            background: #FFFFFF;
        }

        .page .header {
            box-sizing: border-box;
            background: #FFFFFF;
            height: 70px;
            display: block;
            overflow: hidden;
        }

        .page .content {
            box-sizing: border-box;
            background: #FFFFFF;
            height: 992px;
            display: block;
            overflow: hidden;
        }


        .page .cover {
            box-sizing: border-box;
            background: black;
            height: 1122px;
            display: block;
            overflow: hidden;
        }

        .page .cover .cover-bottom {
            display: block;
            width: 100%;
            height: 300px;
            position: absolute;
            bottom: 0;
            left: 0;
            box-sizing: border-box;
            text-align: center;
        }

        .page .cover .cover-top {
            display: block;
            width: 100%;
            height: 123px;
            position: absolute;
            top: 210px;
            left: 0;
            box-sizing: border-box;
            text-align: center;
        }

        .page .cover h1 {
            display: block;
            width: 75%;
            position: absolute;
            top: 340px;
            left: 50%;
            transform: translate(-50%, 0);
            box-sizing: border-box;
            text-align: center;
            font-size: 48pt;
        }

        .page .cover .author-name {
            display: block;
            width: 100%;
            height: 40px;
            position: absolute;
            bottom: 20px;
            left: 0;
            box-sizing: border-box;
            text-align: center;
            color: #FFFFFF;
            font-size: 22px;
            z-index: 99;
            text-transform: uppercase;
            letter-spacing: 6px;
            font-weight: 700;
        }

        .page .cover .cover-top img,
        .page .cover .cover-bottom img {
            width: 794px;
        }

        .page .cover h1 {
            font-family: 'Gilroy', sans-serif;
            font-size: 28pt;
            line-height: 35pt;
            font-weight: 700;
            color: #FFFFFF;
        }

        .page .content p {
            font-family: Merriweather, 'Times New Roman', serif;
            display: block;
            font-size: 12pt;
            line-height: 26px;
            padding: 22px 1cm;
            text-align: justify;
        }

        .page .content h1,
        .page .content h2,
        .page .content h3,
        .page .content h4,
        .page .content h5,
        .page .content h6{
            font-family: Merriweather, 'Times New Roman', serif;
            display: block;
            padding: 15px 1cm;
            text-align: justify;
        }

        .page .content h3{
            font-size: 15pt;
            line-height: 35px;
        }

        .footer {
            background: black;
            display: block;
            width: 100%;
            height: 60px;
            position: absolute;
            bottom: 0;
            left: 0;
            box-sizing: border-box;
            text-align: center;
        }

        .left {
            width: 50%;
            display: inline-block;
            text-align: left;
        }

        .left img {
            position: absolute;
            z-index: 999;
        }

        .right {
            width: 50%;
            display: inline-block;
            text-align: right;
            color: #FFFFFF;
            position: relative;
        }

        .right p {
            position: absolute;
            top: 22px;
            right: 60px;
            z-index: 999;
            font-size: 13px;
            font-weight: 700;
        }

        h1 {
            font-size: 44pt !important;
            line-height: 50pt;
            font-weight: 800;
        }

        .user_highlighted.highlight {
            background: yellow;
            color: #000000;
        }

        .user_highlighted.comment {
            background: #93DFB3;
            position: relative;
        }
    </style>
    <?= $static->load("gilroy/Gilroy.ttf") ?>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
</head>
<body>
<div class="page">
    <div class="cover">
        <div class="cover-top">
            <img src="static/ls-series-custom-book-cover-top.jpg">
        </div>
        <h1><?= $contents->getTitle() ?></h1>
        <div class="author-name">
            <?= $author->getFullName() ?>
        </div>
        <div class="cover-bottom">
            <img src="static/ls-series-custom-book-cover-bottom.jpg">
        </div>
    </div>
</div>
<?php
$page = 2;
$paragraphs = $contentsPrint->preparePages($ctn);
for ($i = 0; $i < count($paragraphs); $i++) { ?>
    <div class="page">
        <div class="header"></div>
        <div class="content">
            <?= $paragraphs[$i] ?>
        </div>
        <div class="footer">
            <div class="left">
                <img src="static/ls-series-page-bottom-left.jpg">
            </div>
            <div class="right">
                <p><?= $page ?></p>
            </div>
        </div>
    </div>
    <?php $page++;
} ?>
</body>
</html>
<?php
/*
$html = ob_get_clean();
$html = preg_replace('/>\s+</', "><", $html);

$dompdf = new \Dompdf\Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();


//$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));

//exit(0);
$pdf_gen = $dompdf->output();

if (!file_put_contents(DIRNAME . "../../public/documents/" . $filename . ".pdf", $pdf_gen)) {
    http_response_code(500);
} else {
    http_response_code(200);
}

*/
?>

