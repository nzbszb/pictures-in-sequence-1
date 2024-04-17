<?php
session_start();

if (isset($_POST['gallery_style'])) {
    $_SESSION['gallery_style'] = $_POST['gallery_style'];
}
$start_link = $_GET['start_link'] ?? null;
$end_link = $_GET['end_link'] ?? null;
$start_number = $_GET['start_number'] ?? null;
$end_number = $_GET['end_number'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pictures in Sequence</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        monoImageView = 0, monoImageViewURL = "", AutoWidth = 0, array = [30], className = "", gallerySlideArray = [2e3];
        class JavaScriptGallery {
            added = 0;
            ImageIndex = 0;
            viewerPosition = 0;
            transition = "opacity";
            enableViewOriginalPictureVal = 0;
            zoomVal = 0;
            share = 0;
            backgroundcolor = "#000000e8";
            galleryStyle = "normal";
            GalleryWidth = 0;
            imageWidth = 0;
            galleryPos = 1;
            disabelInitMove = !1;
            speed = 300;
            animation = !0;
            dots = !0;
            constructor() {}
            enableDoubleClick() {
                var self = this;
                $(".ViewerImage").dblclick((function() {
                    self.zoom()
                }))
            }
            backgroundColor(color) {
                this.backgroundcolor = color
            }
            enableAutoWidth() {
                AutoWidth = 1
            }
            mosaic() {
                $(".Gallery").show();
                let row = 0,
                    column = 0,
                    x = 5,
                    y = 3,
                    xminus = 4,
                    yminus = 4,
                    imageWidth = 0;
                for (this.GalleryWidth = $(".Gallery").width(), i = 0; i < this.ImageIndex; i++) this.GalleryWidth > 1500 && (x = 6, y = 4), this.GalleryWidth > 2e3 && (x = 7, y = 5), this.GalleryWidth < 700 && (x = 4, y = 2), this.GalleryWidth < 500 && (x = 2, y = 1), row % 2 == 0 ? (imageWidth = this.GalleryWidth / x - 4, $(".Gallery #" + i).css("max-width", imageWidth + "px"), $(".Gallery #" + i).css("min-width", imageWidth + "px"), $(".Gallery #" + i).css("width", imageWidth + "px"), $(".Gallery #" + i).css("max-height", "175px"), $(".Gallery #" + i).css("min-height", "175px"), column == x - 1 && (row++, column = -1), $(".Gallery #" + i).length && column++) : (imageWidth = this.GalleryWidth / y - 4, $(".Gallery #" + i).css("max-width", imageWidth + "px"), $(".Gallery #" + i).css("min-width", imageWidth + "px"), $(".Gallery #" + i).css("width", imageWidth + "px"), $(".Gallery #" + i).css("max-height", "200px"), $(".Gallery #" + i).css("min-height", "200px"), column == y - 1 && (row++, column = -1), $(".Gallery #" + i).length && column++)
            }
            addGallery(Data) {
                var obj = jQuery.parseJSON(Data),
                    self = this;
                $.each(obj, (function(i, item) {
                    for ("tiles" == self.galleryStyle && (className = "tiles"), "full" == self.galleryStyle && (className = "full"), "center" == self.galleryStyle && (className = "center"), "Circles" == self.galleryStyle && (className = "Circles"), "mosaic" == self.galleryStyle && (className = "mosaic"), "mosaic" != className ? $(".Gallery").append("<p>" + obj.Entry.Title + "</p>") : $(".Gallery").hide(), length = Object.keys(obj.Entry.Image).length, $(".addToGallery").each((function() {
                            $(this).attr("id", self.ImageIndex), $(this).addClass("addedToGallery"), self.ImageIndex++
                        })), i = 0; i < length; i++) {
                        let x = 1;
                        if (x = obj.Entry.Image[i].includes(".jpeg#preview") ? 2 : obj.Entry.Image[i].includes(".jpg#preview") ? 2 : obj.Entry.Image[i].includes(".png#preview") ? 2 : obj.Entry.Image[i].includes(".webp#preview") ? 2 : 1, 1 == x) $(".Gallery").append('<img loading="lazy" class="' + className + '" alt="Image' + self.ImageIndex + '"onerror = "this.style=\'display:none !important;\'"' + '" width="300px" height="169px" class="fadein" id="' + self.ImageIndex + '" onClick="JavaScriptGallery.openViewer(this.id)" src="' + obj.Entry.Image[i] + '"/>'), self.ImageIndex++;
                        else {
                            let split, newURL;
                            obj.Entry.Image[i].includes(".jpeg") ? (split = obj.Entry.Image[i].split(".jpeg"), newURL = split[0] + "-preview.jpeg#preview") : obj.Entry.Image[i].includes(".jpg") ? (split = obj.Entry.Image[i].split(".jpg"), newURL = split[0] + "-preview.jpg#preview") : obj.Entry.Image[i].includes(".png") ? (split = obj.Entry.Image[i].split(".png"), newURL = split[0] + "-preview.png#preview") : obj.Entry.Image[i].includes(".webp") && (split = obj.Entry.Image[i].split(".webp"), newURL = split[0] + "-preview.webp#preview"), $(".Gallery").append('<img loading="lazy" class="' + className + '" alt="Image' + self.ImageIndex + '"onerror = "this.style=\'display:none !important;\'"' + '" width="300px" height="169px" class="fadein" id="' + self.ImageIndex + '" onClick="JavaScriptGallery.openViewer(this.id)" src="' + newURL + '"/>'), self.ImageIndex++
                        }
                    }
                })), this.addPlayer()
            }
            AjaxCall(obj, i) {
                return obj.Entry.Image[i].includes(".jpeg#preview") ? 2 : obj.Entry.Image[i].includes(".jpg#preview") ? 2 : obj.Entry.Image[i].includes(".png#preview") ? 2 : obj.Entry.Image[i].includes(".webp#preview") ? 2 : 1
            }
            checkPreviewState(url) {
                let newURL = url;
                return url.includes("-preview.jpeg#preview") ? (split = url.split("-preview.jpeg#preview"), newURL = split[0] + ".jpeg") : url.includes("-preview.jpg#preview") ? (split = url.split("-preview.jpg#preview"), newURL = split[0] + ".jpg") : url.includes("-preview.png#preview") ? (split = url.split("-preview.png#preview"), newURL = split[0] + ".png") : url.includes("-preview.webp#preview") && (split = url.split("-preview.webp#preview"), newURL = split[0] + ".webp"), newURL
            }
            addImageViewer() {
                var self = this;
                0 == this.added && ($("body").append('<div style="background-color:' + this.backgroundcolor + ';" class="GalleryViewer"></div>'), $(".GalleryViewer").append('<img class="ViewerImage" id="ViewerImage" src="" onerror = "this.style=\'display:none !important;\'" />'), $(".GalleryViewer").append('<svg onClick="JavaScriptGallery.left()" class="ArrowLeft" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/></svg>'), $(".GalleryViewer").append('<svg onClick="JavaScriptGallery.right()" class="Arrowright"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>'), $(".GalleryViewer").append('<svg onClick="JavaScriptGallery.closeViewer()" class="GalleryViewerClose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>'), 1 == this.enableViewOriginalPictureVal && ($(".GalleryViewer").append('<svg onClick="JavaScriptGallery.openImage()" class="GalleryViewerOpen"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>'), $(".GalleryViewer").append('<svg onClick="JavaScriptGallery.zoom()" class="GalleryViewerZoom" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/><path d="M12 10h-2v2H9v-2H7V9h2V7h1v2h2v1z"/></svg>')), 1 == this.share && ($(".GalleryViewer").append('<svg onClick="JavaScriptGallery.Share()" class="GalleryViewerShare" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/></svg>'), $(".GalleryViewer").append('<div class="sharebuttons"></div>'), $(".sharebuttons").append('<p onClick="JavaScriptGallery.shareFacebook()">Facebook</p>'), $(".sharebuttons").append('<p onClick="JavaScriptGallery.shareTwitter()">Twitter</p>'), $(".sharebuttons").append('<p onClick="JavaScriptGallery.shareGetLink()">Get the Link</p>')), this.added = 1, $(".GalleryViewer").hide())
            }
            addPlayer() {
                var self = this;
                0 == this.added && ($("body").append('<div style="background-color:' + this.backgroundcolor + ';" class="GalleryViewer"></div>'), $(".GalleryViewer").append('<img class="ViewerImage" id="ViewerImage" src="" onerror = "this.style=\'display:none !important;\'" />'), $(".GalleryViewer").append('<video class="ViewerVideo" id="ViewerVideo" autoplay="" muted="" loop="" controls> <source src="" type="video/mp4"> </video>'), $(".GalleryViewer").append('<svg onClick="JavaScriptGallery.left()" class="ArrowLeft" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/></svg>'), $(".GalleryViewer").append('<svg onClick="JavaScriptGallery.right()" class="Arrowright"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>'), $(".GalleryViewer").append('<svg onClick="JavaScriptGallery.closeViewer()" class="GalleryViewerClose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>'), 1 == this.enableViewOriginalPictureVal && ($(".GalleryViewer").append('<svg onClick="JavaScriptGallery.openImage()" class="GalleryViewerOpen"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>'), $(".GalleryViewer").append('<svg onClick="JavaScriptGallery.zoom()" class="GalleryViewerZoom" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/><path d="M12 10h-2v2H9v-2H7V9h2V7h1v2h2v1z"/></svg>')), 1 == this.share && ($(".GalleryViewer").append('<svg onClick="JavaScriptGallery.Share()" class="GalleryViewerShare" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="48px" height="48px"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/></svg>'), $(".GalleryViewer").append('<div class="sharebuttons"></div>'), $(".sharebuttons").append('<p onClick="JavaScriptGallery.shareFacebook()">Facebook</p>'), $(".sharebuttons").append('<p onClick="JavaScriptGallery.shareTwitter()">Twitter</p>'), $(".sharebuttons").append('<p onClick="JavaScriptGallery.shareGetLink()">Get the Link</p>')), this.added = 1, $(".GalleryViewer").hide(), $(".ViewerVideo").hide())
            }
            closeViewer() {
                $("body").css("overflow", "unset"), $(".GalleryViewer").hide(), $(".Arrowright").show(), $(".ArrowLeft").show(), $(".sharebuttons").hide(), $(".ViewerImage").css("object-fit", "contain"), $(".ViewerImage").animate({
                    height: "55%",
                    "max-height": "80%"
                }, 0), $(".ViewerImage").css("height", "unset"), $(".ViewerImage").css({
                    width: "",
                    "max-height": "80%",
                    top: "0",
                    right: "0",
                    left: "0"
                }), $(".ViewerImage").draggable({
                    disabled: !0
                }), this.zoomVal = 0, monoImageView = 0, monoImageViewURL = ""
            }
            checkPreviewState(url) {
                let newURL = url,
                    split;
                return url.includes("-preview.jpeg#preview") ? (split = url.split("-preview.jpeg#preview"), newURL = split[0] + ".jpeg") : url.includes("-preview.jpg#preview") ? (split = url.split("-preview.jpg#preview"), newURL = split[0] + ".jpg") : url.includes("-preview.png#preview") ? (split = url.split("-preview.png#preview"), newURL = split[0] + ".png") : url.includes("-preview.webp #preview") && (split = url.split("-preview.webp #preview"), newURL = split[0] + ".webp "), newURL
            }
            openViewer(clicked_id) {
                let type;
                if ("VIDEO" == this.CheckRessourceType(clicked_id)) {
                    $("body").css("overflow", "hidden"), this.viewerPosition = parseInt(clicked_id);
                    var url = $("#" + clicked_id + " source").attr("src");
                    url = this.checkPreviewState(url), $(".ViewerVideo > source").attr("src", url), $(".ViewerVideo")[0].load(), $(".ViewerImage").hide(), $(".ViewerVideo").show(), $(".GalleryViewer").show()
                } else {
                    $("body").css("overflow", "hidden"), this.viewerPosition = parseInt(clicked_id);
                    var url = document.getElementById(clicked_id).src;
                    url = this.checkPreviewState(url), $(".ViewerImage").attr("src", url), this.setParamsByRatioOfImage(url), $(".GalleryViewer").show(), $(".ViewerImage").show(), $(".ViewerVideo").hide()
                }
            }
            left() {
                if ($(".ViewerImage").css({
                        width: "80%",
                        "max-height": "80%",
                        top: "0",
                        right: "0",
                        left: "0"
                    }), $(".ViewerImage").draggable({
                        disabled: !0
                    }), $(".ViewerImage").css("object-fit", "contain"), $(".ViewerImage").animate({
                        height: "55%",
                        "max-height": "80%"
                    }, 1), $(".ViewerImage").css("height", "unset"), $(".ViewerVideo").css({
                        width: "80%",
                        "max-height": "80%",
                        top: "0",
                        right: "0",
                        left: "0"
                    }), $(".ViewerVideo").draggable({
                        disabled: !0
                    }), $(".ViewerVideo").animate({
                        height: "55%",
                        "max-height": "80%"
                    }, 1), $(".ViewerVideo").css("height", "unset"), this.zoomVal = 0, this.viewerPosition = this.viewerPosition - 1, this.viewerPosition >= 0) {
                    let new_type;
                    if ("VIDEO" == this.CheckRessourceType(this.viewerPosition)) {
                        var url = $("#" + this.viewerPosition + " source").attr("src");
                        $(".ViewerVideo > source").attr("src", url), $(".ViewerVideo")[0].load(), this.transitionLeft(this.transition, "ViewerVideo"), $(".ViewerImage").hide(), $(".ViewerVideo").show(), $(".GalleryViewer").show()
                    } else {
                        var url = document.getElementById(this.viewerPosition).src;
                        url = this.checkPreviewState(url), $(".ViewerImage").attr("src", url), this.setParamsByRatioOfImage(url), this.transitionLeft(this.transition, "ViewerImage"), $(".ViewerImage").show(), $(".ViewerVideo").hide()
                    }
                } else this.viewerPosition = this.viewerPosition + 1
            }
            right() {
                if ($(".ViewerImage").css({
                        width: "80%",
                        "max-height": "80%",
                        top: "0",
                        right: "0",
                        left: "0"
                    }), $(".ViewerImage").draggable({
                        disabled: !0
                    }), $(".ViewerImage").css("object-fit", "contain"), $(".ViewerImage").animate({
                        height: "55%",
                        "max-height": "80%"
                    }, 1), $(".ViewerImage").css("height", "unset"), $(".ViewerVideo").css({
                        width: "80%",
                        "max-height": "80%",
                        top: "0",
                        right: "0",
                        left: "0"
                    }), $(".ViewerVideo").draggable({
                        disabled: !0
                    }), $(".ViewerVideo").animate({
                        height: "55%",
                        "max-height": "80%"
                    }, 1), $(".ViewerVideo").css("height", "unset"), this.zoomVal = 0, this.viewerPosition = this.viewerPosition + 1, this.viewerPosition < this.ImageIndex) {
                    let new_type;
                    if ("VIDEO" == this.CheckRessourceType(this.viewerPosition)) {
                        var url = $("#" + this.viewerPosition + " source").attr("src");
                        $(".ViewerVideo > source").attr("src", url), $(".ViewerVideo")[0].load(), this.transitionRight(this.transition, "ViewerVideo"), $(".ViewerImage").hide(), $(".ViewerVideo").show(), $(".GalleryViewer").show()
                    } else {
                        var url = document.getElementById(this.viewerPosition).src;
                        url = this.checkPreviewState(url), $(".ViewerImage").attr("src", url), this.setParamsByRatioOfImage(url), this.transitionRight(this.transition, "ViewerImage"), $(".ViewerImage").show(), $(".ViewerVideo").hide()
                    }
                } else this.viewerPosition = this.viewerPosition - 1
            }
            transitionLeft(transition, classname) {
                "opacity" == transition && ($("." + classname).css("opacity", "0.4"), $("." + classname).animate({
                    opacity: "1"
                }, 200)), "zoomin" == transition && ($("." + classname).css("width", "40%"), $("." + classname).animate({
                    width: "80%"
                }, "slow")), "slide" == transition && ($("." + classname).css("left", "-500px"), $("." + classname).animate({
                    left: "0"
                }, 200)), "slideAndZoom" == transition && ($("." + classname).css("left", "-500px"), $("." + classname).animate({
                    left: "0"
                }, 200), $("." + classname).css("left", "500px"), $("." + classname).css("opacity", "0.4"), $("." + classname).css("width", "150px"), $("." + classname).animate({
                    left: "0",
                    opacity: "1",
                    width: "80%"
                })), "slideZoom" == transition && ($("." + classname).css("left", "-500px"), $("." + classname).css("opacity", "0.4"), $("." + classname).css("width", "150px"), $("." + classname).animate({
                    left: "0",
                    opacity: "1",
                    width: "80%"
                })), "ZoominFast" == transition && ($("." + classname).css("width", "0"), $("." + classname).animate({
                    width: "100%"
                })), "bounce" == transition && ($("." + classname).css("top", "-100"), $("." + classname).animate({
                    top: "100"
                }, 150), $("." + classname).animate({
                    top: "-100"
                }, 150), $("." + classname).animate({
                    top: "100"
                }, 150), $("." + classname).animate({
                    top: "0"
                }, 150)), "puffzoom" == transition && ($("." + classname).css("width", "10%"), $("." + classname).css("opacity", "0.2"), $("." + classname).animate({
                    width: "80%"
                }, 300), $("." + classname).animate({
                    opacity: "1"
                }, 100))
            }
            transitionRight(transition, classname) {
                "opacity" == transition && ($("." + classname).css("opacity", "0.4"), $("." + classname).animate({
                    opacity: "1"
                }, 200)), "zoomin" == transition && ($("." + classname).css("width", "40%"), $("." + classname).animate({
                    width: "80%"
                }, "slow")), "slide" == transition && ($("." + classname).css("left", "500px"), $("." + classname).animate({
                    left: "0"
                }, 200)), "slideAndZoom" == transition && ($("." + classname).css("left", "500px"), $("." + classname).animate({
                    left: "0"
                }, 200), $("." + classname).css("left", "500px"), $("." + classname).css("opacity", "0.4"), $("." + classname).css("width", "150px"), $("." + classname).animate({
                    left: "0",
                    opacity: "1",
                    width: "80%"
                })), "slideZoom" == transition && ($("." + classname).css("left", "500px"), $("." + classname).css("opacity", "0.4"), $("." + classname).css("width", "150px"), $("." + classname).animate({
                    left: "0",
                    opacity: "1",
                    width: "80%"
                })), "ZoominFast" == transition && ($("." + classname).css("width", "0"), $("." + classname).animate({
                    width: "100%"
                })), "bounce" == transition && ($("." + classname).css("top", "-100"), $("." + classname).animate({
                    top: "100"
                }, 150), $("." + classname).animate({
                    top: "-100"
                }, 150), $("." + classname).animate({
                    top: "100"
                }, 150), $("." + classname).animate({
                    top: "0"
                }, 150)), "puffzoom" == transition && ($("." + classname).css("width", "10%"), $("." + classname).css("opacity", "0.2"), $("." + classname).animate({
                    width: "80%"
                }, 300), $("." + classname).animate({
                    opacity: "1"
                }, 100))
            }
            setGalleryTransition(getTransition) {
                this.transition = getTransition
            }
            openImage() {
                if (1 == monoImageView) window.location = monoImageViewURL;
                else {
                    let new_type;
                    if ("VIDEO" == this.CheckRessourceType(this.viewerPosition)) {
                        var url = $("#" + this.viewerPosition + " source").attr("src");
                        window.location = url
                    } else {
                        var url = document.getElementById(this.viewerPosition).src;
                        window.location = url
                    }
                }
            }
            zoom() {
                if (1 == this.zoomVal) {
                    $(".ViewerVideo").animate({
                        width: "80%",
                        "max-height": "80%",
                        top: "0",
                        right: "0",
                        left: "0"
                    }, 250), $(".ViewerVideo").css("height", "unset"), $(".ViewerVideo").draggable({
                        disabled: !0
                    });
                    var url = $(".ViewerImage").attr("src");
                    this.setParamsByRatioOfImage(url, !0), $(".ViewerImage").draggable({
                        disabled: !0
                    })
                } else {
                    var url = $("#" + this.viewerPosition + " source").attr("src");
                    $(".ViewerVideo").animate({
                        width: "130%",
                        right: "-15%",
                        left: "-15%"
                    }, 250), $(".ViewerVideo").css("max-height", "130%"), $(".ViewerVideo").css("height", "unset"), $(".ViewerVideo").css("max-width", "unset"), $(".ViewerVideo").draggable({
                        disabled: !1,
                        scroll: !1
                    }), $(".ViewerVideo").draggable({
                        cursor: "pointer"
                    });
                    var url = $(".ViewerImage").attr("src");
                    this.setParamsByRatioOfImage(url, !0), $(".ViewerImage").draggable({
                        disabled: !1,
                        scroll: !1
                    }), $(".ViewerImage").draggable({
                        cursor: "pointer"
                    })
                }
            }
            enableExtraButtons() {
                this.share = 1, this.enableViewOriginalPictureVal = 1
            }
            Share() {
                $(".sharebuttons").toggle(), $(".sharebuttons").css("height", "0px"), $(".sharebuttons").animate({
                    height: "60px"
                }, "slow")
            }
            shareFacebook() {
                if (1 == monoImageView) {
                    var url = document.getElementById(this.viewerPosition).src;
                    window.open("https://www.facebook.com/sharer/sharer.php?u=" + monoImageViewURL, "_blank")
                } else {
                    let new_type;
                    if ("VIDEO" == this.CheckRessourceType(this.viewerPosition)) {
                        var url = $("#" + this.viewerPosition + " source").attr("src");
                        window.open("https://www.facebook.com/sharer/sharer.php?u=" + url, "_blank")
                    } else {
                        var url = document.getElementById(this.viewerPosition).src;
                        window.open("https://www.facebook.com/sharer/sharer.php?u=" + url, "_blank")
                    }
                }
            }
            shareTwitter() {
                if (1 == monoImageView) window.open("https://twitter.com/intent/tweet?text=" + monoImageViewURL, "_blank");
                else {
                    let new_type;
                    if ("VIDEO" == this.CheckRessourceType(this.viewerPosition)) {
                        var url = $("#" + this.viewerPosition + " source").attr("src");
                        window.open("https://twitter.com/intent/tweet?text=" + url, "_blank")
                    } else {
                        var url = document.getElementById(this.viewerPosition).src;
                        window.open("https://twitter.com/intent/tweet?text=" + url, "_blank")
                    }
                }
            }
            shareGetLink() {
                if (1 == monoImageView) {
                    const el = document.createElement("textarea");
                    el.value = monoImageViewURL, document.body.appendChild(el), el.select(), document.execCommand("copy"), document.body.removeChild(el)
                } else {
                    let new_type;
                    if ("VIDEO" == this.CheckRessourceType(this.viewerPosition)) {
                        var url = $("#" + this.viewerPosition + " source").attr("src");
                        const el = document.createElement("textarea");
                        el.value = url, document.body.appendChild(el), el.select(), document.execCommand("copy"), document.body.removeChild(el)
                    } else {
                        var url = document.getElementById(this.viewerPosition).src;
                        const el = document.createElement("textarea");
                        el.value = url, document.body.appendChild(el), el.select(), document.execCommand("copy"), document.body.removeChild(el)
                    }
                }
            }
            setGalleryStyle(style) {
                this.galleryStyle = style
            }
            CheckRessourceType(id) {
                return document.getElementById(id).tagName
            }
            setParamsByRatioOfImage(url, zoom = !1) {
                var tmpImg = new Image;
                tmpImg.src = url;
                var self = this;
                $(tmpImg).on("load", (function() {
                    var widthValue, heightValue;
                    let calc = tmpImg.width / tmpImg.height;
                    zoom ? 0 == self.zoomVal ? calc < 1.25 ? ($(".ViewerImage").animate({
                        height: "130%"
                    }, "slow"), $(".ViewerImage").css("max-height", "130%"), self.zoomVal = 1) : ($(".ViewerImage").animate({
                        width: "130%",
                        right: "-15%",
                        left: "-15%"
                    }, 250), $(".ViewerImage").css("max-height", "130%"), $(".ViewerImage").css("height", "unset"), $(".ViewerImage").css("max-width", "unset"), self.zoomVal = 1) : calc < 1.25 ? ($(".ViewerImage").animate({
                        "max-height": "80%",
                        top: "0",
                        left: "0"
                    }, "slow"), self.zoomVal = 0) : ($(".ViewerImage").animate({
                        width: "80%",
                        "max-height": "80%",
                        top: "0",
                        right: "0",
                        left: "0"
                    }, 250), $(".ViewerImage").css("height", "unset"), self.zoomVal = 0) : calc < 1.25 ? $(".ViewerImage").css("width", "unset") : $(".ViewerImage").css("object-fit", "contain")
                }))
            }
            setAllSettings() {
                enableExtraButtons(), enableDoubleClick()
            }
            initGallerySlide(speedValue, animationValue, dotsValue) {
                this.speed = speedValue, this.animation = animationValue, this.dots = dotsValue;
                var self = this;
                $(".GallerySlide img").each((function(index) {
                    if (gallerySlideArray.push($(this)), gallerySlideArray.length > 2) $(this).hide(), 0 == this.animation && $(this).css({
                        right: "0%"
                    });
                    else {
                        $(this).css({
                            right: "0%"
                        });
                        const classes = $(this).attr("class");
                        classes.includes("addFill") && ($(".nav_left").addClass("fillForGallerySlide"), $(".nav_right").addClass("fillForGallerySlide"))
                    }
                    if (self.dots) {
                        $(".GallerySlideDots").append('<p class="dot"></p>');
                        let id = self.galleryPos;
                        self.selectDot(id)
                    }
                }))
            }
            selectDot(id) {
                this.dots && ($(".GallerySlideDots .dot").css({
                    "background-color": "rgb(173, 173, 173)"
                }), $(".GallerySlideDots .dot:nth-of-type(" + id + ")").css({
                    "background-color": "rgb(49, 49, 49);"
                }))
            }
            gallerySlideLeft() {
                if (this.galleryPos <= 1);
                else {
                    1 == this.animation ? $(gallerySlideArray[this.galleryPos]).animate({
                        right: "-100%"
                    }, this.speed) : $(gallerySlideArray[this.galleryPos]).hide(), this.galleryPos--;
                    const classes = $(gallerySlideArray[this.galleryPos]).attr("class");
                    classes.includes("addFill") ? ($(".nav_left").addClass("fillForGallerySlide"), $(".nav_right").addClass("fillForGallerySlide")) : ($(".nav_left").removeClass("fillForGallerySlide"), $(".nav_right").removeClass("fillForGallerySlide")), $(gallerySlideArray[this.galleryPos]).show(), this.selectDot(this.galleryPos), 1 == this.animation && $(gallerySlideArray[this.galleryPos]).animate({
                        right: "0%"
                    }, this.speed)
                }
            }
            gallerySlideRight() {
                if (this.galleryPos == gallerySlideArray.length - 1);
                else {
                    1 == this.animation ? $(gallerySlideArray[this.galleryPos]).animate({
                        right: "100%"
                    }, this.speed) : $(gallerySlideArray[this.galleryPos]).hide(), this.galleryPos++;
                    const classes = $(gallerySlideArray[this.galleryPos]).attr("class");
                    classes.includes("addFill") ? ($(".nav_left").addClass("fillForGallerySlide"), $(".nav_right").addClass("fillForGallerySlide")) : ($(".nav_left").removeClass("fillForGallerySlide"), $(".nav_right").removeClass("fillForGallerySlide")), $(gallerySlideArray[this.galleryPos]).show(), this.selectDot(this.galleryPos), 1 == this.animation && $(gallerySlideArray[this.galleryPos]).animate({
                        right: "0%"
                    }, this.speed)
                }
            }
            initMove() {
                if (0 == this.disabelInitMove) {
                    $("move").each((function(index) {
                        const id = $(this).attr("id"),
                            media = $(this).attr("mediaquery");
                        var width;
                        if ($(window).width() < media) {
                            const elementID = id.split("move_");
                            $("unmove#un" + id).length || $("#element_" + elementID[1]).after("<unmove id=un" + id + " mediaquery=" + media + "></unmove>"), $("#element_" + elementID[1]).appendTo("#" + id)
                        }
                    })), $("unmove").each((function(index) {
                        const id = $(this).attr("id"),
                            media = $(this).attr("mediaquery");
                        var width;
                        if ($(window).width() > media) {
                            const elementID = id.split("unmove_");
                            $("#element_" + elementID[1]).appendTo("#" + id)
                        }
                    }));
                    var self = this;
                    $(window).resize((function() {
                        self.initMove(), self.disabelInitMove = !0, setTimeout((function() {
                            self.disabelInitMove = !1
                        }), 400)
                    }))
                }
            }
            initGallery() {
                "tiles" == this.galleryStyle && (className = "tiles"), "full" == this.galleryStyle && (className = "full"), "center" == this.galleryStyle && (className = "center"), "Circles" == this.galleryStyle && (className = "Circles"), "mosaic" == this.galleryStyle && (className = "mosaic"), "mosaic" != className || $(".Gallery").hide();
                var self = this;
                $(".addToGallery").each((function() {
                    $(this).attr("id", self.ImageIndex), $(this).addClass("addedToGallery"), self.ImageIndex++
                })), $(".Gallery img,.Gallery video").each((function(index) {
                    $(this).attr("id", self.ImageIndex), $(this).attr("class", className), $(this).attr("onClick", "JavaScriptGallery.openViewer(this.id);"), self.ImageIndex++
                })), this.addPlayer()
            }
            enableKeydownESC() {
                $(document).keydown((function(e) {
                    27 == e.keyCode && this.closeViewer()
                }))
            }
            Debug() {
                const output = {
                    added: this.added,
                    ImageIndex: this.ImageIndex,
                    viewerPosition: this.viewerPosition,
                    transition: this.transition,
                    enableViewOriginalPictureVal: this.enableViewOriginalPictureVal,
                    zoomVal: this.zoomVal,
                    share: this.share,
                    monoImageView: monoImageView,
                    monoImageViewURL: monoImageViewURL,
                    backgroundcolor: this.backgroundcolor,
                    galleryStyle: this.galleryStyle,
                    AutoWidth: AutoWidth
                };
                console.log(output)
            }
        }
        JavaScriptGallery = new JavaScriptGallery, $(document).ready((function() {
            for (i = 0; i <= 30; i++) array[i] = 0;
            $(".galleryJS").click((function() {
                if ($(this).hasClass("addToGallery")) JavaScriptGallery.openViewer($(this).attr("id"));
                else if (null == (url = $(this).attr("src")) && $(this).find("source").length > 0) {
                    var url = $(this).find("source").attr("src");
                    JavaScriptGallery.addImageViewer(), $(".ViewerVideo > source").attr("src", url), $(".ViewerVideo")[0].load(), $(".ViewerImage").hide(), $(".ViewerVideo").show(), $(".GalleryViewer").show(), $(this).hasClass("addedToGallery") ? ($(".Arrowright").show(), $(".ArrowLeft").show()) : ($(".Arrowright").hide(), $(".ArrowLeft").hide()), monoImageView = 1, monoImageViewURL = url
                } else JavaScriptGallery.addImageViewer(), $(".ViewerImage").attr("src", url), $(".GalleryViewer").show(), $(this).hasClass("addedToGallery") ? ($(".Arrowright").show(), $(".ArrowLeft").show()) : ($(".Arrowright").hide(), $(".ArrowLeft").hide()), $(".ViewerImage").show(), $(".ViewerVideo").hide(), monoImageView = 1, monoImageViewURL = url
            }))
        })), $(window).on("resize", (function() {
            1 == AutoWidth && (this.GalleryWidth = $(".Gallery").width(), this.GalleryWidth > 1920 && (galleryWidth4 = 300), this.GalleryWidth < 1920 && (galleryWidth4 = this.GalleryWidth / 5 - 20), this.GalleryWidth < 1400 && (galleryWidth4 = this.GalleryWidth / 4 - 20), this.GalleryWidth < 1024 && (galleryWidth4 = this.GalleryWidth / 3 - 20), this.GalleryWidth < 786 && (galleryWidth4 = this.GalleryWidth / 2 - 20), this.GalleryWidth < 450 && (galleryWidth4 = this.GalleryWidth / 1 - 20), $(".Gallery img").width(galleryWidth4)), "mosaic" == className && JavaScriptGallery.mosaic()
        })), $(document).ready((function() {
            1 == AutoWidth && (this.GalleryWidth = $(".Gallery").width(), this.GalleryWidth > 1920 && (galleryWidth4 = 300), this.GalleryWidth < 1920 && (galleryWidth4 = this.GalleryWidth / 5 - 20), this.GalleryWidth < 1400 && (galleryWidth4 = this.GalleryWidth / 4 - 20), this.GalleryWidth < 1024 && (galleryWidth4 = this.GalleryWidth / 3 - 20), this.GalleryWidth < 786 && (galleryWidth4 = this.GalleryWidth / 2 - 20), this.GalleryWidth < 450 && (galleryWidth4 = this.GalleryWidth / 1 - 20), $(".Gallery img").width(galleryWidth4)), "mosaic" == className && JavaScriptGallery.mosaic()
        }));
    </script>
    <script>
        function changeGalleryTransition() {
            var selectedTransition = document.querySelector('input[name="transition"]:checked').value;
            JavaScriptGallery.setGalleryTransition(selectedTransition);
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #000d1a;
        }

        h1 {
            text-align: center;
            color: white;
            font-family: 'Courier New';
        }

        p {
            text-align: center;
            color: white;
        }

        a {
            color: white;
            text-decoration: none;
        }

        .text:hover {
            font-weight: bold;
            font-size: 30px;
            transition: font-size ease-out .3s;
            transition-delay: .3s;
            transform: translateZ(0);
            will-change: transform;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: inherit;
            min-width: 30%;
            max-width: 60%;
            width: auto;
            height: auto;
            background-color: #04AA6D;
            margin-left: auto;
            margin-right: auto;
            table-layout: fixed;
            white-space: nowrap;
            overflow: hidden;
        }

        td {
            width: 20%;
            border: 1px solid #dddddd;
            font-size: 120%;
            font-weight: bolder;
            text-align: center;
            padding: 1%;
        }

        th {
            border: 1px solid #dddddd;
            font-size: 30px;
            text-align: center;
            padding: 1%;
        }

        td:hover {
            background-color: coral;
        }

        .tooltip {
            position: relative;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: -50%;
            left: 50%;
            margin-left: -60px;
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: -30%;
            left: 50%;
            transform: rotate(180deg);
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: black transparent transparent transparent;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
        }

        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 12px;
            border: none;
            outline: none;
            background-color: #4dc1f7;
            color: white;
            cursor: pointer;
            padding: 10px;
            border-radius: 30px;
        }

        #myBtn:hover {
            background-color: #555;
        }

        .modalName:hover {
            background-color: coral !important;
        }

        label {
            color: #ffffff;
        }

        img {
            object-fit: cover;
        }

        form>div:nth-child(1) {
            width: 55%;
        }

        form>div:nth-child(2) {
            width: 12%;
        }

        form>div:nth-child(3) {
            width: 8%;
        }

        form>div:nth-child(4) {
            width: 10%;
        }


        form>div:nth-child(5) {
            flex: 8%;
        }


        form>div:nth-child(6) {
            flex: 8%;
        }


        form>div>input {
            width: -webkit-fill-available;
        }

        form {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        @media (max-width: 600px) {
            form {
                position: relative;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                flex-wrap: nowrap;
                margin-bottom: 16px;
            }

            form>div:nth-child(1) {
                width: 75%;
            }

            form>div:nth-child(2) {
                width: 21%;
            }

            form>div:nth-child(3) {
                width: 21%;
            }

            form>div:nth-child(4) {
                width: 21%;
            }


            form>div:nth-child(5) {
                flex: 8%;
            }


            form>div:nth-child(6) {
                width: 21%;
            }
        }

        input[type=text] {
            background-color: #3CBC8D;
            color: white;
            padding: 10px 10px;
            margin: 4px 2px;
        }

        input[type=button],
        input[type=submit],
        input[type=reset] {
            background-color: #04AA6D;
            border: none;
            color: white;
            padding: 10px 10px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
        }

        input[type=button]:hover,
        input[type=submit]:hover,
        input[type=reset]:hover,
        input[type=text]:hover,
        input[type=text]:focus {
            background-color: coral;
        }

        select {
            background-color: #3CBC8D;
            color: white;
            padding: 10px 10px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .pis-center-navbar {
            display: flex;
            flex-direction: row;
            align-items: center;
            flex-wrap: wrap;
            align-content: space-between;
            justify-content: center;
        }

        .pis-bar-item {
            text-align: center;
        }

        .pis-bar .pis-button {
            padding: 16px;
        }

        .pis-button {
            border: none;
            display: inline-block;
            padding: 8px 16px;
            vertical-align: middle;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            background-color: inherit;
            text-align: center;
            cursor: pointer;
            white-space: nowrap;
        }

        .pis-button {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .pis-button:disabled {
            cursor: not-allowed;
            opacity: 0.3;
        }


        .pis-bar .pis-button {
            white-space: normal;
        }

        .pis-button:hover {
            color: #000 !important;
            background-color: #ccc !important;
        }

        .pis-bar {
            width: 100%;
            overflow: hidden;
        }

        .pis-bar .pis-button {
            white-space: normal;
        }

        .pis-black {
            color: #fff !important;
            background-color: #000 !important;
        }

        .pis-card {
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        }

        .pis-bar .pis-bar-item {
            padding: 10px 4px;
            float: left;
            border: none;
            display: block;
            outline: 0;
        }

        .GallerySlide {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden
        }

        .GallerySlide img {
            position: absolute;
            width: 100%;
            height: 100%;
            right: -100%
        }

        .GallerySlide .nav_left {
            top: calc(50% - 24px);
            position: absolute;
            z-index: 99;
            left: 10px;
            cursor: pointer
        }

        .GallerySlide .nav_right {
            top: calc(50% - 24px);
            position: absolute;
            z-index: 99;
            right: 10px;
            cursor: pointer
        }

        .fillForGallerySlide {
            fill: #000
        }

        .GallerySlideDots {
            width: 100%;
            height: 20px;
            margin-top: 5px;
            text-align: center
        }

        .GallerySlideDots .dot {
            width: 20px;
            height: 20px;
            background-color: #adadad;
            border-radius: 360px;
            display: inline-block;
            margin: 0 5px
        }

        .Gallery p {
            font-size: 30px;
            font-family: calibri, Arial, sans-serif;
            margin-top: 30px;
            margin-bottom: 5px
        }

        .Gallery video {
            width: 300px;
            max-height: 169px;
            min-height: 169px;
            margin: 6px;
            object-fit: cover;
            border-radius: 5px
        }

        .Gallery video {
            width: 300px;
            max-height: 169px;
            min-height: 169px;
            margin: 6px;
            object-fit: cover;
            border-radius: 5px
        }

        .Gallery video.tiles {
            width: 300px;
            max-height: 169px;
            min-height: 169px;
            margin: -2px;
            object-fit: cover;
            border-radius: 0
        }

        .Gallery video.full {
            width: 100%;
            height: auto;
            max-height: unset;
            margin: -2px;
            object-fit: cover;
            border-radius: 0
        }

        .Gallery video.center {
            width: 30%;
            max-width: 30%;
            max-height: unset;
            min-height: unset;
            margin: 10px auto;
            display: block;
            object-fit: cover;
            border-radius: 0
        }

        .Gallery video.Circles {
            width: 169px;
            max-height: 169px;
            min-height: 169px;
            margin: 4px;
            object-fit: cover;
            border-radius: 160px
        }

        .Gallery video.mosaic {
            margin: 2px;
            object-fit: cover;
            border-radius: 0;
            vertical-align: top;
            display: inline-block
        }

        .Gallery img {
            width: 300px;
            max-height: 169px;
            min-height: 169px;
            margin: 6px;
            object-fit: cover;
            border-radius: 5px
        }

        .Gallery img.tiles {
            width: 300px;
            max-height: 169px;
            min-height: 169px;
            margin: -2px;
            object-fit: cover;
            border-radius: 0
        }

        .Gallery img.full {
            width: 100%;
            height: auto;
            max-height: unset;
            margin: -2px;
            object-fit: cover;
            border-radius: 0
        }

        .Gallery img.center {
            width: 30%;
            max-width: 30%;
            max-height: unset;
            min-height: unset;
            margin: 10px auto;
            display: block;
            object-fit: cover;
            border-radius: 0
        }

        .Gallery img.Circles {
            width: 169px;
            max-height: 169px;
            min-height: 169px;
            margin: 4px;
            object-fit: cover;
            border-radius: 160px
        }

        .Gallery img.mosaic {
            margin: 2px;
            object-fit: cover;
            border-radius: 0;
            vertical-align: top;
            display: inline-block
        }

        .Gallery {
            margin-top: 150px;
            margin-bottom: 150px;
            position: relative;
            display: table
        }

        .GalleryViewer {
            background-color: #000000e8;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            z-index: 9999999
        }

        .GalleryViewer img {
            width: 80%;
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            margin-top: auto;
            margin-bottom: auto;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            text-align: center;
            animation-name: zommin;
            animation-duration: .6s;
            border-radius: 10px
        }

        .GalleryViewer Video {
            width: 80%;
            max-width: 80%;
            max-height: 80%;
            object-fit: cover;
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            margin-top: auto;
            margin-bottom: auto;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            text-align: center;
            animation-name: zommin;
            animation-duration: .6s;
            border-radius: 10px
        }

        .GalleryViewer svg.ArrowLeft {
            margin-bottom: auto;
            margin-top: auto;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            text-align: center;
            animation-name: zommin;
            animation-duration: .6s;
            border-radius: 10px;
            width: 50px;
            right: unset;
            position: absolute
        }

        .GalleryViewer .Arrowright {
            margin-bottom: auto;
            margin-top: auto;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            text-align: center;
            animation-name: zommin;
            animation-duration: .6s;
            border-radius: 10px;
            width: 50px;
            left: unset;
            position: absolute
        }

        .GalleryViewer svg.GalleryViewerClose {
            position: absolute;
            width: 25px;
            left: unset;
            bottom: unset;
            margin-right: 10px;
            margin-top: 10px;
            right: 0
        }

        .GalleryViewer svg.GalleryViewerOpen {
            position: absolute;
            width: 25px;
            left: unset;
            bottom: unset;
            margin-right: 60px;
            margin-top: 10px;
            right: 0
        }

        .GalleryViewer svg.GalleryViewerShare {
            position: absolute;
            width: 25px;
            left: unset;
            bottom: unset;
            margin-right: 110px;
            margin-top: 10px;
            right: 0
        }

        .GalleryViewer svg.GalleryViewerZoom {
            position: absolute;
            width: 25px;
            left: unset;
            bottom: unset;
            margin-right: 110px;
            margin-top: 10px;
            right: 0
        }

        .GalleryViewer .sharebuttons {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            width: 100px;
            position: absolute;
            left: unset;
            bottom: unset;
            margin-right: 50px;
            margin-top: 55px;
            right: 0;
            display: none
        }

        .GalleryViewer .sharebuttons p {
            cursor: pointer
        }

        .GalleryViewer svg {
            cursor: pointer
        }

        .galleryJS {
            border-radius: 5px;
            object-fit: cover
        }

        @keyframes zommin {
            0% {
                transform: scale(0)
            }

            100% {
                transform: scale(1)
            }
        }

        @media only screen and (max-width:500px) {
            .Gallery img {
                width: calc(100% - 20px)
            }

            .Gallery video {
                width: calc(100% - 20px)
            }
        }

        @media only screen and (max-width:375px) {
            .GalleryViewer svg.ArrowLeft {
                width: 37px
            }

            .GalleryViewer .Arrowright {
                width: 37px
            }
        }

        body>div.GalleryViewer>svg.GalleryViewerShare {
            display: none;
        }
    </style>
</head>

<body>
    <header>
        <div class="pis-top">
            <div class="pis-bar pis-black pis-card" style="display:block" id="myNavbar">
                <div class="pis-center-navbar">
                    <a href="#" onclick="history.back()" target="_self" class="pis-bar-item pis-button" style="flex: 0%; margin-bottom: 16px;">Go Back</a>

                    <a href="./" class="pis-bar-item pis-button" style="flex: 0%; margin-bottom: 16px;">Clean</a>
                </div>
            </div>
        </div>
    </header>
    <form action=" ./" method="get" class="pis-bar-item">
        <div class="tooltip pis-bar-item">
            <input type="text" name="start_link" placeholder="Start Link">
            <span class="tooltiptext">Start Link</span>
        </div>
        <div class="tooltip pis-bar-item">
            <input type="text" name="end_link" placeholder="End Link">
            <span class="tooltiptext">End Link</span>
        </div>
        <div class="tooltip pis-bar-item">
            <input type="text" name="start_number" placeholder="Start Number">
            <span class="tooltiptext">Start Number</span>
        </div>
        <div class="tooltip pis-bar-item">
            <input type="text" name="end_number" placeholder="End Number">
            <span class="tooltiptext">End Number</span>
        </div>
        <div class="tooltip pis-bar-item">
            <select name="add_zero">
                <option value="1" selected>Add Zero</option>
                <option value="2">Remove zero</option>
            </select>
            <span class="tooltiptext">Add Zero?</span>
        </div>
        <div class="tooltip pis-bar-item">
            <input type="submit" class="pis-bar-item pis-button">
        </div>
    </form>
    <div>
        <h1>Select Gallery Style</h1>
        <form method="post">

            <input type="radio" name="gallery_style" value="" onchange="updateSession(this.value)" <?php if (isset($_SESSION['gallery_style']) && $_SESSION['gallery_style'] == '') {
                                                                                                        echo 'checked';
                                                                                                    } ?>><label for="gallery_style"> Default&nbsp</label>
            <input type="radio" name="gallery_style" value="tiles" onchange="updateSession(this.value)" <?php if (isset($_SESSION['gallery_style']) && $_SESSION['gallery_style'] == 'tiles') {
                                                                                                            echo 'checked';
                                                                                                        } ?>><label for="gallery_style"> Tiles&nbsp</label>
            <input type="radio" name="gallery_style" value="center" onchange="updateSession(this.value)" <?php if (isset($_SESSION['gallery_style']) && $_SESSION['gallery_style'] == 'center') {
                                                                                                                echo 'checked';
                                                                                                            } ?>><label for="gallery_style"> Center&nbsp</label>
            <input type="radio" name="gallery_style" value="Circles" onchange="updateSession(this.value)" <?php if (isset($_SESSION['gallery_style']) && $_SESSION['gallery_style'] == 'Circles') {
                                                                                                                echo 'checked';
                                                                                                            } ?>><label for="gallery_style"> Circles&nbsp</label>
            <input type="radio" name="gallery_style" value="full" onchange="updateSession(this.value)" <?php if (isset($_SESSION['gallery_style']) && $_SESSION['gallery_style'] == 'full') {
                                                                                                            echo 'checked';
                                                                                                        } ?>><label for="gallery_style"> Full&nbsp</label>
            <input type="radio" name="gallery_style" value="mosaic" onchange="updateSession(this.value)" <?php if (isset($_SESSION['gallery_style']) && $_SESSION['gallery_style'] == 'mosaic') {
                                                                                                                echo 'checked';
                                                                                                            } ?>><label for="gallery_style"> Mosaic&nbsp</label>
        </form>
    </div>
    <script>
        function updateSession(gallery_style) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("gallery_style=" + gallery_style);
            location.reload();
        }
    </script>
    <div style="text-align: center" ;>
        <h1>Select Gallery Transition Type:</h1>
        <input type="radio" name="transition" value="opacity" onchange="changeGalleryTransition()" checked><label for="transition_type">Opacity&nbsp</label>
        <input type="radio" name="transition" value="zoomin" onchange="changeGalleryTransition()"><label for="transition_type">Zoomin&nbsp</label>
        <input type="radio" name="transition" value="slide" onchange="changeGalleryTransition()"><label for="transition_type">Slide&nbsp</label>
        <input type="radio" name="transition" value="slideAndZoom" onchange="changeGalleryTransition()"><label for="transition_type">SlideAndZoom&nbsp</label>
        <input type="radio" name="transition" value="slideZoom" onchange="changeGalleryTransition()"><label for="transition_type">SlideZoom&nbsp</label>
        <input type="radio" name="transition" value="ZoominFast" onchange="changeGalleryTransition()"><label for="transition_type">ZoominFast&nbsp</label>
        <input type="radio" name="transition" value="bounce" onchange="changeGalleryTransition()"><label for="transition_type">Bounce&nbsp</label>
        <input type="radio" name="transition" value="puffzoom" onchange="changeGalleryTransition()"><label for="transition_type">Puffzoom&nbsp</label>
    </div>

    <div style="display: flex; justify-content: center; flex-wrap: wrap; margin-left: 5%; margin-right: 5%; margin-bottom: 2%;">
        <div class="Gallery" style="margin-top: 0" ;></div>
    </div>
    <script>
        document.onkeydown = function(e) {
            switch (e.keyCode) {
                case 37:
                    JavaScriptGallery.left()
                    break;
                case 39:
                    JavaScriptGallery.right()
                    break;
                case 27:
                    JavaScriptGallery.closeViewer()
                    break;
            }
        };
        JavaScriptGallery.setGalleryStyle("<?php echo $_SESSION['gallery_style']; ?>");
        // JavaScriptGallery.setGalleryTransition("Slide");
        JavaScriptGallery.enableExtraButtons();
        JavaScriptGallery.enableAutoWidth();

        json =
            '{"Entry": { "Title": "", ' +
            '"Image": [ <?php
                        if ($start_link != null || $end_link != null || $start_number != null || $end_number != null) {
                            if ($end_number != null && $start_number != null) {
                                $diff = abs($end_number - $start_number) + 2;
                            } else {
                                $diff = null;
                            }
                            $highest_number = $diff - 1;

                            for ($i = 1; $i < $diff; $i++) {
                                $len_diff = ($_GET['add_zero'] == 1) ? strlen($highest_number) - strlen($start_number) : 0;
                                $url = urldecode($start_link . str_repeat("0", abs($len_diff)) . $start_number . $end_link);


                                echo ($highest_number == $i) ? "\"$url\"" : "\"$url\",' + '";


                                ($end_number > $start_number) ? $start_number++ : $start_number--;
                            }
                        }
                        ?> ]}}';
        JavaScriptGallery.addGallery(json);
        JavaScriptGallery.initGallerySlide(300, true, true);
        JavaScriptGallery.enableDoubleClick();
        JavaScriptGallery.initMove();
        JavaScriptGallery.enableKeydownESC();
    </script>
    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
    <script>
        let mybutton = document.getElementById("myBtn");

        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</body>

</html>