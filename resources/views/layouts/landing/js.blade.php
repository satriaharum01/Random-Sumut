
<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('lib/easing/easing.min.js')}}"></script>
<script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
<!-- Template Javascript -->
<script src="{{asset('js/main.js')}}"></script>

<script>
    var renderAsHtml = function(data, type, full) {
        return decHTMLifEnc(data);
    };
    var isEncHTML = function(str) {
        if (str.search(/&amp;/g) != -1 || str.search(/&lt;/g) != -1 || str.search(/&gt;/g) != -1)
            return true;
        else
            return false;
    };

    var decHTMLifEnc = function(str) {
        if (isEncHTML(str))
            return str.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>');
        return str;
    }
</script>