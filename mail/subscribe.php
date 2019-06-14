<?php

use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>"/>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style type="text/css">
        p {
            margin: 10px 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }

        h1, h2, h3, h4, h5, h6 {
            display: block;
            margin: 0;
            padding: 0;
        }

        img, a img {
            border: 0;
            height: auto;
            outline: none;
            text-decoration: none;
        }

        body, #bodyTable, #bodyCell {
            height: 100%;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .mcnPreviewText {
            display: none !important;
        }

        #outlook a {
            padding: 0;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        table {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        p, a, li, td, blockquote {
            mso-line-height-rule: exactly;
        }

        a[href^=tel], a[href^=sms] {
            color: inherit;
            cursor: default;
            text-decoration: none;
        }

        p, a, li, td, body, table, blockquote {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        .ExternalClass, .ExternalClass p, .ExternalClass td, .ExternalClass div, .ExternalClass span, .ExternalClass font {
            line-height: 100%;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        #bodyCell {
            padding: 10px;
            border-top: 0;
        }

        .templateContainer {
            max-width: 600px !important;
            border: 0;
        }

        a.mcnButton {
            display: block;
        }

        .mcnImage, .mcnRetinaImage {
            vertical-align: bottom;
        }

        .mcnTextContent {
            word-break: break-word;
        }

        .mcnTextContent img {
            height: auto !important;
        }

        .mcnDividerBlock {
            table-layout: fixed !important;
        }

        /*
        @tab Page
        @section Background Style
        @tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
        */
        body, #bodyTable {
            /*@editable*/
            background-color: #f5ecec;
        }

        /*
        @tab Page
        @section Background Style
        @tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
        */
        #bodyCell {
            /*@editable*/
            border-top: 0;
        }

        /*
        @tab Page
        @section Email Border
        @tip Set the border for your email.
        */
        .templateContainer {
            /*@editable*/
            border: 0;
        }

        /*
        @tab Page
        @section Heading 1
        @tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
        @style heading 1
        */
        h1 {
            /*@editable*/
            color: #202020;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 26px;
            /*@editable*/
            font-style: normal;
            /*@editable*/
            font-weight: bold;
            /*@editable*/
            line-height: 125%;
            /*@editable*/
            letter-spacing: normal;
            /*@editable*/
            text-align: left;
        }

        /*
        @tab Page
        @section Heading 2
        @tip Set the styling for all second-level headings in your emails.
        @style heading 2
        */
        h2 {
            /*@editable*/
            color: #202020;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 22px;
            /*@editable*/
            font-style: normal;
            /*@editable*/
            font-weight: bold;
            /*@editable*/
            line-height: 125%;
            /*@editable*/
            letter-spacing: normal;
            /*@editable*/
            text-align: left;
        }

        /*
        @tab Page
        @section Heading 3
        @tip Set the styling for all third-level headings in your emails.
        @style heading 3
        */
        h3 {
            /*@editable*/
            color: #202020;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 20px;
            /*@editable*/
            font-style: normal;
            /*@editable*/
            font-weight: bold;
            /*@editable*/
            line-height: 125%;
            /*@editable*/
            letter-spacing: normal;
            /*@editable*/
            text-align: left;
        }

        /*
        @tab Page
        @section Heading 4
        @tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
        @style heading 4
        */
        h4 {
            /*@editable*/
            color: #202020;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 18px;
            /*@editable*/
            font-style: normal;
            /*@editable*/
            font-weight: bold;
            /*@editable*/
            line-height: 125%;
            /*@editable*/
            letter-spacing: normal;
            /*@editable*/
            text-align: left;
        }

        /*
        @tab Preheader
        @section Preheader Style
        @tip Set the background color and borders for your email's preheader area.
        */
        #templatePreheader {
            /*@editable*/
            background-color: #f5ecec;
            /*@editable*/
            background-image: none;
            /*@editable*/
            background-repeat: no-repeat;
            /*@editable*/
            background-position: center;
            /*@editable*/
            background-size: cover;
            /*@editable*/
            border-top: 0;
            /*@editable*/
            border-bottom: 0;
            /*@editable*/
            padding-top: 0px;
            /*@editable*/
            padding-bottom: 0px;
        }

        /*
        @tab Preheader
        @section Preheader Text
        @tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
        */
        #templatePreheader .mcnTextContent, #templatePreheader .mcnTextContent p {
            /*@editable*/
            color: #656565;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 9px;
            /*@editable*/
            line-height: 100%;
            /*@editable*/
            text-align: left;
        }

        /*
        @tab Preheader
        @section Preheader Link
        @tip Set the styling for your email's preheader links. Choose a color that helps them stand out from your text.
        */
        #templatePreheader .mcnTextContent a, #templatePreheader .mcnTextContent p a {
            /*@editable*/
            color: #656565;
            /*@editable*/
            font-weight: normal;
            /*@editable*/
            text-decoration: underline;
        }

        /*
        @tab Header
        @section Header Style
        @tip Set the background color and borders for your email's header area.
        */
        #templateHeader {
            /*@editable*/
            background-color: #f5ecec;
            /*@editable*/
            background-image: none;
            /*@editable*/
            background-repeat: no-repeat;
            /*@editable*/
            background-position: center;
            /*@editable*/
            background-size: cover;
            /*@editable*/
            border-top: 0;
            /*@editable*/
            border-bottom: 0;
            /*@editable*/
            padding-top: 0px;
            /*@editable*/
            padding-bottom: 0;
        }

        /*
        @tab Header
        @section Header Text
        @tip Set the styling for your email's header text. Choose a size and color that is easy to read.
        */
        #templateHeader .mcnTextContent, #templateHeader .mcnTextContent p {
            /*@editable*/
            color: #202020;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 16px;
            /*@editable*/
            line-height: 150%;
            /*@editable*/
            text-align: left;
        }

        /*
        @tab Header
        @section Header Link
        @tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
        */
        #templateHeader .mcnTextContent a, #templateHeader .mcnTextContent p a {
            /*@editable*/
            color: #b3a170;
            /*@editable*/
            font-weight: bold;
            /*@editable*/
            text-decoration: underline;
        }

        /*
        @tab Body
        @section Body Style
        @tip Set the background color and borders for your email's body area.
        */
        #templateBody {
            /*@editable*/
            background-color: #f5ecec;
            /*@editable*/
            background-image: none;
            /*@editable*/
            background-repeat: no-repeat;
            /*@editable*/
            background-position: center;
            /*@editable*/
            background-size: cover;
            /*@editable*/
            border-top: 0;
            /*@editable*/
            border-bottom: 2px none #EAEAEA;
            /*@editable*/
            padding-top: 0;
            /*@editable*/
            padding-bottom: 9px;
        }

        /*
        @tab Body
        @section Body Text
        @tip Set the styling for your email's body text. Choose a size and color that is easy to read.
        */
        #templateBody .mcnTextContent, #templateBody .mcnTextContent p {
            /*@editable*/
            color: #222222;
            /*@editable*/
            font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            /*@editable*/
            font-size: 16px;
            /*@editable*/
            line-height: 100%;
            /*@editable*/
            text-align: left;
        }

        /*
        @tab Body
        @section Body Link
        @tip Set the styling for your email's body links. Choose a color that helps them stand out from your text.
        */
        #templateBody .mcnTextContent a, #templateBody .mcnTextContent p a {
            /*@editable*/
            color: #b3a170;
            /*@editable*/
            font-weight: bold;
            /*@editable*/
            text-decoration: underline;
        }

        /*
        @tab Footer
        @section Footer Style
        @tip Set the background color and borders for your email's footer area.
        */
        #templateFooter {
            /*@editable*/
            background-color: #f5ecec;
            /*@editable*/
            background-image: none;
            /*@editable*/
            background-repeat: no-repeat;
            /*@editable*/
            background-position: center;
            /*@editable*/
            background-size: cover;
            /*@editable*/
            border-top: 1px double #b3a170;
            /*@editable*/
            border-bottom: 1px none;
            /*@editable*/
            padding-top: 0px;
            /*@editable*/
            padding-bottom: 0px;
        }

        /*
        @tab Footer
        @section Footer Text
        @tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
        */
        #templateFooter .mcnTextContent, #templateFooter .mcnTextContent p {
            /*@editable*/
            color: #656565;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 12px;
            /*@editable*/
            line-height: 150%;
            /*@editable*/
            text-align: center;
        }

        /*
        @tab Footer
        @section Footer Link
        @tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
        */
        #templateFooter .mcnTextContent a, #templateFooter .mcnTextContent p a {
            /*@editable*/
            color: #656565;
            /*@editable*/
            font-weight: normal;
            /*@editable*/
            text-decoration: underline;
        }

        @media only screen and (min-width: 768px) {
            .templateContainer {
                width: 600px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            body, table, td, p, a, li, blockquote {
                -webkit-text-size-adjust: none !important;
            }

        }

        @media only screen and (max-width: 480px) {
            body {
                width: 100% !important;
                min-width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            #bodyCell {
                padding-top: 10px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnRetinaImage {
                max-width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImage {
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnCartContainer, .mcnCaptionTopContent, .mcnRecContentContainer, .mcnCaptionBottomContent, .mcnTextContentContainer, .mcnBoxedTextContentContainer, .mcnImageGroupContentContainer, .mcnCaptionLeftTextContentContainer, .mcnCaptionRightTextContentContainer, .mcnCaptionLeftImageContentContainer, .mcnCaptionRightImageContentContainer, .mcnImageCardLeftTextContentContainer, .mcnImageCardRightTextContentContainer, .mcnImageCardLeftImageContentContainer, .mcnImageCardRightImageContentContainer {
                max-width: 100% !important;
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnBoxedTextContentContainer {
                min-width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupContent {
                padding: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnCaptionLeftContentOuter .mcnTextContent, .mcnCaptionRightContentOuter .mcnTextContent {
                padding-top: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardTopImageContent, .mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent, .mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent {
                padding-top: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardBottomImageContent {
                padding-bottom: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupBlockInner {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupBlockOuter {
                padding-top: 9px !important;
                padding-bottom: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnTextContent, .mcnBoxedTextContentColumn {
                padding-right: 18px !important;
                padding-left: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardLeftImageContent, .mcnImageCardRightImageContent {
                padding-right: 18px !important;
                padding-bottom: 0 !important;
                padding-left: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcpreview-image-uploader {
                display: none !important;
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Heading 1
            @tip Make the first-level headings larger in size for better readability on small screens.
            */
            h1 {
                /*@editable*/
                font-size: 22px !important;
                /*@editable*/
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Heading 2
            @tip Make the second-level headings larger in size for better readability on small screens.
            */
            h2 {
                /*@editable*/
                font-size: 20px !important;
                /*@editable*/
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Heading 3
            @tip Make the third-level headings larger in size for better readability on small screens.
            */
            h3 {
                /*@editable*/
                font-size: 18px !important;
                /*@editable*/
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Heading 4
            @tip Make the fourth-level headings larger in size for better readability on small screens.
            */
            h4 {
                /*@editable*/
                font-size: 16px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Boxed Text
            @tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
            */
            .mcnBoxedTextContentContainer .mcnTextContent, .mcnBoxedTextContentContainer .mcnTextContent p {
                /*@editable*/
                font-size: 14px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Preheader Visibility
            @tip Set the visibility of the email's preheader on small screens. You can hide it to save space.
            */
            #templatePreheader {
                /*@editable*/
                display: block !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Preheader Text
            @tip Make the preheader text larger in size for better readability on small screens.
            */
            #templatePreheader .mcnTextContent, #templatePreheader .mcnTextContent p {
                /*@editable*/
                font-size: 14px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Header Text
            @tip Make the header text larger in size for better readability on small screens.
            */
            #templateHeader .mcnTextContent, #templateHeader .mcnTextContent p {
                /*@editable*/
                font-size: 16px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Body Text
            @tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
            */
            #templateBody .mcnTextContent, #templateBody .mcnTextContent p {
                /*@editable*/
                font-size: 16px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
            @section Footer Text
            @tip Make the footer content text larger in size for better readability on small screens.
            */
            #templateFooter .mcnTextContent, #templateFooter .mcnTextContent p {
                /*@editable*/
                font-size: 14px !important;
                /*@editable*/
                line-height: 150% !important;
            }

        }</style>
</head>
</head>
<body>
<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
        <tr>
            <td align="center" valign="top" id="bodyCell">
                <!-- BEGIN TEMPLATE // -->
                <!--[if (gte mso 9)|(IE)]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                    <tr>
                        <td align="center" valign="top" width="600" style="width:600px;">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                    <tr>
                        <td valign="top" id="templatePreheader">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock"
                                   style="min-width:100%;">
                                <tbody class="mcnImageBlockOuter">
                                <tr>
                                    <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                                        <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0"
                                               class="mcnImageContentContainer" style="min-width:100%;">
                                            <tbody>
                                            <tr>
                                                <td class="mcnImageContent" valign="top"
                                                    style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">


                                                    <img align="center" alt=""
                                                         src="https://gallery.mailchimp.com/2be5c038a54cea7ac6bf81487/images/5372f64d-175f-4229-8446-d4b520e2659d.png"
                                                         width="564"
                                                         style="max-width: 600px; padding-bottom: 0px; vertical-align: bottom; display: inline !important; border-radius: 0%;"
                                                         class="mcnImage">


                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock"
                                   style="min-width:100%;">
                                <tbody class="mcnDividerBlockOuter">
                                <tr>
                                    <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 16px 18px;">
                                        <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0"
                                               width="100%" style="min-width: 100%;border-top: 1px solid #B3A170;">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <span></span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!--
                                                        <td class="mcnDividerBlockInner" style="padding: 18px;">
                                                        <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
                                        -->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" id="templateHeader">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock"
                                   style="min-width:100%;">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                        <!--[if mso]>
                                        <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%"
                                               style="width:100%;">
                                            <tr>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td valign="top" width="600" style="width:600px;">
                                        <![endif]-->
                                        <table align="left" border="0" cellpadding="0" cellspacing="0"
                                               style="max-width:100%; min-width:100%;" width="100%"
                                               class="mcnTextContentContainer">
                                            <tbody>
                                            <tr>

                                                <td valign="top" class="mcnTextContent"
                                                    style="padding: 0px 18px 9px; line-height: 100%;">

                                                    <div style="text-align: center;"><br>

                                                        <br>
                                                        <br>
                                                        <span style="font-size:14px"><span
                                                                    style="font-family:arial,helvetica neue,helvetica,sans-serif">Благодарим Вас за&nbsp;подписку на нашу рассылку.<br>
Для подтверждения адреса Вашей электронной почты, пожалуйста,<br>
перейдите по ссылке:<br>
<br>
<strong><span style="color:#b3a170"><?= $content ?></span></strong><br>
<br>
<br>
Оставайтесь с нами, впереди Вас ждет много интересного!<br>
&nbsp;<br>
Команда <strong><a href="http://beicon.ru" target="_blank">beicon.ru</a></strong></span></span><br>
                                                        <br>
                                                        <br>
                                                        &nbsp;
                                                    </div>

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        </tr>
                                        </table>
                                        <![endif]-->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" id="templateBody">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock"
                                   style="min-width:100%;">
                                <tbody class="mcnFollowBlockOuter">
                                <tr>
                                    <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                               class="mcnFollowContentContainer" style="min-width:100%;">
                                            <tbody>
                                            <tr>
                                                <td align="center" style="padding-left:9px;padding-right:9px;">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                           style="min-width: 100%;background-color: #B3A170;border: 1px none;"
                                                           class="mcnFollowContent">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" valign="top"
                                                                style="padding-top:9px; padding-right:9px; padding-left:9px;">
                                                                <table align="center" border="0" cellpadding="0"
                                                                       cellspacing="0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top">
                                                                            <!--[if mso]>
                                                                            <table align="center" border="0"
                                                                                   cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                            <![endif]-->

                                                                            <!--[if mso]>
                                                                            <td align="center" valign="top">
                                                                            <![endif]-->

                                                                            <table align="left" border="0"
                                                                                   cellpadding="0" cellspacing="0"
                                                                                   class="mcnFollowStacked"
                                                                                   style="display:inline;">

                                                                                <tbody>
                                                                                <tr>
                                                                                    <td align="center" valign="top"
                                                                                        class="mcnFollowIconContent"
                                                                                        style="padding-right:10px; padding-bottom:9px;">
                                                                                        <a href="https://www.instagram.com/beicon.ru"
                                                                                           target="_blank"><img
                                                                                                    src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-instagram-96.png"
                                                                                                    alt="Instagram"
                                                                                                    class="mcnFollowBlockIcon"
                                                                                                    width="48"
                                                                                                    style="width:48px; max-width:48px; display:block;"></a>
                                                                                    </td>
                                                                                </tr>


                                                                                </tbody>
                                                                            </table>


                                                                            <!--[if mso]>
                                                                            </td>
                                                                            <![endif]-->

                                                                            <!--[if mso]>
                                                                            <td align="center" valign="top">
                                                                            <![endif]-->

                                                                            <table align="left" border="0"
                                                                                   cellpadding="0" cellspacing="0"
                                                                                   class="mcnFollowStacked"
                                                                                   style="display:inline;">

                                                                                <tbody>
                                                                                <tr>
                                                                                    <td align="center" valign="top"
                                                                                        class="mcnFollowIconContent"
                                                                                        style="padding-right:0; padding-bottom:9px;">
                                                                                        <a href="http://www.facebook.com/beicon.ru"
                                                                                           target="_blank"><img
                                                                                                    src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-facebook-96.png"
                                                                                                    alt="Facebook"
                                                                                                    class="mcnFollowBlockIcon"
                                                                                                    width="48"
                                                                                                    style="width:48px; max-width:48px; display:block;"></a>
                                                                                    </td>
                                                                                </tr>


                                                                                </tbody>
                                                                            </table>


                                                                            <!--[if mso]>
                                                                            </td>
                                                                            <![endif]-->

                                                                            <!--[if mso]>
                                                                            </tr>
                                                                            </table>
                                                                            <![endif]-->
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" id="templateFooter">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock"
                                   style="min-width:100%;">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                        <!--[if mso]>
                                        <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%"
                                               style="width:100%;">
                                            <tr>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td valign="top" width="600" style="width:600px;">
                                        <![endif]-->
                                        <table align="left" border="0" cellpadding="0" cellspacing="0"
                                               style="max-width:100%; min-width:100%;" width="100%"
                                               class="mcnTextContentContainer">
                                            <tbody>
                                            <tr>

                                                <td valign="top" class="mcnTextContent"
                                                    style="padding: 0px 18px 9px; line-height: 125%;">

                                                    <span style="font-family:arial,helvetica neue,helvetica,sans-serif"><span
                                                                style="color:#B3A170"><span style="font-size:14px"><em>Copyright © 2019 Beicon.ru</em></span></span></span><br>
                                                    <br>
                                                    <em><a href="https://gallery.mailchimp.com/2be5c038a54cea7ac6bf81487/images/9709231c-09fd-409e-b915-85b989a71a7d.png"><img
                                                                    data-file-id="3292361" height="37"
                                                                    src="https://gallery.mailchimp.com/2be5c038a54cea7ac6bf81487/images/9709231c-09fd-409e-b915-85b989a71a7d.png"
                                                                    style="border: 0px  ; width: 110px; height: 37px; margin: 0px;"
                                                                    width="110"></a></em>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        </tr>
                                        </table>
                                        <![endif]-->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <!--[if (gte mso 9)|(IE)]>
                </td>
                </tr>
                </table>
                <![endif]-->
                <!-- // END TEMPLATE -->
            </td>
        </tr>
    </table>
</center>

</body>
</html>