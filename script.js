//Javascript:
function postToController() {
    for (i = 0; i < document.getElementsByName('rating').length; i++) {
        if(document.getElementsByName('rating')[i].checked == true) {
            var ratingValue = document.getElementsByName('rating')[i].value;
            break;
        }
    }
    alert(ratingValue);
}