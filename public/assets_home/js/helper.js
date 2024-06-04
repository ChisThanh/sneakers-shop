var chatApp = $("#chat-app");
var boxIcon = $("#box-icon");
var close = $("#btn-close-box");
boxIcon.click(function (e) {
    chatApp.addClass('cart-visible');
});
close.click(function (e) {
    chatApp.removeClass('cart-visible');
});
