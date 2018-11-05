<-if KNummer = 326651582->

<-else->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>LIEFERSCHEIN </title>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <style type="text/css">
        * {
            padding: 0; margin: 2px 2px 2px 0px; list-style-type: circle; font-size: 1em; font-family: helvetica, verdana, sans-serif; color: #333; letter-spacing: 0.09em;
        }
        ul,li {
            list-style-type:none;
        }
        ul,p {
            font-size: 1.01em; margin: 10px; text-transform: uppercase;
        }
        li { font-size: 0.7em;
        }
        li span {
            font-size: 0.8em;
        }


        /* Hübsch machen */
        ul li {
            width: auto; height: 15px; display: block; background: #ddd;
        }
        ul li span {
            display:block; min-width: 10px; width: auto; height: 14px; margin: 0px 5px 0 0; padding: 0px 5px 1px 5px; float:left;background:#fefefe;
        }
        @media screen {

            body { background: gray;
            }
            #wrapper {
                margin: 10px 0 0 10px; width: 501px; height: 733px; background: #fff; overflow: hidden; padding: 0px;  border: none;
            }
            /* allgemeine Definitionen */
            #top, #middle, #bottom, #verybottom {
                background:transparent;width: 100%; height: auto; border: none; border-left:none; border-right:none; margin-bottom: 2px; float:left;
            }
            .left,.middle,.right {
                overflow: hidden; margin: 0; padding: 0; float:left; display: block; height: 100%
            }
            .left {
                background: transparent;
            }
            .middle {
                background: transparent; border-left: none;
            }
            .right {
                background: transparent; border-left: none;
            }

            /* TOP */
            #top .left { /* Logo */
                width: 250px; height: 50px;
            }
            #top .right   { /* Datum */
                width: 250px; height: 70px;
            }
            /* MIDDLE */
            #middle .left { /* Produkt-Bild */
                width: 250px;  height: 170px;
            }
            #middle .right { /* Produkt -Daten */
                width: 250px; height: 170px;
            }
            /* BOTTOM */
            #bottom .left { /* Notizen */
                width: 250px; height: 200px;
            }
            #bottom .right { /*  */
                width: 250px; height: 300px;
            }
            /* VERY BOTTOM */
            #verybottom .left {
                width: 370px; height: 210px;
            }
            #verybottom .right {
                width: 125px; height: 210px;
            }
            /* Inhalt */
            #top .left #logo {
                margin:  5px 0 0 10px;  width: 40px; height: 40px; float:left;
            }
            #top .left #logo img {
                width: 45px; height: 45px;
            }

            #top .left #companyName {
                margin:  25px 0 0 10px;  float:left;
            }
            #top .left #companyColor {
                margin:  22px 0 0 10px; width: 45px;height: 25px;background: transparent;float:left;
            }

            #top .right ul.date {
                margin: 10px 9px 10px 10px;float: right;
            }
            #top .right ul.date li {
                width: auto; height: 12px; display: block; background: transparent;

            }
            #top .right ul.date li span {
                display:block; min-width: 10px; width: 107px; height: 12px; margin: 0px 5px 0 0; float:left; background: #ddd;
            }
            #middle .left ul.adress {
                background: none; min-width: 200px; width: auto; letter-spacing: 0.04em;  text-transform: none;
            }
            #middle .left ul.adress li {
                padding:3px 2px 1px 5px; margin: 3px 2px 0 4px; font-size: 0.9em;
            }
            #middle .left ul.adress li span {
                padding:3px 2px 1px 5px;  margin: 3px 2px 0 4px;
            }
            #middle .right ul.invoiceDetails {
                background: none; min-width: 200px; width: auto; font-size: 0.9em; letter-spacing: 0.04em; text-transform: normal;
            }
            #middle .right ul.invoiceDetails li {
                padding:3px 2px 1px 5px;  margin: 3px 2px 0 4px;font-size: 0.9em;
            }
            #middle .right ul.invoiceDetails li span{
                margin: -3px 0 0 -5px; padding: 5px 4px 0px 4px; width: 25px;
            }
            #bottom .left #productPicture {
                margin: 0px 10px 10px 10px; width: 280px; height: 200px; background: #fff; overflow: hidden;
            }
            #bottom .left #productPicture  img {
                width: 190px;
                height: auto;
            }
            #bottom .right ul.articleDetails {
                margin: 20px 0 20px -10px; background: none; min-width: 200px;  width: auto; letter-spacing: 0.04em; text-transform: normal; font-size: 1.2em;
            }
            #bottom .right ul.articleDetails li.empty {
                height: 2px;  margin: 2px 0 2px 0; padding: 0;  border-bottom: none;
            }
            #bottom .right ul.articleDetails li {
                padding:3px 2px 1px 5px;  margin: 3px 2px 0 4px; background: none; border-bottom: 1px solid gray;
            }
            #bottom .right ul.articleDetails li span{
                margin-top: -3px;  padding: 5px 4px 0px 4px;  width: 70px; background: transparent; border-right: 1px solid gray;
            }
            #verybottom .left ul.ringSize {
                margin: 20px 0 0 20px; float:left; position: relative;
            }
            #verybottom .left ul.ringSize li {
                text-transform: none; background: transparent; border-bottom: 1px solid gray;  margin-top: 5px;
            }
            #verybottom .left ul.ringSize li span {
                display: block; height: 12px; padding-top: 2px; border-right: 1px solid gray; text-transform: uppercase; width: 60px;
            }
            #verybottom .left ul.ringSize li.empty {  border:none; margin:0;
            }
            #qrcode {
                width: 50px; height: 50px; float:left; font-family: arial;
            }

        }
        @media print{

            body { background: gray;
                overflow: hidden;
            }
            #wrapper {
                margin: 10px 0 0 10px; width: 501px; height: 723px; background: #fff; overflow: hidden; padding: 0px;  border: none;
            }
            /* allgemeine Definitionen */
            #top, #middle, #bottom, #verybottom {
                width: 100%; height: auto; border: none; border-left:none; border-right:none; margin-bottom: 2px; float:left;
            }
            .left,.middle,.right {
                overflow: hidden; margin: 0; padding: 0; float:left; display: block; height: 100%
            }
            .left {
                background: transparent;
            }
            .middle {
                background: transparent; border-left: none;
            }
            .right {
                background: transparent; border-left: none;
            }

            /* TOP */
            #top .left { /* Logo */
                width: 250px; height: 50px;
            }
            #top .right   { /* Datum */
                width: 250px; height: 80px;
            }
            /* MIDDLE */
            #middle .left { /* Produkt-Bild */
                width: 250px;  height: 170px;
            }
            #middle .right { /* Produkt -Daten */
                width: 250px; height: 170px;
            }
            /* BOTTOM */
            #bottom .left { /* Notizen */
                width: 250px; height: 250px;
            }
            #bottom .right { /*  */
                width: 250px; height: 390px;
            }

            /* VERY BOTTOM */
            #verybottom .left {
                width: 370px; height: 210px;
            }
            #verybottom .right {
                width: 125px; height: 210px;
            }
            /* Inhalt */
            #top .left #logo {
                margin:  5px 0 0 10px;  width: 40px; height: 40px; float:left;
            }
            #top .left #logo img {
                width: 45px; height: 45px;
            }

            #top .left #companyName {
                margin:  25px 0 0 10px;  float:left;
            }
            #top .left #companyColor {
                margin:  22px 0 0 10px; width: 45px;height: 25px;background: blue;float:left;
            }

            #top .right ul.date {
                margin: 10px 9px 10px 5px;float: right;
            }
            #top .right ul.date li {
                width: auto; height: 15px; display: block; background: transparent;

            }
            #top .right ul.date li span {
                display:block; min-width: 10px; width: 99px; height: 15px; margin: 0px 5px 0 0; float:left; background: #ddd;
            }
            #middle .left ul.adress {
                background: none; min-width: 200px; width: auto; letter-spacing: 0.04em;  text-transform: none;
            }
            #middle .left ul.adress li {
                padding:3px 2px 1px 5px; margin: 3px 2px 0 4px; font-size: 0.9em;
            }
            #middle .left ul.adress li span {
                padding:3px 2px 1px 5px;  margin: 3px 2px 0 4px;
            }
            #middle .right ul.invoiceDetails {
                background: none; min-width: 200px; width: auto; font-size: 0.9em; letter-spacing: 0.04em; text-transform: normal;
            }
            #middle .right ul.invoiceDetails li {
                padding:3px 2px 1px 5px;  margin: 3px 2px 0 4px;font-size: 0.9em;
            }
            #middle .right ul.invoiceDetails li span{
                margin: -3px 0 0 -5px; padding: 5px 4px 0px 4px; width: 25px;
            }
            #bottom .left #productPicture {
                margin: 0px 10px 10px 10px; width: 250px; height: 200px; background: #fff; overflow: hidden;
            }
            #bottom .left #productPicture  img {
                width: 190px;
                height: auto;
            }
            #bottom .right ul.articleDetails {
                margin: 100px 0 0 -10px; background: none; min-width: 200px;  width: auto; letter-spacing: 0.04em; text-transform: normal; font-size: 1.2em;
            }
            #bottom .right ul.articleDetails li.empty {
                height: 2px;  margin: 2px 0 2px 0; padding: 0;  border-bottom: none;
            }
            #bottom .right ul.articleDetails li {
                padding:3px 2px 1px 5px;  margin: 3px 2px 0 4px;  border-bottom: 1px solid gray;
            }
            #bottom .right ul.articleDetails li span{
                margin-top: -3px;  padding: 5px 4px 0px 4px;  width: 70px; background: transparent; border-right: 1px solid gray;
            }
            #verybottom .left ul.ringSize {
                margin: 20px 0 0 20px; float:left; position: relative;
            }
            #verybottom .left ul.ringSize li {
                text-transform: none; background: transparent; border-bottom: 1px solid gray;  margin-top: 5px;
            }
            #verybottom .left ul.ringSize li span {
                display: block; height: 12px; padding-top: 2px; border-right: 1px solid gray; text-transform: uppercase; width: 60px;
            }
            #verybottom .left ul.ringSize li.empty {  border:none; margin:0;
            }
            #qrcode {
                width: 50px; height: 50px; float:left; font-family: arial;
            }
            .adress li, .invoiceDetails {
                background: #ddd !important;

            }
        }
        .tableMoreArticles * { font-size: 11px; font-family: Arial; letter-spacing: 1; }
        <-if <-KNummer-> = 326651582->
                                      .adress li, .invoiceDetails li {
                                          background: #fff !important;
                                      }
        .attr {
            display:none;
        }
        #articleBoxNew ol li {
            padding: 5px 0;
            font-size: 11px;
        }
        <-end if->
    </style>
    <script>
        <-if <-KNummer-> = 326651582->
            $(document).ready(function() {
                $('*').dblclick(function() {
                    $('body').attr("contenteditable", "true");
                    $('ul').each(function() {
                        $(this).css("border", "1px solid") ;
                    });
                });

                var attr = String($('li.attr').html()).split("<br>");
                console.log(attr);

            });
        $(document).keyup(function(e) {
            if (e.keyCode == 27) { // escape key maps to keycode `27`
                $('body').removeAttr("contenteditable");
                $('ul').each(function() {
                    $(this).css("border", "none") ;
                });
            }
        });
        <-end if->
    </script>

