jQuery(document).ready(function () {

    jQuery('.filter-content ul li').click(function(){
        var termSelecter = jQuery(this).attr('data-term');
        var filterName = jQuery(this).parents('.filter-content').attr('data-filter');

        buildUrl(filterName , termSelecter);

    })

    function buildUrl(key,value) {
        key = encodeURIComponent(key); value = encodeURIComponent(value);

        var s = document.location.search;
        var kvp = key+"="+value;

        var r = new RegExp("(&|\\?)"+key+"=[^\&]*");

        s = s.replace(r,"$1"+kvp);

        if(!RegExp.$1) {s += (s.length>0 ? '&' : '?') + kvp;};

        //again, do what you will here
        document.location.search = s;
    }

});