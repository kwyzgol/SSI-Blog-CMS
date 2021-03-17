<script>
    function navigationSize()
    {
        if(document.getElementById("navigation").offsetHeight < document.getElementById("content").offsetHeight) document.getElementById("navigation").style.height = document.getElementById("content").offsetHeight + "px";
        else document.getElementById("content").style.height = document.getElementById("navigation").offsetHeight + "px"
    }
    
    navigationSize();
    window.onresize = navigationSize;
</script>