</head>
<body>
<-if <-KNummer-> = 326651582->

<div id="wrapper" class="wrapper<-OrderID->">
    <!-- top begin -->
    <div id="top">
        <div class="left">
            <!-- Logo -->
            <div id="logo">
                <img  alt="ewigetrauringe-logo" src="http://www.ewigetrauringe.de/g12.png"/>
            </div>
            <div id="companyName">ewigetrauringe</div>
            <div id="companyColor"></div>
        </div>
        <div class="right">
            <!-- Datum -->
            <ul class="date" style="margin-left:10px;">
                <li style="border-bottom: 1px solid gray; font-size: .8em;"><span style="background:none;">Druck:</span><-Datum-></li>
                <li style="border-bottom: 1px solid gray; color: red; font-size:.8em;font-weight:bold;"><span style="background:none;"> Bestellung:</span><-EndeDerAuktionShort-></li>
                <-if <-Zahlart-> <> Nachnahme ->  <li style="border-bottom: 1px solid gray; font-size:.8em; word-break: break-all;"><span style="background:none;"> Bezahlt am:</span><-Bezahlt-></li> <- end if ->
                <li style="font-size:.8em; word-break: break-all;"><span style="background:none;"> Feedback am:</span><-Feedback-></li>
            </ul>
        </div>
    </div>
    <!-- top end -->
    <!-- middle begin -->
    <div id="middle">
        <div class="left">
            <ul class="adress">
                <li><-KLFIRMA-></li> <!-- Firma -->
                <li><-KLNachname->,<-KLVorname-></li> <!-- Name, Vorname -->
                <li><-KLStrasse-><-KLAnschrift2-></li> <!-- Strasse -->
                <li><-KLPLZ-> <-KLOrt-></li> <!-- PLZ / ORT -->
                <li><-KLLandPost-></li> <!-- Land -->
                <li><-KTELEFON-></li> <!-- Telefon -->
            </ul>
        </div>
        <div class="right">
            <ul>
                <li style="background:none;"><span>Rechnungsdaten:</span></li>
            </ul>
            <ul class="invoiceDetails" style="font-size: 1.10em !important;">
                <li style="font-weight:bold !important; color:red; "><span style="font-weight:bold !important; color:red;">RNR</span><-ReNr-></li> <!-- RechnungsNummer -->
                <li><span>KNR</span><-KNummer-></li> <!--Art -->
                <li><span>ANR</span><-Artikelnummer-></li> <!-- ArtikelNummer -->
                <li style="font-size: 0.6em !important;"><span style="font-size: 1.1em;padding-top: 2px; height: 18px;">ANM</span>
                    <-if <-Artikelnummer-> <> 99999996 -><-if <-Artikelnummer-> <> 99999995 -><-Freifeld8-><- end if -><- end if -> </li> <!-- MODELL -->
                <li><span>EUR</span><-Summe-></li> <!-- Betrag  -->
                <li style="font-size: 0.6em !important;"><nobr><span style="font-size: 1.1em;padding-top: 2px; height: 18px;">ART</span><-if <-Zahlart-> = Nachnahme -><b style="font-size: 1.4em;color: red; margin-top: -2px; display: inline-block; border: 1px solid red;"><img src="https://www.traumtrauringe.de/arrow_nn.png" style="margin:2px;padding:0;height: 10px;" alt="Nachnahme" /></b><- else -><-Zahlart-><- end if -></nobr></li> <!-- Betrag  -->
            </ul>
        </div>
    </div>
    <!-- middle end -->
    <!-- bottom begin -->
    <-if <-ArtikelAnz-> >1 ->
    <div id="bottom">
        <div class="left" style="display: none !important;"></div>
        <div class="right" style="display: none !important;">
            <div style="" id="articleBoxNew"><ol><li class="prof"><label>Profil: </label> <span style="position: relative; top: 5px; z-index: 999; font-size: 16px; font-weight: bold; ">P3</span></li><li class="profpic" style="position: relative; top: -70px; margin-bottom: -77px;"><div style="width: 167px; height: 90px; display: block; margin-left: 80px;"><img src="https://www.traumtrauringe.de/ab_profil_5.png" alt=""></div></li><li class="mat"><label style="width: 70px; margin-top: 0;">MATERIAL: </label> <strong style="color: red;">750er Weissgold<br></strong></li><li class="damen"><label>DAMENRING: </label><span><i>Größe:</i> <span> 53mm (Ø 16,8mm)</span></span><br><span><i>Breite:</i> <span class="d_br">4.5mm</span></span><span><i>Stärke:</i> <span class="d_st">1.4mm</span></span></li><li><span style="font-size: 11px;"><i>Gravur:</i> <span> Bernhard ♡ 06.09.2018</span></span></li><li class="stein"><label>Steinbesatz: </label> <span>OHNE STEINE</span></li><li class="herren"><hr><label>HERRENRING: </label><span><i>Größe:</i> <span> 66mm (Ø 21,0mm)</span></span><br><span><i>Breite:</i> <span class="h_br">7.0mm</span></span><span><i>Stärke:</i> <span class="h_st">2.1mm</span></span></li><li><span style="font-size: 11px;"><i>Gravur:</i> <span> Melanie ♡ 06.09.2018</span></span></li></ol></div>
        </div>
        <div style="margin: 0 15px;">
            <TABLE cellPadding=0 class="tableMoreArticles">
                <TBODY>

                <TD align=left width="18%"><FONT face=Arial size=1><B>Art-Nr.</B></FONT></TD>
                <TD align=left><FONT face=Arial size=1><B>Bezeichnung</B></FONT></TD>
                </TR>
                <TR>
                    <TD colSpan=4>
                        <HR SIZE=1 style="margin: 0; padding: 0;">
                    </TD>
                </TR><-RELOOP START->
                <TR>
                <TR>
                    <TD colSpan=4>

                    </TD>
                </TR>
                <TD vAlign=top noWrap align=left><-Artikelnummer-><br><br>
                    <-if <-Artikelnummer-> <> 99999996 ->
                    <-if <-Artikelnummer-> <> 99999995 ->
                    <img style="width: 70px; margin: 10px 20px 0 0;" src="<-StammBild->" />
                    <- end if ->
                    <- end if ->
                </TD>
                <TD vAlign=top noWrap align=left class="artbeschr_wrapper">
                    <div class="artbeschr" style="display: none;"><-ArtikelBeschreibung-><br></div>
                    <div class="artbeschr_gen" style="width: 230px; float: left;">
                        <ul class="articleDetails">
                            <-if <-Artikelnummer-> <> 99999996 ->
                            <-if <-Artikelnummer-> <> 99999995 ->
                            <li style="font-weight:bold !important; color:red;"><span style="font-weight:bold !important; color:red;">Material</span><-Freifeld2-> <-Freifeld1-></li> <!-- Material -->
                            <- end if ->
                            <- end if ->
                            <li class="rowbr"><span>Breite</span><div class="breite"><-Freifeld3->mm</div></li> <!-- Breite -->
                            <li class="rowst"><span>Stärke</span><div class="staerke"><-Freifeld6->mm</div></li> <!-- Staerke -->
                            <-if <-Artikelnummer-> <> 99999996 ->
                            <-if <-Artikelnummer-> <> 99999995 ->
                            <li style="border:none;"><span>Steinbesatz</span><div class="sb"><-Freifeld5-></div></li> <!-- Steinbesatz <-Freifeld5-> -->
                            <li class="empty"></li>
                            <- end if ->
                            <- end if ->
                            <input type="hidden" name="stbreite" value="<-if <-Artikelnummer-> <> 99999995 -><-Freifeld3-><- end if ->" class="stbreite" />
                            <input type="hidden" name="ststaerke" value="<-if <-Artikelnummer-> <> 99999995 -><-Freifeld6-><- end if ->" class="ststaerke" />

                        </ul>
                    </div>
                    <div style="margin:0;padding:0;float:right;text-align:center;" class="artikelbeschreibung"></div>
                </TD>
                </TR><-RELOOP END->
                <TR>
                    <TD colSpan=4>
                        <HR SIZE=1 style="margin: 0; padding: 0;">
                    </TD></TR>
            </TABLE>

        </div>
    </div>

    <-Kommentar->
    <- else ->
    <div id="bottom">
        <div class="left">
            <div id="productPicture" style="margin: 0px 10px 10px 10px; width: 250px; height: 200px; background: #fff; overflow: hidden;">
                <-if <-ArtikelAnz-> >0 ->
                <-RELOOP START->
                <-if <-Artikelnummer-> <> 99999996 ->
                <-if <-Artikelnummer-> <> 99999995 ->
                <img src="<-StammBild->" />
                <- end if ->
                <- end if ->
                <-RELOOP END->
                <- end if ->
            </div>
        </div>
        <div class="right">
            <div style="" id="articleBoxNew">
                <ol>
                    <li class="prof">
                        <label>Profil: </label>
                        <span style="position: relative; top: 5px; z-index: 999; font-size: 16px; font-weight: bold; ">P3</span>
                    </li>
                    <li class="profpic" style="position: relative; top: -70px; margin-bottom: -77px;">
                        <div style="width: 167px; height: 90px; display: block; margin-left: 80px;">
                            <img src="https://www.traumtrauringe.de/ab_profil_5.png" alt="">
                        </div>
                    </li>
                    <li class="mat">
                        <label style="width: 70px; margin-top: 0;">MATERIAL: </label>
                        <strong style="color: red;">750er Weissgold<br></strong>
                    </li>
                    <li class="damen">
                        <label>DAMENRING: </label>
                        <span>
                            <i>Größe:</i>
                            <span> 53mm (Ø 16,8mm)</span>
                        </span>
                        <br>
                        <span>
                            <i>Breite:</i>
                            <span class="d_br">4.5mm</span>
                        </span>
                        <span>
                            <i>Stärke:</i>
                            <span class="d_st">1.4mm</span>
                        </span>
                    </li>
                    <li>
                        <span style="font-size: 11px;">
                            <i>Gravur:</i>
                            <span> Bernhard ♡ 06.09.2018</span>
                        </span>
                    </li>
                    <li class="stein">
                        <label>Steinbesatz: </label>
                        <span>OHNE STEINE</span>
                    </li>
                    <li class="herren">
                        <hr>
                        <label>HERRENRING: </label>
                        <span>
                            <i>Größe:</i>
                            <span> 66mm (Ø 21,0mm)</span>
                        </span>
                        <br>
                        <span>
                            <i>Breite:</i>
                            <span class="h_br">7.0mm</span>
                        </span>
                        <span>
                            <i>Stärke:</i>
                            <span class="h_st">2.1mm</span>
                        </span>
                    </li>
                    <li>
                        <span style="font-size: 11px;">
                            <i>Gravur:</i>
                            <span> Melanie ♡ 06.09.2018</span>
                        </span>
                    </li>
                </ol>
            </div>

        </div>
        <- if <-Art-> = ebay->
        <div style="font-weight:bold !important; color:red;font-size:1.9em;"> EBAY</div>
        <-end if->
    </div>
    <- end if ->
    <!-- bottom end -->
    <!-- verybottom begin -->
    <div id="verybottom" class="verybottom" style="position: relative; background:transparent;">
        <div class="left attr" style="position: relative; top: 60px; left: 45px; background:transparent; text-decoration: underline; font-size: 1.1em;padding-left:5px;">
            <-RELOOP START-><-AttributWert-><-RELOOP END-><br><br>
            <div class="left" style="background:transparent; color: red; font-size: 1.1em;padding-left:5px;"> <-RELOOP START-> <-Kommentar-> <-RELOOP END-></div>
        </div>
        <div class="middle"style="background:transparent;">
        </div>
        <div class="right"style="background:transparent;">
            <div id="qrcode" style="position:absolute; top:-30px;margin:170px 0 0 0px; background:transparent !Important;">
                <img src="/afterbuy/barcode.aspx?BType=4&Height=40&Width=150&Text=1&TextSize=10&Font=Arial&Scaling=1&Data=<-ReNr->&PZ=0">
            </div>
        </div>
    </div>
    <!-- verybottom end -->
</div>
<!-- wrapper end -->

<-else->
<div id="wrapper" class="wrapper<-OrderID->">
    <!-- top begin -->
    <div id="top">
        <div class="left">
            <!-- Logo -->
            <div id="logo">
                <img  alt="ewigetrauringe-logo" src="http://www.ewigetrauringe.de/g12.png"/>
            </div>
            <div id="companyName">ewigetrauringe</div>
            <div id="companyColor"></div>
        </div>
        <div class="right">
            <!-- Datum -->
            <ul class="date" style="margin-left:10px;">
                <li style="border-bottom: 1px solid gray; font-size: .8em;"><span style="background:none;">Druck:</span><-Datum-></li>
                <li style="border-bottom: 1px solid gray; color: red; font-size:.8em;font-weight:bold;"><span style="background:none;"> Bestellung:</span><-EndeDerAuktionShort-></li>
                <-if <-Zahlart-> <> Nachnahme ->  <li style="border-bottom: 1px solid gray; font-size:.8em; word-break: break-all;"><span style="background:none;"> Bezahlt am:</span><-Bezahlt-></li> <- end if ->
                <li style="font-size:.8em; word-break: break-all;"><span style="background:none;"> Feedback am:</span><-Feedback-></li>
            </ul>
        </div>
    </div>
    <!-- top end -->
    <!-- middle begin -->
    <div id="middle">
        <div class="left">
            <ul class="adress">
                <li><-KLFIRMA-></li> <!-- Firma -->
                <li><-KLNachname->,<-KLVorname-></li> <!-- Name, Vorname -->
                <li><-KLStrasse-><-KLAnschrift2-></li> <!-- Strasse -->
                <li><-KLPLZ-> <-KLOrt-></li> <!-- PLZ / ORT -->
                <li><-KLLandPost-></li> <!-- Land -->
                <li><-KTELEFON-></li> <!-- Telefon -->
            </ul>
        </div>
        <div class="right">
            <ul>
                <li style="background:none;"><span>Rechnungsdaten:</span></li>
            </ul>
            <ul class="invoiceDetails" style="font-size: 1.10em !important;">
                <li style="font-weight:bold !important; color:red; "><span style="font-weight:bold !important; color:red;">RNR</span><-ReNr-></li> <!-- RechnungsNummer -->
                <li><span>KNR</span><-KNummer-></li> <!--Art -->
                <li><span>ANR</span><-Artikelnummer-></li> <!-- ArtikelNummer -->
                <li style="font-size: 0.6em !important;"><span style="font-size: 1.1em;padding-top: 2px; height: 18px;">ANM</span>
                    <-RELOOP START-><-if <-Artikelnummer-> <> 99999996 -><-if <-Artikelnummer-> <> 99999995 -><-freifeld8-><- end if -><- end if -><-RELOOP END-> </li> <!-- MODELL -->
                <li><span>EUR</span><-Summe-></li> <!-- Betrag  -->
                <li style="font-size: 0.6em !important;"><nobr><span style="font-size: 1.1em;padding-top: 2px; height: 18px;">ART</span><-if <-Zahlart-> = Nachnahme -><b style="font-size: 1.4em;color: red; margin-top: -2px; display: inline-block; border: 1px solid red;"><img src="https://www.traumtrauringe.de/arrow_nn.png" style="margin:2px;padding:0;height: 10px;" alt="Nachnahme" /></b><- else -><-Zahlart-><- end if -></nobr></li> <!-- Betrag  -->
            </ul>
        </div>
    </div>
    <!-- middle end -->
    <!-- bottom begin -->
    <-if <-ArtikelAnz-> >1 ->
    <div id="bottom">
        <div class="left" style="display: none !important;"></div>
        <div class="right" style="display: none !important;">

        </div>
        <div style="margin: 0 15px;">
            <TABLE cellPadding=0 class="tableMoreArticles">
                <TBODY>

                <TD align=left width="18%"><FONT face=Arial size=1><B>Art-Nr.</B></FONT></TD>
                <TD align=left><FONT face=Arial size=1><B>Bezeichnung</B></FONT></TD>
                </TR>
                <TR>
                    <TD colSpan=4>
                        <HR SIZE=1 style="margin: 0; padding: 0;">
                    </TD>
                </TR><-RELOOP START->
                <TR>
                <TR>
                    <TD colSpan=4>

                    </TD>
                </TR>
                <TD vAlign=top noWrap align=left><-Artikelnummer-><br><br>
                    <-if <-Artikelnummer-> <> 99999996 ->
                    <-if <-Artikelnummer-> <> 99999995 ->
                    <img style="width: 70px; margin: 10px 20px 0 0;" src="<-StammBild->" />
                    <- end if ->
                    <- end if ->
                </TD>
                <TD vAlign=top noWrap align=left class="artbeschr_wrapper">
                    <div class="artbeschr" style="display: none;"><-ArtikelBeschreibung-><br></div>
                    <div class="artbeschr_gen" style="width: 230px; float: left;">
                        <ul class="articleDetails">
                            <-if <-Artikelnummer-> <> 99999996 ->
                            <-if <-Artikelnummer-> <> 99999995 ->
                            <li style="font-weight:bold !important; color:red;"><span style="font-weight:bold !important; color:red;">Material</span><-Freifeld2-> <-Freifeld1-></li> <!-- Material -->
                            <- end if ->
                            <- end if ->
                            <li class="rowbr"><span>Breite</span><div class="breite"><-Freifeld3->mm</div></li> <!-- Breite -->
                            <li class="rowst"><span>Stärke</span><div class="staerke"><-Freifeld6->mm</div></li> <!-- Staerke -->
                            <-if <-Artikelnummer-> <> 99999996 ->
                            <-if <-Artikelnummer-> <> 99999995 ->
                            <li style="border:none;"><span>Steinbesatz</span><div class="sb"><-Freifeld5-></div></li> <!-- Steinbesatz <-Freifeld5-> -->
                            <li class="empty"></li>
                            <- end if ->
                            <- end if ->
                            <input type="hidden" name="stbreite" value="<-if <-Artikelnummer-> <> 99999995 -><-Freifeld3-><- end if ->" class="stbreite" />
                            <input type="hidden" name="ststaerke" value="<-if <-Artikelnummer-> <> 99999995 -><-Freifeld6-><- end if ->" class="ststaerke" />

                        </ul>
                    </div>
                    <div style="margin:0;padding:0;float:right;text-align:center;" class="artikelbeschreibung"></div>
                </TD>
                </TR><-RELOOP END->
                <TR>
                    <TD colSpan=4>
                        <HR SIZE=1 style="margin: 0; padding: 0;">
                    </TD></TR>
            </TABLE>

        </div>
    </div>

    <-Kommentar->
    <- else ->
    <div id="bottom">
        <div class="left">
            <div id="productPicture" style="margin: 0px 10px 10px 10px; width: 250px; height: 200px; background: #fff; overflow: hidden;">
                <-if <-ArtikelAnz-> >=0 ->
                <-RELOOP START->
                <-if <-Artikelnummer-> <> 99999996 ->
                <-if <-Artikelnummer-> <> 99999995 ->
                <img src="<-StammBild->" />
                <- end if ->
                <- end if ->
                <-RELOOP END->
                <- end if ->
            </div>
        </div>
        <div class="right">
            <ul class="articleDetails">
                <-if <-ArtikelAnz-> >=0 ->

                <-RELOOP START->
                <-if <-Artikelnummer-> <> 99999996 ->
                <-if <-Artikelnummer-> <> 99999995 ->
                <li style="font-weight:bold !important; color:red;"><span style="font-weight:bold !important; color:red;">Material</span><-Freifeld2-> <-Freifeld1-></li> <!-- Material -->
                <- end if ->
                <- end if ->
                <li class="rowbr"><span>Breite</span><div class="breite"><-if <-Artikelnummer-> <> 99999995 -><-Freifeld3->mm<- end if -></div></li> <!-- Breite -->
                <li class="rowst"><span>Stärke</span><div class="staerke"><-if <-Artikelnummer-> <> 99999995 -><-Freifeld6->mm<- end if -></div></li> <!-- Staerke -->
                <-RELOOP END->
                <-RELOOP START->
                <-if <-Artikelnummer-> <> 99999996 ->
                <-if <-Artikelnummer-> <> 99999995 ->
                <li style="height:30px;border:none;"><span>Steinbesatz</span><div  class="sb"><-Freifeld5-></div></li> <!-- Steinbesatz <-Freifeld5-> -->
                <li class="empty"></li>
                <- end if ->
                <- end if ->
                <-RELOOP END->
                <- end if ->
                <-RELOOP START-><li style="border:none; height: auto; line-height: 17px; text-transform: none !Important;"><-AttributWert-><br><br><-Kommentar-></li><-RELOOP END->
                <input type="hidden" name="stbreite" value="<-if <-Artikelnummer-> <> 99999995 -><-Freifeld3-><- end if ->" class="stbreite" />
                <input type="hidden" name="ststaerke" value="<-if <-Artikelnummer-> <> 99999995 -><-Freifeld6-><- end if ->" class="ststaerke" />

            </ul>

        </div>
        <- if <-Art-> = ebay->
        <div style="font-weight:bold !important; color:red;font-size:1.9em;"> EBAY</div>
        <-end if->
    </div>
    <- end if ->
    <!-- bottom end -->
    <!-- verybottom begin -->
    <div id="verybottom" class="verybottom" style="position: relative; background:transparent;">
        <div class="left" style="position: relative; top: 60px; left: 25px; background:transparent; text-decoration: underline; font-size: 1.1em;padding-left:5px;">
            <-RELOOP START-><-AttributWert-><-RELOOP END-><br><br>
            <div class="left" style="background:transparent; color: red; font-size: 1.1em;padding-left:5px;"> <-RELOOP START-> <-Kommentar-> <-RELOOP END-></div>
        </div>
        <div class="middle"style="background:transparent;">
        </div>
        <div class="right"style="background:transparent;">
            <div id="qrcode" style="margin:170px 0 0 0px; background:transparent !Important;">
                <img src="/afterbuy/barcode.aspx?BType=4&Height=40&Width=150&Text=1&TextSize=10&Font=Arial&Scaling=1&Data=<-ReNr->&PZ=0">
            </div>
        </div>
    </div>
    <!-- verybottom end -->
</div>
<!-- wrapper end -->


<script>
    var newHTML = '<style>ul li { background: none !important; background-color: transparent !important; }   #verybottom  { position: relative; top: 10px; } #articleBoxNew hr { border-top: 1px solid #ddd; border-bottom: 0; margin: 0 0 10px 0; padding: 0; }  #articleBoxNew ol { list-style: none; margin: 30px 0 0 0; padding: 0; } #articleBoxNew ol li { padding: 5px 0; font-size: 11px; } #articleBoxNew ol li.mat, #articleBoxNew ol li.mat label, #articleBoxNew ol li.mat span {  color: red; } #articleBoxNew ol li label { width: 100%; font-size: 11px; font-weight: bold; display: inline-block; vertical-align: top; } #articleBoxNew ol li span i { float: left; display: inline-block; width: 56px; } #articleBoxNew ol li span { word-break: break-all; font-size: 11px; display: inline-block; margin: 0; } #articleBoxNew ol li span span { display: table; width: 180px; margin: 2px 0; } </style>';

    $('div[class="wrapper<-OrderID->"] .artbeschr_wrapper').each(function() {
        wrapContA = $(this);
        wrapContB = $(this).find('.artbeschr_gen');
        var chknotizA = wrapContA.find('.artbeschr').html();
        kommentar = $('html').find('.verybottom .left .left').html();


        var getnotizA, getnotiz_rawA, newHTMLA;
        if(chknotizA != '') {

            getnotiz_rawA = chknotizA.match(/Notiz: (.*?)Ringdaten -(.*?)<br>/i);

            if(getnotiz_rawA) {
                getnotiz = getnotiz_rawA[2].replace('%7', '');
                profil = getnotiz.match(/\(P(.*?)\)/i);
                tabl_profil = profil[1];

                var multiarticle = 0;
                var count_damen = chknotizA.match(/D: /g);
                var count_herren = chknotizA.match(/H: /g);

                if(getnotiz.match(/\//i)) {
                    ring_type_d = getnotiz.match(/: (.*?)mm-(.*?)mm \//i);
                    ring_type_h = getnotiz.match(/\/ (.*?)mm-(.*?)mm/i);
                    var tabl_type = 1;
                    var tabl_ring_d_br = ring_type_d[1];
                    var tabl_ring_d_st = ring_type_d[2];
                    var tabl_ring_h_br = ring_type_h[1];
                    var tabl_ring_h_st = ring_type_h[2];
                } else if(chknotizA.match(/D: /) && chknotizA.match(/H: /)) {
                    getnotiz = chknotizA.replace('%7', '');
                    profil1 = chknotizA.match(/Notiz: (.*?)Ringdaten - D:(.*?)\(P(.*?)\)<br>/i);
                    profil2 = chknotizA.match(/Notiz: (.*?)Ringdaten - H:(.*?)\(P(.*?)\)<br>/i);

                    ring_type_d = getnotiz.match(/D: (.*?)mm-(.*?)mm/i);
                    ring_type_h = getnotiz.match(/H: (.*?)mm-(.*?)mm/i);
                    var tabl_type = 1;
                    multiarticle = 1;
                    var tabl_ring_d_br = ring_type_d[1];
                    var tabl_ring_d_st = ring_type_d[2];
                    var tabl_ring_h_br = ring_type_h[1];
                    var tabl_ring_h_st = ring_type_h[2];
                } else if(count_damen && count_damen.length == 2) {

                } else if(count_herren && count_herren.length == 2) {
                    getnotiz = chknotizA.replace('%7', '');
                    profil1 = chknotizA.match(/Notiz: (.*?)Ringdaten - H:(.*?)\(P(.*?)\)<br>/ig);
                    ring_type_d = getnotiz.match(/H: (.*?)mm-(.*?)mm/ig);
                    var tabl_type = 1;
                    multiarticle = 1;
                    for (i = 0; i < profil1.length; i++) {
                        if(i>1) {
                            profil1 = chknotizA.match(/Notiz: (.*?)Ringdaten - H:(.*?)\(P(.*?)\)<br>/i);
                            var tabl_ring_d_br = ring_type_d[1];
                            var tabl_ring_d_st = ring_type_d[2];
                        } else {
                            profil2 = chknotizA.match(/Notiz: (.*?)Ringdaten - H:(.*?)\(P(.*?)\)<br>/i);
                            var tabl_ring_h_br = ring_type_d[1];
                            var tabl_ring_h_st = ring_type_d[2];
                        }
                    }

                } else {
                    if(getnotiz.match(/D:/i)) {
                        ring_type_d = getnotiz.match(/D: (.*?)mm-(.*?)mm/i);
                        var tabl_type = 2;
                        var tabl_ring_d_br = ring_type_d[1];
                        var tabl_ring_d_st = ring_type_d[2];
                    } else {
                        ring_type_h = getnotiz.match(/H: (.*?)mm-(.*?)mm/i);
                        var tabl_type = 3;
                        var tabl_ring_h_br = ring_type_h[1];
                        var tabl_ring_h_st = ring_type_h[2];

                    }
                }

                if(tabl_type == 1 || tabl_type == 2 || tabl_type == 3) {
                    var damengravur, herrengravur, damengroesse, herrengroesse;
                    ringData = chknotizA;
                    if(tabl_type==1) {
                        damengravur = ringData.match(/Damenring\-Gravur:(.*?)<br>/i);
                        herrengravur = ringData.match(/Herrenring\-Gravur:(.*?)<br>/i);
                        damengroesse = ringData.match(/Damenring\-Grösse:(.*?)<br>/i);
                        herrengroesse = ringData.match(/Herrenring\-Grösse:(.*?)<br>/i);
                    } else if(tabl_type==2) {
                        damengravur = ringData.match(/Damenring\-Gravur: (.*?)<br>/i);
                        damengroesse = ringData.match(/Damenring\-Grösse: (.*?)<br>/i);
                    } else if(tabl_type==3) {
                        herrengravur = ringData.match(/Herrenring\-Gravur: (.*?)<br>/i);
                        herrengroesse = ringData.match(/Herrenring\-Grösse: (.*?)<br>/i);
                    }

                    var tabl_stone, tabl_material = '', multiprof1 = '', multiprof2 = '';

                    nchknotizA = chknotizA.replace(/Notiz: (.*?)<br>/igm, '');
                    getnotiztext = chknotizA.match(/Notiz:(.*?)\/ Ring/i);
                    /*
                    if(getnotiztext!="" && getnotiztext!=null) {
                        $(wrapContA).find('#productPicture').append('<br><div style="width: 200px;word-break: break-all;"><b>Notiz:</b> '+getnotiztext[1]+'</div>');
                    }
                    if(kommentar!="" && kommentar!=null) {
                        $(wrapContA).find('#productPicture').append('<br><div style="width: 200px;word-break: break-all;">'+kommentar+'</div>');
                    }
                    */

                    if(tabl_profil == 1) { var tabl_prpic = 'https://www.traumtrauringe.de/ab_profil_1.png'; }
                    if(tabl_profil == 2) { var tabl_prpic = 'https://www.traumtrauringe.de/ab_profil_2.png'; }
                    if(tabl_profil == 3) { var tabl_prpic = 'https://www.traumtrauringe.de/ab_profil_5.png'; }
                    if(tabl_profil == 4) { var tabl_prpic = 'https://www.traumtrauringe.de/ab_profil_3.png'; }
                    if(tabl_profil == 5) { var tabl_prpic = 'https://www.traumtrauringe.de/ab_profil_4.png'; }

                    wrapContA.find('.artikelbeschreibung').append("<img src='"+tabl_prpic+"' alt='' style='height: 60px; margin: 10px 0 0 0;' /><br><br><b>PROFIL "+tabl_profil+"</b>");

                    $(wrapContB).find('.articleDetails li').each(function() {
                        if(getnotiz.match(/ohne Stein/i)) { tabl_stone = 'OHNE STEINE'; } else {
                            if($(this).html().match(/Steinbesatz/i)) { tabl_stone = $(this).find('.sb').html(); }
                        }
                        if($(this).html().match(/Material/i)) {
                            tabl_material += $(this).html().replace(/(<([^>]+)>)/ig,"").replace('Material','');
                            tabl_material += '<br>';
                        }
                    });
                    newHTMLA = '';
                    newHTMLA += '<div style="" id="articleBoxNew">'+
                        '<ol style="margin-top: 0;">';
                    if(tabl_material!="") newHTMLA += '<li class="mat"><label style="width: 90px; margin-top: 0;">MATERIAL: </label> <strong style="color: red;">'+tabl_material+'</strong></li>';
                    if(tabl_type == 1 || tabl_type == 2) {
                        if(multiarticle==1) { multiprof1 = ' (Profil '+profil1[3]+')'; }
                        newHTMLA += '<li class="damen"><label style="width: 90px; margin-top: 0;">DAMENRING'+multiprof1+': </label><br>';
                        if($.isArray(damengroesse) && damengroesse[1]!="") newHTMLA += '<span><i>Größe:</i> <span>'+damengroesse[1]+'</span></span><br>';
                        newHTMLA += '<span><i>Breite:</i> <span class="d_br">'+tabl_ring_d_br+'mm</span></span><span><i>Stärke:</i> <span class="d_st">'+tabl_ring_d_st+'mm</span></span></li>';
                        if($.isArray(damengravur) && damengravur[1]!="") newHTMLA += '<li><span style="font-size: 11px;"><i>Gravur:</i> <span>'+damengravur[1]+'</span></span></li>';

                        if(tabl_stone!="") newHTMLA += '<li class="stein"><label style="width: 90px; margin-top: 0;">Steinbesatz: </label> <br><span>'+tabl_stone+'</span></li>';
                    }
                    if(tabl_type == 1 || tabl_type == 3) {
                        if(multiarticle==1) { multiprof2 = ' (Profil '+profil2[3]+')'; }
                        newHTMLA += '<li class="herren"><hr><label style="width: 90px; margin-top: 0;">HERRENRING'+multiprof2+': </label><br>';
                        if($.isArray(herrengroesse) && herrengroesse[1]!="") newHTMLA += '<span><i>Größe:</i> <span>'+herrengroesse[1]+'</span></span><br>';
                        newHTMLA += '<span><i>Breite:</i> <span class="h_br">'+tabl_ring_h_br+'mm</span></span><span><i>Stärke:</i> <span class="h_st">'+tabl_ring_h_st+'mm</span></span></li>';
                        if($.isArray(herrengravur) && herrengravur[1]!="") newHTMLA += '<li><span style="font-size: 11px;"><i>Gravur:</i> <span>'+herrengravur[1]+'</span></span></li>';

                    }
                    newHTMLA += '</ol><style>#articleBoxNew ol li { padding:0 !Important;} #articleBoxNew ol li span span {width: 180px !Important;} #articleBoxNew ol li span span.h_br, #articleBoxNew ol li span span.h_st { width: 70px !important; }</span>'+
                        '</div>';
                    $(wrapContB).find('.articleDetails').hide();
                    $(wrapContB).append(newHTMLA);
                }

            }else{

                ringData = chknotizA;
                damengravur = ringData.match(/Damenring\-Gravur:(.*?)<br>/i);
                herrengravur = ringData.match(/Herrenring\-Gravur:(.*?)<br>/i);
                damengroesse = ringData.match(/Damenring\-Grösse:(.*?)<br>/i);
                herrengroesse = ringData.match(/Herrenring\-Grösse:(.*?)<br>/i);

                newHTMLA = '';
                if($.isArray(damengroesse) && damengroesse[1]!="") newHTMLA += '<li style="width: 300px; text-transform: none;">Damen Größe:   '+damengroesse[1]+'</li>';
                if($.isArray(damengravur) && damengravur[1]!="") newHTMLA += '<li style="width: 300px; text-transform: none;">Damen Gravur:   '+damengravur[1]+'</li>';

                if($.isArray(herrengroesse) && herrengroesse[1]!="") newHTMLA += '<li style="width: 300px; text-transform: none;">Herren Größe:   '+herrengroesse[1]+'</li>';
                if($.isArray(herrengravur) && herrengravur[1]!="") newHTMLA += '<li style="width: 300px; text-transform: none;">Herren Gravur:   '+herrengravur[1]+'</li>';

                $(wrapContB).find('.articleDetails').append(newHTMLA);
            }
        }
    });
    $('div[class="wrapper<-OrderID->"]').each(function() {
        wrapCont = $(this);
        kommentar = $(wrapCont).find('.verybottom .left .left').html();
        $(wrapCont).find('.verybottom .left').hide();

    <-if <-ArtikelAnz-> = 1 ->
        var chknotiz = $(wrapCont).find('.verybottom').html();
        var getnotiz, getnotiz_raw;
        getnotiz_raw = chknotiz.match(/Notiz: (.*?)Ringdaten -(.*?)<br>/i);
        if(getnotiz_raw != null && getnotiz_raw[2] != "") {
            getnotiz = getnotiz_raw[2].replace('%7', '');

            profil = getnotiz.match(/\(P(.*?)\)/i);
            tabl_profil = profil[1];
            var multiarticle = 0;
            var count_damen = chknotiz.match(/D: /g);
            var count_herren = chknotiz.match(/H: /g);

            if(getnotiz.match(/\//i)) {
                ring_type_d = getnotiz.match(/: (.*?)mm-(.*?)mm \//i);
                ring_type_h = getnotiz.match(/\/ (.*?)mm-(.*?)mm/i);
                var tabl_type = 1;
                var tabl_ring_d_br = ring_type_d[1];
                var tabl_ring_d_st = ring_type_d[2];
                var tabl_ring_h_br = ring_type_h[1];
                var tabl_ring_h_st = ring_type_h[2];
            } else if(chknotiz.match(/D: /) && chknotiz.match(/H: /)) {
                getnotiz = chknotiz.replace('%7', '');
                profil1 = chknotiz.match(/Notiz: (.*?)Ringdaten - D:(.*?)\(P(.*?)\)<br>/i);
                profil2 = chknotiz.match(/Notiz: (.*?)Ringdaten - H:(.*?)\(P(.*?)\)<br>/i);

                ring_type_d = getnotiz.match(/D: (.*?)mm-(.*?)mm/i);
                ring_type_h = getnotiz.match(/H: (.*?)mm-(.*?)mm/i);
                var tabl_type = 1;
                multiarticle = 1;
                var tabl_ring_d_br = ring_type_d[1];
                var tabl_ring_d_st = ring_type_d[2];
                var tabl_ring_h_br = ring_type_h[1];
                var tabl_ring_h_st = ring_type_h[2];
            } else if(count_damen && count_damen.length == 2) {

            } else if(count_herren && count_herren.length == 2) {
                getnotiz = chknotiz.replace('%7', '');
                profil1 = chknotiz.match(/Notiz: (.*?)Ringdaten - H:(.*?)\(P(.*?)\)<br>/ig);
                ring_type_d = getnotiz.match(/H: (.*?)mm-(.*?)mm/ig);
                var tabl_type = 1;
                multiarticle = 1;
                for (i = 0; i < profil1.length; i++) {
                    if(i>1) {
                        profil1 = chknotiz.match(/Notiz: (.*?)Ringdaten - H:(.*?)\(P(.*?)\)<br>/i);
                        var tabl_ring_d_br = ring_type_d[1];
                        var tabl_ring_d_st = ring_type_d[2];
                    } else {
                        profil2 = chknotiz.match(/Notiz: (.*?)Ringdaten - H:(.*?)\(P(.*?)\)<br>/i);
                        var tabl_ring_h_br = ring_type_d[1];
                        var tabl_ring_h_st = ring_type_d[2];
                    }
                }

            } else {
                if(getnotiz.match(/D:/i)) {
                    ring_type_d = getnotiz.match(/D: (.*?)mm-(.*?)mm/i);
                    var tabl_type = 2;
                    var tabl_ring_d_br = ring_type_d[1];
                    var tabl_ring_d_st = ring_type_d[2];
                } else {
                    ring_type_h = getnotiz.match(/H: (.*?)mm-(.*?)mm/i);
                    var tabl_type = 3;
                    var tabl_ring_h_br = ring_type_h[1];
                    var tabl_ring_h_st = ring_type_h[2];

                }
            }

            if(tabl_type == 1 || tabl_type == 2 || tabl_type == 3) {
                var damengravur, herrengravur, damengroesse, herrengroesse;
                ringData = chknotiz;
                if(tabl_type==1) {
                    damengravur = ringData.match(/Damenring\-Gravur:(.*?)<br>/i);
                    herrengravur = ringData.match(/Herrenring\-Gravur:(.*?)<br>/i);
                    damengroesse = ringData.match(/Damenring\-Grösse:(.*?)<br>/i);
                    herrengroesse = ringData.match(/Herrenring\-Grösse:(.*?)<br>/i);
                } else if(tabl_type==2) {
                    damengravur = ringData.match(/Damenring\-Gravur: (.*?)<br>/i);
                    damengroesse = ringData.match(/Damenring\-Grösse: (.*?)<br>/i);
                } else if(tabl_type==3) {
                    herrengravur = ringData.match(/Herrenring\-Gravur: (.*?)<br>/i);
                    herrengroesse = ringData.match(/Herrenring\-Grösse: (.*?)<br>/i);
                }

                $(wrapCont).find('#productPicture').prop('style', 'margin: 0px 10px 10px; width: 250px; height: auto; overflow: hidden; font-size: 11px; background: rgb(255, 255, 255);');
                $(wrapCont).find('#productPicture img').prop('style', 'width: 200px;');
                $(wrapCont).find('.articleDetails').hide();
                $(wrapCont).find('#bottom .right').css('height', 'auto').css('width', '260px');
                $(wrapCont).find('#bottom .left').css('width', '240px').css('height', 'auto');
                $(wrapCont).find('#productPicture').css('height', 'auto').css('font-size', '11px');
                var tabl_stone, tabl_material = '', multiprof1 = '', multiprof2 = '';

                nchknotiz = chknotiz.replace(/Notiz: (.*?)<br>/igm, '');
                getnotiztext = chknotiz.match(/Notiz:(.*?)\/ Ring/i);
                if(getnotiztext!="" && getnotiztext!=null) {
                    $(wrapCont).find('#productPicture').append('<br><div style="width: 200px;word-break: break-all;"><b>Notiz:</b> '+getnotiztext[1]+'</div>');
                }
                if(kommentar!="" && kommentar!=null) {
                    $(wrapCont).find('#productPicture').append('<br><div style="width: 200px;word-break: break-all;">'+kommentar+'</div>');
                }
                if(tabl_profil == 1) { var tabl_prpic = 'https://www.traumtrauringe.de/ab_profil_1.png'; }
                if(tabl_profil == 2) { var tabl_prpic = 'https://www.traumtrauringe.de/ab_profil_2.png'; }
                if(tabl_profil == 3) { var tabl_prpic = 'https://www.traumtrauringe.de/ab_profil_5.png'; }
                if(tabl_profil == 4) { var tabl_prpic = 'https://www.traumtrauringe.de/ab_profil_3.png'; }
                if(tabl_profil == 5) { var tabl_prpic = 'https://www.traumtrauringe.de/ab_profil_4.png'; }

                $(wrapCont).find('.articleDetails li').each(function() {
                    if(getnotiz.match(/ohne Stein/i)) { tabl_stone = 'OHNE STEINE'; } else {
                        if($(this).html().match(/Steinbesatz/i)) { tabl_stone = $(this).find('.sb').html(); }
                    }
                    if($(this).html().match(/Material/i)) {
                        tabl_material += $(this).html().replace(/(<([^>]+)>)/ig,"").replace('Material','');
                        tabl_material += '<br>';
                    }
                });
                newHTML += '<div style="" id="articleBoxNew">'+
                    '<ol>';
                newHTML += '<li class="prof"><label>Profil: </label> <span style="position: relative; top: 5px; z-index: 999; font-size: 16px; font-weight: bold; ">P'+tabl_profil+'</span></li>'+
                    '<li class="profpic" style="position: relative; top: -70px; margin-bottom: -77px;"><div style="width: 167px; height: 90px; display: block; margin-left: 80px;"><img src="'+tabl_prpic+'" alt="" /></div></li>';

                if(tabl_material!="") newHTML += '<li class="mat"><label style="width: 70px; margin-top: 0;">MATERIAL: </label> <strong style="color: red;">'+tabl_material+'</strong></li>';
                if(tabl_type == 1 || tabl_type == 2) {
                    if(multiarticle==1) { multiprof1 = ' (Profil '+profil1[3]+')'; }
                    newHTML += '<li class="damen"><label>DAMENRING'+multiprof1+': </label>';
                    if($.isArray(damengroesse) && damengroesse[1]!="") newHTML += '<span><i>Größe:</i> <span>'+damengroesse[1]+'</span></span><br>';
                    newHTML += '<span><i>Breite:</i> <span class="d_br">'+tabl_ring_d_br+'mm</span></span><span><i>Stärke:</i> <span class="d_st">'+tabl_ring_d_st+'mm</span></span></li>';
                    if($.isArray(damengravur) && damengravur[1]!="") newHTML += '<li><span style="font-size: 11px;"><i>Gravur:</i> <span>'+damengravur[1]+'</span></span></li>';

                    if(tabl_stone!="") newHTML += '<li class="stein"><label>Steinbesatz: </label> <span>'+tabl_stone+'</span></li>';
                }
                if(tabl_type == 1 || tabl_type == 3) {
                    if(multiarticle==1) { multiprof2 = ' (Profil '+profil2[3]+')'; }
                    newHTML += '<li class="herren"><hr><label>HERRENRING'+multiprof2+': </label>';
                    if($.isArray(herrengroesse) && herrengroesse[1]!="") newHTML += '<span><i>Größe:</i> <span>'+herrengroesse[1]+'</span></span><br>';
                    newHTML += '<span><i>Breite:</i> <span class="h_br">'+tabl_ring_h_br+'mm</span></span><span><i>Stärke:</i> <span class="h_st">'+tabl_ring_h_st+'mm</span></span></li>';
                    if($.isArray(herrengravur) && herrengravur[1]!="") newHTML += '<li><span style="font-size: 11px;"><i>Gravur:</i> <span>'+herrengravur[1]+'</span></span></li>';

                }
                newHTML += '</ol>'+
                    '</div>';
                $(wrapCont).find('#bottom .right').append(newHTML);
            }
        }
    <- else ->

        $(wrapCont).find('#bottom .right').append(newHTML);
    <- end if ->
        shopBarcode = $(wrapCont).find('#qrcode').html();
        var altLogo = $(wrapCont).find('#logo img').attr('alt');
        var barcodePrefix = '';
        if(altLogo != null && altLogo.match(/ASF-Trau/i)) {
            barcodePrefix = 'ASF';
        } else if(altLogo != null && altLogo.match(/traumtrauringe/i)) {
            barcodePrefix = 'TT';
        } else if(altLogo != null && altLogo.match(/ewigetrau/i)) {
            barcodePrefix = 'ET';
        } else if(altLogo != null && altLogo.match(/juwelier-schmuck/i)) {
            barcodePrefix = 'JS';
        }
        shopBarcode = shopBarcode.replace(/Data=(.*?)\&/g, 'Data='+barcodePrefix+'$1&');
        $(wrapCont).find('.verybottom').prepend('<div style="position: absolute; left: 40px;">'+$(wrapCont).find('#qrcode').html()+'</div>');
        $(wrapCont).find('.verybottom').prepend('<div style="position: absolute; left: 270px;">'+shopBarcode+'</div>');
        $(wrapCont).find('.verybottom .right #qrcode').remove();
    });

</script>
<-end if->
</body>
</html>




<!-- <-RELOOP START-><img alt="" src="<-StammBild->"/><-RELOOP END-> -->